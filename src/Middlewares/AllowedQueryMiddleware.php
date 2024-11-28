<?php

	namespace iranapp\Tools\Middlewares;

	use Closure;

	/**
	 * use Route::get('list')->middleware('AllowedQueryMiddleware:name,title,type_id');
	 */
	class AllowedQueryMiddleware {
		public function handle($request, Closure $next, ...$allowedParams) {
			$extraParams = array_diff(array_keys($request->query()), $allowedParams);

			if (!empty($extraParams)) {
				$queryParams = $request->query();
				foreach ($extraParams as $param) {
					unset($queryParams[$param]);
				}
				$cleanUrl = $request->url() . '?' . http_build_query($queryParams);

				return redirect($cleanUrl);
			}

			return $next($request);
		}
	}
