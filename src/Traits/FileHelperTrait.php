<?php

	namespace OmidAghakhani\Utility\Traits;

	use Illuminate\Support\Str;

	trait FileHelperTrait {
		
		public function getTypeName($type): string {
			
			if (Str::contains($type,'application')) return trans('filehelper.file');
			if (Str::contains($type,'image')) return trans('filehelper.image');
			if (Str::contains($type,'video')) return trans('filehelper.video');
			if (Str::contains($type,'pdf')) return trans('filehelper.pdf');
			if (Str::contains($type,'audio')) return trans('filehelper.audio');

			return trans('filehelper.file');

		}

		public function getSizeName($bytes) {

			$units = ['B', 'KB', 'MB', 'GB', 'TB'];

			$bytes = max($bytes, 0);
			$power = intval(floor(log($bytes, 1024)));
			$size = round($bytes / pow(1024, $power), 2);

			return $size . ' ' . $units[$power];

		}
		
	}