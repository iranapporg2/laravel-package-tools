<?php

	namespace iranapp\Tools\Traits;

	use Illuminate\Contracts\Validation\Validator;
	use Illuminate\Http\Exceptions\HttpResponseException;

	trait ApiResponseTrait {

        public function json($status,$message = '',$data = null,$statusCode = 200): \Illuminate\Http\JsonResponse {

            $message = [
                'status' => $status,
                'message' => $message
            ];

            if (!is_null($data))
                $message['data'] = $data;

            return response()->json($message,$statusCode,[],JSON_UNESCAPED_UNICODE);

        }

		public function failedValidation(Validator $validator) {

			throw new HttpResponseException(response()->json([
				'status' => false,
				'message' => ['validation' => $validator->errors()],
			]));

		}

	}
