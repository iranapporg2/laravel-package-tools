<?php

	namespace iranapp\Tools\Traits;

	use Illuminate\Contracts\Validation\Validator;
	use Illuminate\Http\Exceptions\HttpResponseException;

	trait FormRequestHelper {

		/**
		 * according to crud actions, if user try add new item, this function return true
		 */
		public function isCreateRequest(): bool {
			return request()->isMethod('POST');
		}

		protected function prepareForValidation() {
			request()->request->add(['is_create' => $this->isCreateRequest()]);
		}

		public function failedValidation(Validator $validator) {

			throw new HttpResponseException(response()->json([
				'status' => false,
				'message' => implode('<br>',$validator->errors()->all())
			]));

		}

	}
