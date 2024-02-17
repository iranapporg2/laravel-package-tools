<?php

	namespace OmidAghakhani\Utility\src;

	use Illuminate\Support\ServiceProvider;

	class MainProvider extends ServiceProvider {

		public function boot() {

			$this->publishes([
				'utility.php' => config_path('utility.php')
			]);

		}

	}
