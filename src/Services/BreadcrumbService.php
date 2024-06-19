<?php

    namespace iranapp\Tools\Services;

    use Illuminate\Support\Facades\View;
    use Illuminate\Support\HtmlString;

    class BreadcrumbService {

        protected static $breadcrumbs = [];

        private function __construct() {
            self::$breadcrumbs[] = [];
        }

        public static function Push(string $title, $active = false,string $url = '') {

            $breadcrumb['title'] = $title;
            $breadcrumb['active'] = $active ? 'active' : '';
            if ($url != '') $breadcrumb['link'] = $url;
            $breadcrumb['id'] = count(self::$breadcrumbs) + 1;

            self::$breadcrumbs[] = $breadcrumb;

            return self::class;

        }

        public static function Get() {
            return self::$breadcrumbs;
        }

    }
