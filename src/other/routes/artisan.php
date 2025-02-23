<?php

	use Illuminate\Support\Facades\Route;
	use Illuminate\Http\Request;
	use iranapp\Tools\Models\Changelog;

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

	Route::post('changelog',function (Request $request){
		 Changelog::create([
			 'details' => $request->details,
		 ]);
	});

	Route::get('my.js', function (Request $request) {
		$path = base_path('vendor/iranapp/tools/src/other/public/asset/my.js');

		if (!file_exists($path)) {
			abort(404);
		}

		$lastModifiedTime = filemtime($path); // Get the file's last modification time
		$etag = md5_file($path); // Generate an ETag based on the file's content

		// Check if the client's cache is still valid
		if ($request->headers->has('If-Modified-Since') || $request->headers->has('If-None-Match')) {
			$ifModifiedSince = $request->headers->get('If-Modified-Since');
			$ifNoneMatch = $request->headers->get('If-None-Match');

			if ($ifModifiedSince && strtotime($ifModifiedSince) >= $lastModifiedTime && $ifNoneMatch === $etag) {
				return response('', 304); // Not Modified
			}
		}

		return Response::file($path, [
			'Content-Type' => 'application/javascript',
		])
			->setLastModified(new DateTime("@$lastModifiedTime"))
			->setEtag($etag)
			->setCache(['public' => true, 'max_age' => 3600, 'must_revalidate' => true]);
	});

	Route::post('edit', function (Request $request) {

		$id = $request->id;
		$key = $request->key;
		$val = $request->value;
		$model = ucfirst($request->model);

		$model = app('App\\Models\\'.$model);
		$model = $model->find($id);
		$model->{$key} = $val;
		$model->update();

		return response()->json(['status' => true]);

	})->name('edit');

	Route::get('fetch', function (Request $request) {

		if (!$request->ajax())
			return response()->json(['status' => false]);

		$model = $request->model;
		$relate_id = $request->relate_id;
		$relate_field = $request->relate_field;

		$model = app('App\\Models\\'.$model);
		$model = $model->where('id','<>',0);

		if ($relate_id != '') {
			$model->where($relate_field,'=',$relate_id);
		}

		$data = $model->get();

		return response()->json(['status' => true,'result' => $data]);

	})->name('fetch');