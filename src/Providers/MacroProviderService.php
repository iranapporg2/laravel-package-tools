<?php

    namespace OmidAghakhani\Utility\Providers;

    use Illuminate\Support\Facades\Schema;
	use Illuminate\Support\ServiceProvider;
    use Illuminate\Support\Str;

    class MacroProviderService extends ServiceProvider {
        /**
         * Register services.
         */
        public function register(): void {

			Str::macro('toPrice',function ($str) {
				return number_format($str,0);
			});

			Str::macro('toLatin',function ($str) {

				$en_num = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
				$fa_num = array('٠', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
				$fa_num1 = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');

				$t = str_replace($fa_num1, $en_num, $str);
				$t = str_replace($fa_num, $en_num, $t);
				return str_replace('۰','0',$t);
				
			});
			
        }

        /**
         * Bootstrap services.
         */
        public function boot(): void {
			Schema::defaultStringLength(191);
        }

    }
