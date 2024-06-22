<?php

	//auto publish needing files
	namespace iranapp\Tools;

	use Illuminate\Support\Facades\Schema;
	use Illuminate\Support\ServiceProvider;

	class MainProvider extends ServiceProvider {

		public function boot() {

			$this->publishes([
				__DIR__.'/../config' => config_path('tools'),
				__DIR__.'/../database/migrations/2024_05_22_165348_create_admins_table.php'  => database_path('2024_05_22_165348_create_admins_table.php'),
				__DIR__.'/../database/migrations/2024_06_03_165820_create_otps_table.php' => database_path('2024_06_03_165820_create_otps_table.php'),
				__DIR__.'/../database/migrations/2024_06_12_162907_create_settings_table.php' => database_path('2024_06_12_162907_create_settings_table.php'),
			]);

			$this->publishes([
				__DIR__.'/../resources' => base_path().'/resources'
			],'languages');

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
