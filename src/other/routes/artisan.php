<?php

	use Illuminate\Support\Facades\Route;

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

	Route::get('my.js', function () {
		$path = base_path('vendor/iranapp/tools/src/other/public/asset/my.js');;
		if (file_exists($path)) {
			return response()->file($path, [
				'Content-Type' => 'application/javascript'
			]);
		}
		abort(404);
	});

	Route::get('/library/select2', function () {
		return response()->make(
			'<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
         <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>',
			200,
			['Content-Type' => 'text/html']
		);
	});

	Route::get('/library/persiandate', function () {
		return response()->make(
			'<script src="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>
			<link href="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css" rel="stylesheet">',
			200,
			['Content-Type' => 'text/html']
		);
	});

	Route::get('/library/sweetalert', function () {
		return response()->make(
			'<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
			<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css">',
			200,
			['Content-Type' => 'text/html']
		);
	});

	Route::get('edit', function (Request $request) {

		$id = $request->id;
		$key = $request->key;
		$val = $request->value;
		$model = $request->model;

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