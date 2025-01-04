<?php

	namespace iranapp\Tools\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Setting extends Model {
        use HasFactory;
        public $guarded = [];

		protected static function booted() {

			self::updated(function () {
				\Cache::delete('settings');
			});

			self::deleted(function () {
				\Cache::delete('settings');
			});

			self::created(function () {
				\Cache::delete('settings');
			});

		}

		public static function Fetch($key,$default = null) {

			$all = null;

			\Cache::remember('settings',86400,function () use (&$all) {
				$all = Setting::pluck('value','key')->all();
			});

			if (!isset($all[$key])) return $default;

			return $all[$key];

        }

		public static function getAll() {

			\Cache::remember('settings',86400,function () use (&$all) {
				$all = Setting::pluck('value','key')->all();
				return Setting::pluck('value','key')->all();
			});

		}

    }
