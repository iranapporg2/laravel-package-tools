<?php

	return [
		'timeout' => 59, //by seconds
		'code_length' => 5, // length of the generated otp
		'max_allow_create' => 5, // Number of times allowed to regenerate otps
		'attempt_count' => 5,
		'only_digit' => true // generated otp contains mixed characters ex:ad2312
	];
