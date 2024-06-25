<?php

	namespace iranapp\Tools\Services\Payment;

	class PaymentResult {

		private $status,$authority,$url,$error;

		public function __construct($status,$authority = '',$error = '',$returnUrl = '') {
			$this->status = $status;
			$this->authority = $authority;
			$this->url = $returnUrl;
			$this->error = $error;
		}

		public function getStatus() {
			return $this->status;
		}

		public function getAuthority() {
			return $this->authority;
		}

		public function getError() {
			return $this->error;
		}

		public function getPaymentUrl() {
			return $this->url;
		}

	}