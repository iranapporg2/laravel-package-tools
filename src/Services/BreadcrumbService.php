<?php

	namespace iranapp\Tools\Services;

	use Illuminate\Support\Facades\View;
	use Illuminate\Support\HtmlString;

	class BreadcrumbService {

		/**
		 * @var BreadCrumb[] $breadcrumbs
		 */
		protected static array $breadcrumbs = [];

		private function __construct() {
			self::$breadcrumbs[] = [];
		}

		public static function Push(string $title, $active = false,string $url = '') {

			self::$breadcrumbs[] = new BreadCrumb(count(self::$breadcrumbs) + 1,$title,$active ? 'active' : 'javascript:void()',$url);
			return self::class;

		}

		public static function Get() {
			return self::$breadcrumbs;
		}

	}

	class BreadCrumb {

		public $title,$active,$url,$id;

		public function __construct($id,$title,$active,$url = '') {
			$this->id = $id;
			$this->title = $title;
			$this->active = $active;
			$this->url = $url;
		}

	}
