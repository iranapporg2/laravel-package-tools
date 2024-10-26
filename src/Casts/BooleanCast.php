<?php

    namespace App\Casts;

    use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
    use Illuminate\Database\Eloquent\Model;

    class BooleanCast implements CastsAttributes {
        /**
         * Cast the given value.
         *
         * @param array<string, mixed> $attributes
         */
        public function get(Model $model, string $key, mixed $value, array $attributes): mixed {
            if ($value == '1' || $value == 'true') return true;
            if ($value == '0' || $value == 'false') return false;
        }

        /**
         * Prepare the given value for storage.
         *
         * @param array<string, mixed> $attributes
         */
        public function set(Model $model, string $key, mixed $value, array $attributes): mixed {
            return filter_var($value,FILTER_VALIDATE_BOOLEAN) == true ? '1' : '0';
        }
    }
