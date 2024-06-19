<?php

	namespace iranapp\Tools\Enums;

	enum GenderEnum:String {

        case MALE = 'male';
        case FEMALE = 'female';

        public static function asArray(): array {
            return ['male','female'];
        }

        public static function title($gender) {

			if (gettype($gender) != 'object')
				$gender = GenderEnum::from($gender);

            if ($gender == GenderEnum::MALE) return trans('enum.gender.male');
            if ($gender == GenderEnum::FEMALE) return trans('enum.gender.female');

            return '-';

        }

	}
