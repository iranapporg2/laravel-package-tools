<?php

    namespace iranapp\Tools\Services;

    use Cryptommer\Smsir\Smsir;

    class SmsService {

		/**
		 * Send sms with sms.ir new api version
		 * @param $mobile
		 * @param array|string $text
		 * @param $template_id
		 * @return SmsResult
		 */
        public static function Send($mobile, array|string $text, $template_id): SmsResult {

            $token = config('sms.api-key');

			if (!is_array($text))
            	$parameters[] = ['name' => config('sms.parameter_name'),'value' => $text];
			else {

				$parameters[] = ['name' => config('sms.parameter_name'),'value' => $text[0]];

				for ($i = 1; $i < count($text) - 1; $i++) {
					$parameters[] = ['name' => config('sms.parameter_name').$i,'value' => $text];
				}

			}

            $data['mobile'] = $mobile;
            $data['templateId'] = $template_id;
            $data['parameters'] = $parameters;

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.sms.ir/v1/send/verify',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Accept: text/plain',
                    'x-api-key: ' . $token
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $response = json_decode($response);

			return new SmsResult($response->status == 1,$response);

        }

    }

    class SmsResult {

        private $status,$error;

        public function __construct($status,$error = '') {
            $this->status = $status;
            $this->error = $error;
        }

        public function getStatus() {
            return $this->status;
        }

        public function getError() {
            return $this->error;
        }

    }
