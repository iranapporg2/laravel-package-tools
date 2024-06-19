<?php

	use iranapp\Tools\Models\Admin;

	return [
		'guards' => [
			'admin' => [
				'driver' => 'session',
				'provider' => 'admins'
			],
			'api' => [
				'driver' => 'jwt',
				'provider' => 'api',
			]
		],
		'providers' => [
			'admins' => [
				'driver' => 'eloquent',
				'model' => Admin::class
			]
		],
	];