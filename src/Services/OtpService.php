<?php

    namespace iranapp\Tools\Services;

    use Seshac\Otp\Otp;

    class OtpService {

        public static function make($mobile): OtpResult {

            $otp = \Seshac\Otp\Otp::setValidity(config('otp.timeout'))  // otp validity time in mins
            ->setLength(config('otp.code_length'))
            ->setMaximumOtpsAllowed(config('otp.max_allow_create'))
            ->setOnlyDigits(config('otp.only_digit'))
            ->setUseSameToken(false) // if you re-generate OTP, you will get same token
            ->generate($mobile);

            return new OtpResult($otp->status,$otp->token ?? '',$otp->message);

        }

        public static function validate($mobile,$code) {

            $otp = Otp::setAllowedAttempts(config('otp.attempt_count'))->validate($mobile,$code);

            return new OtpResult($otp->status,'',$otp->message);

        }

    }

    class OtpResult {

        private $status,$token,$message;

        public function __construct($status,$token,$message) {
            $this->status = $status;
            $this->token = $token;
            $this->message = $this->translate_otp_message($message);
        }

        private function translate_otp_message($message) {

            if ($message == 'OTP does not match') return 'کد تایید اشتباه میباشد';
            if ($message == 'OTP is expired') return 'اعتبار کد شما به پایان رسیده است!';
            if ($message == 'Reached the maximum times to generate OTP') return 'تولید کد تایید برای شما محدود شده است';
            if ($message == 'Reached the maximum allowed attempts') return 'تعداد تلاش های مجاز شما به اتمام رسیده است';
            if ($message == 'OTP does not exists, Please generate new OTP') return 'کد تایید معتبر نیست مجدد تلاش کنید';
            return $message;

        }

        public function getStatus() {
            return $this->status;
        }

        public function getToken() {
            return $this->token;
        }

        public function getError() {
            return $this->message;
        }

        public function getTimeout() {
            return config('otp.timeout');
        }

    }
