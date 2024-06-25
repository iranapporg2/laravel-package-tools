<?php

    namespace iranapp\Tools\Providers;

    use Illuminate\Support\ServiceProvider;
	use iranapp\Tools\Services\Payment\Drivers\ZarinpalPayment;
	use iranapp\Tools\Services\Payment\PaymentInterface;
	use iranapp\Tools\Services\Payment\PaymentService;

	class PaymentServiceProvider extends ServiceProvider {
        /**
         * Register services.
         */
        public function register(): void {

			$this->app->bind(PaymentInterface::class,function ($app) {
				if (config('payment.gateway') == 'zarinpal') return new ZarinpalPayment();
				throw new \Exception('not found payment gateway');
			});

			$this->app->singleton(PaymentService::class, function ($app) {
				return new PaymentService($app->make(PaymentInterface::class));
			});

        }

        /**
         * Bootstrap services.
         */
        public function boot(): void {

        }

    }
