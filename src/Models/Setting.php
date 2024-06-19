<?php

	namespace iranapp\Tools\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Setting extends Model {
        use HasFactory;
        public $guarded = [];

        public static function Get($key) {

            $all = Setting::pluck('value','key')->all();

			if (!isset($all[$key])) return false;

			return $all[$key];

        }

		public static function GetAll() {
			return Setting::pluck('value','key')->all();
		}

    }
