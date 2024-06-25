<?php

	namespace iranapp\Tools\Services\Payment;

    class PaymentService {

		protected $gateway;

		public function __construct(PaymentInterface $payment) {
			$this->gateway = $payment;
		}

		public function pay($amount,$mobile,$callback,$description) {

			$this->gateway->setCallbackUrl($callback);
			$this->gateway->setDescription($description);
			$this->gateway->pay($mobile,$amount);

		}

		public function verify($authority,$amount) {
			return $this->gateway->verify($authority,$amount);
		}

	}
