<?php

	namespace iranapp\Tools\Traits;

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

	}
