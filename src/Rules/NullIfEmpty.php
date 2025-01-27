<?php

	namespace iranapp\Tools\Rules;

    use Illuminate\Contracts\Validation\ValidationRule;
    use Closure;

    class NullIfEmpty implements ValidationRule
    {
        /**
         * Run the validation rule.
         *
         * @param string $attribute
         * @param mixed $value
         * @param \Closure $fail
         * @return void
         */
        public function validate(string $attribute, mixed $value, Closure $fail): void
        {
            // Convert empty string to null
            if ($value === '') {
                $value = null;
            }

            // Set the transformed value back into the validator's data
            validator()->setData(array_merge(validator()->getData(), [
                $attribute => $value,
            ]));
        }
    }
