<?php

	namespace iranapp\Tools\Http\Middleware;

    use Closure;
    use Illuminate\Http\Request;
    use Illuminate\Routing\Route;
    use Symfony\Component\HttpFoundation\Response;

    class AdminMiddleware {
        /**
         * Handle an incoming request.
         *
         * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
         */
        public function handle(Request $request, Closure $next): Response {

            if (!\auth('admin')->check())
                return redirect()->route('panel.login');

            return $next($request);

        }

    }
