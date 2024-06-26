<?php

    namespace App\Http\Requests;

    use Illuminate\Foundation\Http\FormRequest;

    class AdminLogin extends FormRequest {
        /**
         * Determine if the user is authorized to make this request.
         */
        public function authorize(): bool {
            return true;
        }

        public function attributes() {
            return [
                'username' => 'نام کاربری',
                'password' => 'رمز عبور'
            ];
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
         */
        public function rules(): array {
            return [
                'username' => 'required|min:5',
                'password' => 'required|min:4|max:20'
            ];
        }
    }
