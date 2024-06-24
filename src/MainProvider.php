<?php

	//auto publish needing files
	namespace iranapp\Tools;

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Support\ServiceProvider;

	class MainProvider extends ServiceProvider {

		public function boot() {

			$this->publishes([
				__DIR__.'/../config' => config_path(),
			]);

			$this->publishes([
				__DIR__.'/../database/migrations'  => database_path('migrations'),
			],'migration');

			$this->publishes([
				__DIR__.'/../resources' => base_path().'/resources'
			],'resource');

			$this->publishes([
				__DIR__.'/../config/auth.php' => config_path('my_auth.php'),
			]);

			Schema::defaultStringLength(220);

		}

		public function register()
		{
			// Merge the configuration file
			$this->mergeConfigFrom(
				__DIR__.'/../config/auth.php', 'auth'
			);
		}

	}
