<?php

	namespace iranapp\Tools\Rules;

	use Closure;
	use Illuminate\Contracts\Validation\ValidationRule;

	class NationalCodeRule implements ValidationRule {
		/**
		 * Run the validation rule.
		 *
		 * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
		 */
		public function validate(string $attribute, mixed $value, Closure $fail): void {
			$value = preg_replace('/[^0-9]/', '', $value);

			if (strlen($value) !== 10) {
				$fail('کد ملی باید دقیقاً ۱۰ رقم باشد.');

				return;
			}

			if (preg_match('/(\d)\1{9}/', $value)) {
				$fail('کد ملی معتبر نیست.');

				return;
			}

			$sum = 0;
			for ($i = 0; $i < 9; $i++) {
				$sum += (int)$value[$i] * (10 - $i);
			}

			$remainder = $sum % 11;
			$checkDigit = (int)$value[9];

			if (!($remainder < 2 && $checkDigit === $remainder) && !($remainder >= 2 && $checkDigit === 11 - $remainder)) {
				$fail('کد ملی معتبر نیست.');
			}
		}
	}
