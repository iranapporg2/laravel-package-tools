<?php

	namespace iranapp\Tools\Traits;

	use ReflectionClass;

	//author by seyed mojtaba hosseini
	trait EnumHasTranslations {

		/**
		 * Translate the enum value based on the locale set in Laravel's app.
		 */
		public function translate(): string {

			$key = $this->getTranslationKey();

			return __($key);
		}

		public static function translateList(): array {

			$array = [];
			foreach (self::cases() as $case) {
				$array[$case->value] = __($case->getTranslationKey());
			}

			return $array;
		}

		/**
		 * Generate a translation key based on the enum class and case.
		 */
		protected function getTranslationKey(): string {

			// Generate a key based on the enum class name and case name
			$className = (new ReflectionClass($this))->getShortName();

			return "enums.{$className}.{$this->value}";
		}

	}
