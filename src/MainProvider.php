<?php

	//auto publish needing files
	namespace iranapp\Tools;

	use Illuminate\Foundation\Http\Kernel;
	use Illuminate\Support\Facades\Route;
	use Illuminate\Support\Facades\Schema;
	use Illuminate\Support\ServiceProvider;
	use iranapp\Tools\Middlewares\SanitizeMiddleware;

	class MainProvider extends ServiceProvider {

		public function boot() {

			$this->publishes([
				__DIR__.'/other/config' => config_path(),
			],'laravel-assets');

			$this->publishes([
				__DIR__.'/View/Components' => base_path('app/View/Components'),
			],'laravel-assets');

			$this->publishes([
				__DIR__.'/other/database/migrations'  => database_path('laravel-assets'),
			],'laravel-assets');

			$this->publishes([
				__DIR__.'/other/lang'  => lang_path(),
			],'laravel-assets');

			$this->publishes([
				__DIR__.'\other\resources' => base_path('resources'),
			], 'laravel-assets');

			/*$this->publishes([
				__DIR__.'/../config/auth.php' => config_path('my_auth.php'),
			]);*/

			/*$this->publishes([
				__DIR__.'/../bootstrap/app.php' => base_path('bootstrap'),
			]);*/

			Schema::defaultStringLength(220);

			$this->loadRoutesFrom(__DIR__.'/other/routes/artisan.php');

			$kernel = $this->app->make(Kernel::class);
			//$kernel->prependMiddlewareToGroup('web', SanitizeMiddleware::class);

		}

		public function register()
		{
			//Merge the configuration file
			/*$this->mergeConfigFrom(
				__DIR__.'/../config/auth.php', 'auth'
			);*/
		}

	}
