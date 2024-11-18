<?php

    namespace iranapp\Tools\Traits;

    use Illuminate\Support\Carbon;

    trait TimezoneTrait
    {
        /**
         * Boot the trait to handle timezone adjustments.
         */
        protected static function bootTimezoneTrait()
        {
            static::creating(function ($model) {
                $model->convertDateTimesToTehran();
            });

            static::updating(function ($model) {
                $model->convertDateTimesToTehran();
            });
        }

        /**
         * Convert datetime attributes to Asia/Tehran timezone before saving.
         */
        protected function convertDateTimesToTehran()
        {
            foreach ($this->getDateTimeAttributes() as $attribute) {
                if (!empty($this->{$attribute})) {
                    $this->{$attribute} = Carbon::parse($this->{$attribute})->setTimezone('Asia/Tehran');
                }
            }
        }

        /**
         * Get all attributes of type datetime from $casts.
         *
         * @return array
         */
        protected function getDateTimeAttributes(): array
        {
            return array_keys(array_filter($this->casts ?? [], fn($cast) => $cast === 'datetime'));
        }
    }
