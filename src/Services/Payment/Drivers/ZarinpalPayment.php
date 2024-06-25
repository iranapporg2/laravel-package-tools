<?php

	namespace iranapp\Tools\Services\Payment\Drivers;

	use iranapp\Tools\Services\Payment\PaymentInterface;
	use iranapp\Tools\Services\Payment\PaymentResult;

	class ZarinpalPayment implements PaymentInterface {

		protected $callBack;
		protected $description;

		public function pay($mobile,$amount) {

			$data = array("merchant_id" => config('payment.key'),
				"amount" => $amount * 10,
				"callback_url" => $this->callBack,
				'description' => $this->description,
				'metadata' => ['mobile' => $mobile]
			);

			$jsonData = json_encode($data);

			$ch = curl_init('https://api.zarinpal.com/pg/v4/payment/request.json');
			curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen($jsonData)
			));
			$result = curl_exec($ch);
			$err = curl_error($ch);
			curl_close($ch);
			$result = json_decode($result, true, JSON_PRETTY_PRINT);

			if ($err) {
				return new PaymentResult(false,'',$err);
			} else {
				if (empty($result['errors'])) {
					if ($result['data']['code'] == 100) {
						$returnUrl = 'https://www.zarinpal.com/pg/StartPay/'.$result['data']["authority"];
						return new PaymentResult(true,$result['data']["authority"],'',$returnUrl);
					}
				}
			}

			return new PaymentResult(false,'',json_encode($result));

		}

		public function verify($authority, $amount) {

			$data = array('merchant_id' => config('payment.key'), 'authority' => $authority, 'amount' => $amount * 10);

			$jsonData = json_encode($data);
			$ch = curl_init('https://api.zarinpal.com/pg/v4/payment/verify.json');
			curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen($jsonData)
			));

			$result = curl_exec($ch);
			curl_close($ch);

			$data = json_decode($result, true);

			if (!$data)
				return new PaymentResult(false,'',$result);

			return new PaymentResult($data['data']['code'] == 100);

		}

		public function setCallbackUrl($url) {
			$this->callBack = $url;
		}

		public function setDescription($description) {
			$this->description = $description;
		}
	}