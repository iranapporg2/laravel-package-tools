<?php

    namespace iranapp\Tools\Rules;

    use Closure;
    use Illuminate\Contracts\Validation\ValidationRule;

    class MobileRule implements ValidationRule {
        /**
         * Run the validation rule.
         *
         * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
         */
        public function validate(string $attribute, mixed $value, Closure $fail): void {

            $value = \Str::toLatin($value);

            if (!preg_match('/^0\d{9,12}$/',$value))
                $fail('شماره موبایل را درست وارد کنید');

        }
    }
