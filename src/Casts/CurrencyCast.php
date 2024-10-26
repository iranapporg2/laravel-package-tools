<?php

	namespace iranapp\Tools\Casts;

    use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Str;

    class CurrencyCast implements CastsAttributes {
        /**
         * Cast the given value.
         *
         * @param array<string, mixed> $attributes
         */
        public function get(Model $model, string $key, mixed $value, array $attributes): mixed {
            return number_format((int) conversion()->santinize($value),0);
        }

        /**
         * Prepare the given value for storage.
         *
         * @param array<string, mixed> $attributes
         */
        public function set(Model $model, string $key, mixed $value, array $attributes): mixed {
            return str_replace(',','',$value);
        }
    }
