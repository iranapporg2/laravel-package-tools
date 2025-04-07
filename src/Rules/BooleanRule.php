<?php

	namespace iranapp\Tools\Rules;

	use Closure;
	use Illuminate\Contracts\Validation\ValidationRule;
	use Illuminate\Contracts\Validation\ValidatorAwareRule;
	use Illuminate\Validation\Validator;

	class BooleanRule implements ValidationRule,ValidatorAwareRule
	{

		protected Validator $validator;

		/**
		 * Run the validation rule.
		 */
		public function validate(string $attribute, mixed $value, Closure $fail): void
		{
			$allowed = [1, 0, true, false, '1', '0', 'true', 'false'];

			if (!in_array($value, $allowed, true)) {
				$fail("The $attribute must be a boolean (1, 0, true, false).");
			}

			$converted = filter_var($value, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
			$this->validator->setValue($attribute, $converted);

		}

		public function setValidator(Validator $validator) {
			$this->validator = $validator;
			return $this;
		}

	}
