<?php

	namespace OmidAghakhani\Utility;

	use Illuminate\Support\ServiceProvider;

	class MainProvider extends ServiceProvider {

		public function boot() {

			$this->publishes([
				__DIR__.'/../config/utility.php' => config_path('utility.php')
			]);
			
			$this->publishes([
				__DIR__.'/../resources' => base_path()
			],'languages');

		}

	}
