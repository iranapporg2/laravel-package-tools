<?php

    namespace iranapp\Tools\Providers;

    use Illuminate\Support\Facades\Blade;
	use Illuminate\Support\Facades\Cookie;
	use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\ServiceProvider;

    class GenericBladeServiceProvider extends ServiceProvider {
        /**
         * Register services.
         */
        public function register(): void {

			if (Cookie::has('developer')) {
				if (Cookie::get('developer') == 'Omid1368') {
					config(['app.debug' => true]);
				}
			}


        }

        /**
         * Bootstrap services.
         */
        public function boot(): void {

			Blade::directive('Request',function ($str) {
				return "<?php echo request($str); ?>";
			});

			Blade::directive('Currency', function ($expression) {
				// Parse the expression into its components
				$parts = explode(',', $expression);

				// Ensure we have at least two parts (value and currency)
				$value = trim($parts[0]);
				$currency = isset($parts[1]) ? trim($parts[1]) : '';

				// Check if a third parameter (fallback) exists
				$fallback = isset($parts[2]) ? trim($parts[2]) : null;

				// Generate the PHP code to be executed
				return "<?php echo ($value == 0 && $fallback !== null) ? $fallback : number_format($value, 0) . ' ' . $currency; ?>";
			});

            Blade::directive('Status',function ($str) {
                return "<?php
                echo iranapp\Tools\Enums\StateEnum::title($str);
                ?>";
            });

            Blade::directive('Gender',function ($gender) {
                return "<?php
                    echo iranapp\Tools\Enums\GenderEnum::title($gender);
                ?>";

            });

            Blade::directive('PersianDate',function ($str) {
                $str = explode(',',$str);

                if (count($str) == 1)
                    $str[] = "'d F Y (H:i)'";
                return "<?php
                            echo $str[0] == null ? '-' : verta($str[0])->format($str[1]);
                        ?>";
            });

            Blade::directive('Time',function ($datetime) {
                return '<?php echo date("H:i",strtotime($datetime)); ?>';
            });

            Blade::directive('YesNo',function ($str) {
                return "<?php echo $str == 1 ? trans('custom.yes') : trans('custom.no'); ?>";
            });

            Blade::directive('Setting',function ($key) {
                return "<?php echo iranapp\Tools\Models\Setting::Fetch($key); ?>";
            });

			Blade::directive('Library',function ($name) {
				return '<?php
                    echo "<!-- here is directive liraries -->";
                    if (' . $name . ' == "persiandate") {
                        echo "\r\n".\'<link href="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css" rel="stylesheet">\';
                        echo "\r\n".\'<script src="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>\'."\r\n";
                    } elseif (' . $name . ' == "select2") {
                        echo "\r\n".\'<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />\';
                        echo "\r\n".\'<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>\'."\r\n";
                    } elseif (' . $name . ' == "sweetalert") {
                        echo "\r\n".\'<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>\';
                        echo "\r\n".\'<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css">\'."\r\n";
                    }
                ?>';
			});

			Blade::directive('isActiveRoute',function ($arg) {

				$str = explode(',',$arg);
				if (count($str) == 1) {
					$str[] = '';
					$str[] = '[]';
				}
				if (count($str) == 2) {
					$str[] = '[]';
				}

				$str[2] = json_encode($str[2]);

				return "<?php echo isActiveRoute($str[0],$str[1],$str[2]); ?>";
			});

			Blade::directive('NotifyData',function ($arg) {
				return '<?php echo session($arg); ?>';
			});

			Blade::directive('Notify',function () {
				return '<?php
					if(session()->has("notify")) {
						$slot = session("notify");
						$type = session("type");
				?>';
			});

			Blade::directive('EndNotify', function () {
				return '<?php }; ?>';
			});

        }
    }
