<?php

	namespace iranapp\Tools\Models;

	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;

	class Setting extends Model {
		use HasFactory;
		public $guarded = [];

		public static function Clear() {
			\Cache::delete('setting');
		}

		public static function Fetch($key,$default = null) {

			$all = \Cache::remember('setting',86400,function () use (&$all) {
				return Setting::get();
			});

			foreach ($all as $setting) {
				if ($setting->key == $key) {
					return $setting->value;
				}
			}

			return $default;

		}

		public static function getAll() {

			\Cache::remember('setting',86400,function () use (&$all) {
				$all = Setting::pluck('value','key')->all();
				return Setting::pluck('value','key')->all();
			});

		}

	}
