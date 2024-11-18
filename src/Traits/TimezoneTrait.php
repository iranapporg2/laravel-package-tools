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

				if (empty($model->created_at)) {
					$model->created_at = Carbon::now('Asia/Tehran');
				}
				if (empty($model->updated_at)) {
					$model->updated_at = Carbon::now('Asia/Tehran');
				}

            });

            static::updating(function ($model) {
                $model->convertDateTimesToTehran();
				$model->updated_at = Carbon::now('Asia/Tehran');
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
