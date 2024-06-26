<?php

    namespace iranapp\Tools\Providers;

    use App\Enums\GenderEnum;
    use App\Enums\StateEnum;
    use Illuminate\Support\Facades\Blade;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\ServiceProvider;

    class BladeServiceProvider extends ServiceProvider {
        /**
         * Register services.
         */
        public function register(): void {

        }

        /**
         * Bootstrap services.
         */
        public function boot(): void {

            Blade::directive('toCurrency',function ($str) {
                return "<?php echo number_format($str,0); ?>";
            });

            Blade::directive('toStatus',function ($str) {
                return "<?php
                echo App\Enums\StateEnum::title($str);
                ?>";
            });

            Blade::directive('toGender',function ($gender) {
                return "<?php
                    echo App\Enums\GenderEnum::title($gender);
                ?>";

            });

            Blade::directive('toPersianDate',function ($str) {
                $str = explode(',',$str);

                if (count($str) == 1)
                    $str[] = "'d F Y (H:i)'";
                return "<?php
                            echo $str[0] == null ? '-' : verta($str[0])->format($str[1]);
                        ?>";
            });

            Blade::directive('toTime',function ($datetime) {
                return '<?php echo date("H:i",strtotime($datetime)); ?>';
            });

            Blade::directive('toYesNo',function ($str) {
                return "<?php echo $str == 1 ? trans('custom.yes') : trans('custom.no'); ?>";
            });

            Blade::directive('Setting',function ($key) {
                return "<?php echo App\Models\Setting::Get($key); ?>";
            });

			Blade::directive('isActiveRoute',function ($arg) {
				$str = explode(',',$arg);
				if (count($str) == 1)
					$str[] = '';
				return "<?php echo isActiveRoute($str[0],$str[1]); ?>";
			});

        }
    }
