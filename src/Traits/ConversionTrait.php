<?php

	namespace OmidAghakhani\Utility\Traits;

    use Illuminate\Support\Str;

    /**
     * Trait ConversionTrait
     *
     * The ConversionTrait provides functionality to convert date fields to Persian dates
     * and number fields to Persian numbers.
	 * for convert date to persian, add protected variable named dates array type
	 * for price format, add protected variable named prices array type
     */
	trait ConversionTrait
	{

		/**
		 * Dynamically format date attributes to Persian date format.
		 * @param  string  $key
		 * @return mixed
		 */
		public function getAttribute($key)
		{
			$value = parent::getAttribute($key);

			// Check if the attribute ends with "_date" or "_at" to determine if it's a date field
			if (in_array($key, $this->getDates()) && is_string($value)) {
				return verta($value)->format('Y/m/d');
			}

			// Check if the attribute ends with "_price" or "_at" to determine if it's a date field
			if (in_array($key, $this->getDates()) && is_string($value)) {
				return verta($value)->format('Y/m/d');
			}

			return $value;
		}

		/**
		 * Get the list of date attributes to be formatted in Persian format.
		 *
		 * @return array
		 */
		protected function getDates(): array
		{
			return property_exists($this, 'dates') ? $this->dates : [];
		}

		/**
		 * Get the list of date attributes to be formatted in Persian format.
		 *
		 * @return array
		 */
		protected function getPrices(): array
		{
			return property_exists($this, 'prices') ? $this->prices : [];
		}

	}