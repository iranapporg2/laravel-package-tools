<?php

	namespace iranapp\Tools\Services;

    use function Laravel\Prompts\confirm;

    class PaymentService {

        public static function Pay($mobile, $price, $description, $callback) {

            $data = array("merchant_id" => config('payment.key'),
                "amount" => $price * 10,
                "callback_url" => $callback,
                'description' => $description,
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
                return new PaymentResponse(false,'',$err);
            } else {
                if (empty($result['errors'])) {
                    if ($result['data']['code'] == 100) {
                        return new PaymentResponse(true,$result['data']["authority"]);
                    }
                }
            }

            return new PaymentResponse(false);

        }

        public static function Verify($Authority, $Price)
        {
            $data = array('merchant_id' => config('payment.key'), 'authority' => $Authority, 'amount' => $Price * 10);

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
				return new PaymentResponse(false,'',$result);

			return new PaymentResponse($data['data']['code'] == 100);

        }

    }

    class PaymentResponse {

        private $status,$authority,$url,$error;

        public function __construct($status,$authority = '',$error = '') {
            $this->status = $status;
            $this->authority = $authority;
            $this->url = 'https://www.zarinpal.com/pg/StartPay/'.$authority;
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
