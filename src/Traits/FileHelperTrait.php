<?php

	class FileHelperTrait {
		
		public function getTypeName($type): string {
			
			if (Str::contains($type,'application')) return 'فایل';
			if (Str::contains($type,'image')) return 'تصویر';
			if (Str::contains($type,'video')) return 'ویدئو';
			if (Str::contains($type,'pdf')) return 'کتاب الکترونیکی';
			if (Str::contains($type,'audio')) return 'صوتی';

			return 'فایل';

		}

		public function getSizeName($bytes) {

			$units = ['B', 'KB', 'MB', 'GB', 'TB'];

			$bytes = max($bytes, 0);
			$power = intval(floor(log($bytes, 1024)));
			$size = round($bytes / pow(1024, $power), 2);

			return $size . ' ' . $units[$power];

		}
		
	}