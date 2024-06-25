<?php

	namespace iranapp\Tools\Services\Payment;

	interface PaymentInterface {

		public function pay($mobile,$amount);
		public function setCallbackUrl($url);
		public function setDescription($description);
		public function verify($authority, $amount);

	}