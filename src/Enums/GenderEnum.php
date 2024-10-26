<?php

	namespace iranapp\Tools\Enums;

	enum GenderEnum: string {

		case MALE = 'male';
		case FEMALE = 'female';
		case OTHER = 'other';

		public static function title($gender) {
			return self::arrays()[$gender];
		}

		public static function arrays(): array {
			return [
				'male' => trans('custom.gender.male'),
				'female' => trans('custom.gender.female'),
				'other' => trans('custom.gender.other'),
			];
		}

	}
