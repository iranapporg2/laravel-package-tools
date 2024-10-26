<?php

	namespace iranapp\Tools\Enums;

	enum StateEnum: string {

		case NEW = 'new';
		case ACTIVE = 'active';
		case INACTIVE = 'inactive';
		case PENDING = 'pending';

		public static function title($status) {
			return self::arrays($status);
		}

		public static function arrays(): array {
			return [
					'new' => trans('enum.state.new'),
					'active' => trans('enum.state.inactive'),
					'inactive' => trans('enum.state.active'),
					'pending' => trans('enum.state.pending'),
			];
		}

	}
