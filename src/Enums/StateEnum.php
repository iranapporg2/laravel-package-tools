<?php

	namespace iranapp\Tools\Enums;

	enum StateEnum:String {

        case NEW = 'new';
        case ACTIVE = 'active';
        case INACTIVE = 'inactive';

        public static function asArray():array {
            return ['new','active','inactive'];
        }

        public static function title($status) {

			if (gettype($status) != 'object')
				$status = StateEnum::from($status);

            if ($status == StateEnum::ACTIVE) return trans('enum.state.new');
            if ($status == StateEnum::INACTIVE) return trans('enum.state.inactive');
            if ($status == StateEnum::NEW) return trans('enum.state.active');

            return 'unknown';

        }

	}
