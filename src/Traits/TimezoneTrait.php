<?php

	namespace App\Traits;

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
				// Ensure created_at and updated_at are set to Asia/Tehran timezone
				if (empty($model->created_at)) {
					$model->created_at = Carbon::now('Asia/Tehran');
				}
				if (empty($model->updated_at)) {
					$model->updated_at = Carbon::now('Asia/Tehran');
				}
			});

			static::updating(function ($model) {
				// Convert only the modified fields
				$model->convertDateTimesToTehran(true); // Pass true to convert only dirty fields
				// Always set updated_at to Asia/Tehran timezone when updating
				if (!$model->isDirty('updated_at')) {
					$model->updated_at = Carbon::now('Asia/Tehran');
				}
			});
		}

		/**
		 * Convert datetime attributes to Asia/Tehran timezone before saving.
		 *
		 * @param bool $onlyModified Whether to convert only modified fields.
		 */
		protected function convertDateTimesToTehran($onlyModified = false)
		{
			// Get all datetime attributes from $casts
			$attributes = $this->getDateTimeAttributes();

			foreach ($attributes as $attribute) {
				// Skip the attribute if it hasn't been modified and we're only converting modified fields
				if ($onlyModified && !$this->isDirty($attribute)) {
					continue;
				}

				if (!empty($this->{$attribute})) {
					// Convert from UTC to Asia/Tehran
					$this->{$attribute} = Carbon::parse($this->{$attribute}, 'UTC')->setTimezone('Asia/Tehran');
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