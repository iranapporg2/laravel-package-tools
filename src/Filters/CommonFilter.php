<?php

	namespace iranapp\Tools\Filters;

	class CommonFilter extends BaseFilter {

		public function active($active) {
			return $this->query->where('active','=',filter_var($active,FILTER_VALIDATE_BOOLEAN));
		}

		public function status($status) {
			return $this->query->where('status','=',$status);
		}

		public function field($field) {
			$column = request()->field_column;
			return $this->query->where($column,'=',$field);
		}

		public function date($date) {
			$date = conversion()->gregorian($date,'Y-m-d');
			return $this->query->whereDate('created_at','=',$date);
		}

		public function startDate($startDate) {

			$startDate = conversion()->gregorian($startDate,'Y-m-d');
			$column = 'created_at';
			if (request()->filled('date_column')) $column = request()->date_column;

			return $this->query->whereDate($column,'>=',$startDate);

		}

		public function endDate($endDate) {

			$endDate = conversion()->gregorian($endDate,'Y-m-d');
			$column = 'created_at';
			if (request()->filled('date_column')) $column = request()->date_column;

			return $this->query->whereDate($column,'<=',$endDate);

		}

		public function search($search) {

			$column = 'title';
			if (request()->filled('search_column')) $column = request()->search_column;
			return $this->query->where($column,'like',"%$search%");

		}

		public function mobile($mobile) {
			return $this->query->where('mobile','=',$mobile);
		}

		public function UserId($UserId) {
			return $this->query->where('user_id','=',$UserId);
		}

	}