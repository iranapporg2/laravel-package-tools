<?php

	namespace iranapp\Tools\Traits;

	trait ConversionFormRequestTrait {

		protected function prepareForValidation() {

			$input = $this->all();

			$input = $this->convertInput($input);
			$this->replace($input);

		}

		protected function convertInput($input)
		{
			if (is_array($input)) {
				foreach ($input as $key => $value) {
					$input[$key] = $this->convertInput($value);
				}
			} elseif (is_string($input)) {

				$input = conversion()->sanitize($input);

				if (preg_match('|^\d{4}/\d{1,2}/\d{1,2}$|', $input)) {
					$input = conversion()->gregorian($input);
				}
			}

			return $input;
		}

	}
