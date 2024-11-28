<?php

    namespace iranapp\Tools\Traits;

    use Illuminate\Support\Arr;

    trait EnumWithLookups {
        public static function all(): array {
            return self::cases();
        }

        public static function fromNames(mixed $statuses): array {
            return collect(Arr::wrap($statuses))
                ->transform(fn($status, $name) => constant("self::$name")->value)
                ->toArray();
        }

        public static function toArray(): array {
            $array = [];
            foreach (self::cases() as $case) {
                $array[$case->value] = $case->name;
            }

            return $array;
        }

        public static function list(): array {
            return array_column(static::cases(), 'value');
        }
    }
