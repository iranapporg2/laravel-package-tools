<?php

	Route::prefix('artisan/')->group(function () {
		Route::get('/link', function () {
			$targetFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage/app/public';
			$linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/public/storage';
			symlink($targetFolder, $linkFolder);
			echo 'Symlink completed';
		});

		Route::get('/unlink', function () {
			Artisan::call('storage:unlink');
			echo 'Unsymlink completed';
		});

		Route::get('/password', function () {
			echo Hash::make($_GET['password']);
		});

		Route::get('/clear', function () {
			Artisan::call('cache:clear');
			Artisan::call('route:clear');
			Artisan::call('optimize');
			return "Cache cleared successfully";
		});
	});