<?php

    namespace iranapp\Tools\Http\Middleware;

    use iranapp\Tools\Traits\ApiResponseTrait;
    use Closure;
    use Illuminate\Http\Request;
    use Symfony\Component\HttpFoundation\Response;

    class ApiMiddleware {

        use ApiResponseTrait;

        /**
         * Handle an incoming request.
         *
         * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
         */
        public function handle(Request $request, Closure $next): Response {

            if (!auth('api')->user()) {
                return $this->respondWithJson(false,'invalid user',['invalid_key' => true]);
            }

            return $next($request);

        }
    }
