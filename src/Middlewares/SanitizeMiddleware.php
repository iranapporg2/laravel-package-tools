<?php

	namespace iranapp\Tools\Middlewares;

	use Closure;
	use Illuminate\Http\Request;
	use Symfony\Component\HttpFoundation\Response;
	use function React\Promise\all;

	class SanitizeMiddleware {
		/**
		 * Handle an incoming request.
		 *
		 * @param \Closure(Request): (Response) $next
		 * @param mixed ...$fields
		 */
		public function handle(Request $request, Closure $next, ...$fields): Response {
			// Get all request variables
			$variables = $request->all();

			if (count($fields) == 0) $fields = array_keys($variables);

			foreach ($variables as $variable => $temp) {
				// If no fields specified, sanitize all; otherwise, only sanitize specified fields
				if (!empty($temp) && in_array($variable, $fields)) {
					$temp = conversion()->sanitize($temp);

					// Check if the variable is a date and convert if necessary
					if (preg_match('|^\d{4}/\d{1,2}/\d{1,2}$|', $temp)) {
						$temp = conversion()->gregorian($temp);
					}

					// Merge sanitized value back into the request
					$request->merge([
						$variable => $temp,
					]);
				}
			}

			return $next($request);
		}
	}
