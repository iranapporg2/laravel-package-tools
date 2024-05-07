<?php

    namespace Iranapp\Tools\Filters;

    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Support\Arr;
    use Illuminate\Support\Str;

    abstract class BaseFilter {

        /**
         * @var
         */
        protected $query;
        /**
         * @var
         */
        private $filters;

        /**
         * BaseCriteria constructor.
         *
         * @param Builder $query
         * @param array $filters
         */
        public function __construct($query, array $filters) {
            $this->filters = $filters;
            $this->query = $query;
        }

        /**
         * @return Builder
         */
        public function apply() {
            foreach ($this->filters as $filter => $value) {
                if ($this->isFilterApplicable($filter)) {
                    $this->query = call_user_func_array([$this, $this->getFilterMethodName($filter)], [$value]);
                }
            }

            return $this->query;
        }

        /**
         * @param string $filter
         *
         * @return bool
         */
        private function isFilterApplicable(string $filter): bool {

            if (Arr::get($this->filters, $filter) == '') {
                return false;
            }

            return $this->hasSuitableFilterMethod($filter);

        }

        /**
         * @param string $filter
         *
         * @return bool
         */
        private function hasSuitableFilterMethod(string $filter): bool {
            $methodName = $this->getFilterMethodName($filter);


            return method_exists($this, $methodName);
        }

        /**
         * @param string $filter
         *
         * @return string
         */
        private function getFilterMethodName(string $filter): string {
            return Str::camel($filter);
        }
    }
