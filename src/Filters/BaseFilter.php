<?php

	namespace iranapp\Tools\Filters;

	use Illuminate\Database\Eloquent\Builder;
	use Illuminate\Support\Arr;
	use Illuminate\Support\Str;
	abstract class BaseFilter
	{
		/**
		 * @var
		 */
		private $filters;
		/**
		 * @var
		 */
		protected $query;

		/**
		 * BaseCriteria constructor.
		 *
		 * @param Builder $query
		 * @param array $filters
		 */
		public function __construct( $query, array $filters)
		{
			$this->filters = $filters;
			$this->query = $query;
		}

		/**
		 * @param $column_name
		 * @param $value
		 * @return Builder
		 */
		public abstract function default($column_name, $value);

		/**
		 * @return Builder
		 */
		public function apply()
		{

			foreach ($this->filters as $filter => $value) {

				if ($this->isFilterApplicable($filter) && $value != '') {
					$this->query = call_user_func_array([$this, $this->getFilterMethodName($filter)], [$value]);

				} else {
					if (method_exists($this, 'default') && $value != '') {

						if (preg_match('|^.{4}/.{1,2}/.{1,2}$|',$value)) {
							$value = conversion()->gregorian($value);
						}

						if ($value == 'true' || $value == 'false')
							$value = filter_var($value,FILTER_VALIDATE_BOOLEAN);

						$this->query = call_user_func_array([$this, 'default'], ['key' => $filter,'value' => $value]);

					}
				}

			}

			return $this->query;
		}

		/**
		 * @param string $filter
		 *
		 * @return bool
		 */
		private function isFilterApplicable(string $filter): bool
		{

			if (empty(Arr::get($this->filters, $filter))) {

				return false;
			}

			return $this->hasSuitableFilterMethod($filter);
		}

		/**
		 * @param string $filter
		 *
		 * @return bool
		 */
		private function hasSuitableFilterMethod(string $filter): bool
		{
			$methodName = $this->getFilterMethodName($filter);


			return method_exists($this, $methodName);
		}

		/**
		 * @param string $filter
		 *
		 * @return string
		 */
		private function getFilterMethodName(string $filter): string
		{
			return Str::camel($filter);
		}
	}
