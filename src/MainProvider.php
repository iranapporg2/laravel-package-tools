<?php

	//auto publish needing files
	namespace iranapp\Tools;

	use Illuminate\Foundation\Http\Kernel;
	use Illuminate\Support\Facades\Redirect;
	use Illuminate\Support\Facades\Route;
	use Illuminate\Support\Facades\Schema;
	use Illuminate\Support\ServiceProvider;
	use iranapp\Tools\Middlewares\SanitizeMiddleware;
	use iranapp\Tools\Responses\CustomRedirectResponse;

	class MainProvider extends ServiceProvider {

		public function boot() {

			$this->publishes([
				__DIR__.'/other/config' => config_path(),
			],'iranapp-config');

			$this->publishes([
				__DIR__.'/other/database/migrations'  => database_path('migrations'),
			],'iranapp-migrations');

			//use it like {{ __('iranapp::messages.key') }}
			//$this->loadTranslationsFrom(__DIR__.'/other/lang/fa', 'iranapp');

			$this->publishes([
				__DIR__.'\other\resources' => base_path('resources'),
			], 'iranapp-resources');

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

			Redirect::macro('notify', function ($route, ...$parameters) {
				return new CustomRedirectResponse(route($route, ...$parameters));
			});

			$router = $this->app['router'];
			$router->aliasMiddleware('sanitize', SanitizeMiddleware::class);
			$router->aliasMiddleware('allowedQuery', SanitizeMiddleware::class);

		}

		public function register()
		{
			//Merge the configuration file
			/*$this->mergeConfigFrom(
				__DIR__.'/../config/auth.php', 'auth'
			);*/
		}

	}
