<?php

	namespace App\Traits;

    use Illuminate\Support\Str;

    /**
     * Trait ConversionTrait
     *
     * The ConversionTrait provides functionality to convert date fields to Persian dates
     * and number fields to Persian numbers.
     * @property array $convertDateFields
     * @property array $convertNumberFields
     */
	trait ConversionTrait {

        public static function boot()
        {
            parent::boot();

            static::retrieved(function ($model) {
                $model->convertDates();
            });

            static::retrieved(function ($model) {
                $model->convertPrices();
            });

        }

        // Method to convert the specified date fields to Persian date format
        protected function convertDates()
        {
            foreach ($this->convertDateFields as $field) {
                // Get the value of the date field
                $value = $this->getAttribute($field);

                // Convert the Gregorian date to Persian date
                // You need to implement the logic for conversion
                $persianDate = verta($value)->format('Y/m/d');

                // Set the converted value back to the model
                $this->setAttribute($field, $persianDate);
            }
        }

        // Method to convert the specified date fields to Persian date format
        protected function convertPrices()
        {
            foreach ($this->convertNumberFields as $field) {
                // Get the value of the date field
                $value = $this->getAttribute($field);

                // Convert the Gregorian date to Persian date
                // You need to implement the logic for conversion
                $value = Str::replace(',','',$value);
                $persianDate = number_format($value,0);

                // Set the converted value back to the model
                $this->setAttribute($field, $persianDate);
            }
        }

	}
