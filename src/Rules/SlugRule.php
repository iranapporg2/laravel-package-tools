<?php

	namespace iranapp\Tools\Rules;

	use Closure;
	use Illuminate\Contracts\Validation\ValidationRule;
	use Illuminate\Contracts\Validation\ValidatorAwareRule;
	use Illuminate\Validation\Validator;

	class SlugRule implements ValidationRule,ValidatorAwareRule
	{

		protected Validator $validator;

		/**
		 * Run the validation rule.
		 */
		public function validate(string $attribute, mixed $value, Closure $fail): void
		{
			if (!preg_match('/^[\p{Arabic}a-zA-Z0-9]+(?:-[\p{Arabic}a-zA-Z0-9]+)*$/u', $value)) {
				$fail(trans('validation.in', [trans('custom.error_slug')]));
			}

		}

		public function setValidator(Validator $validator) {
			$this->validator = $validator;
			return $this;
		}

	}
