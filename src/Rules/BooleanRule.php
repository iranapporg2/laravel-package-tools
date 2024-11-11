<?php

	namespace iranapp\Tools\Rules;
	use Closure;
	use Illuminate\Contracts\Validation\ValidationRule;

	class BooleanRule implements ValidationRule
	{
		/**
		 * Run the validation rule.
		 *
		 * @param  string  $attribute
		 * @param  mixed  $value
		 * @param  \Closure  $fail
		 * @return void
		 */
		public function validate(string $attribute, mixed $value, \Closure $fail): void
		{
			$value = conversion()->sanitize($value);
			if (!in_array($value,['0','1','false','true']))
				$fail(trans('validation.in',trans('custom.value')));
		}
	}