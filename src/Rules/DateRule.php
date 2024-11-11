<?php

	namespace iranapp\Tools\Rules;
	use Closure;
	use Illuminate\Contracts\Validation\ValidationRule;

	class DateRule implements ValidationRule
	{
		/**
		 * Run the validation rule.
		 *
		 * @param  string  $attribute
		 * @param  mixed  $value
		 * @param  \Closure  $fail
		 * @return void
		 */
		public function validate(string $attribute, mixed $value, \Closure $fail): void {
			$value = conversion()->sanitize($value);
			if (!preg_match('/^\d{4}/\d{1,2}/\d{1,2}$/', $value))
				$fail(trans('validation.in', trans('custom.date')));
		}
	}