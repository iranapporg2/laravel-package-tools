<?php

    namespace iranapp\Tools\Providers;

    use App\Enums\GenderEnum;
    use App\Enums\StateEnum;
    use Illuminate\Support\Facades\Blade;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\ServiceProvider;
	use Illuminate\Support\Str;

	class MacroServiceProvider extends ServiceProvider {
        /**
         * Register services.
         */
        public function register(): void {

			Str::macro('sanitizeNumber',function ($str) {
				return Str::ToLatin(str_replace(',','',$str));
			});

			Str::macro('ToLatin',function ($str) {

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

        }
    }
