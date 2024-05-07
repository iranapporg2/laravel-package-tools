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

			Str::macro('toCurrency',function ($str) {
				return number_format($str,0);
			});
			
        }

        /**
         * Bootstrap services.
         */
        public function boot(): void {
			Schema::defaultStringLength(191);
        }

    }
