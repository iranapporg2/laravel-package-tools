<?php

    namespace iranapp\Tools\Middlewares;

    use Closure;
    use Hekmatinasser\Verta\Verta;
    use Illuminate\Http\Request;
    use Illuminate\Support\Str;
    use Symfony\Component\HttpFoundation\Response;

    class SanitizeMiddleware {
        /**
         * Handle an incoming request.
         *
         * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
         */
        public function handle(Request $request, Closure $next): Response {

            $variables = $request->all();

            foreach ($variables as $variable => $temp) {

                if (Str::length($temp) < 50) {

                    $temp = conversion()->santinize($temp);

                    if (preg_match('|^\d{4}/\d{1,2}/\d{1,2}$|', $temp))
                        $temp = conversion()->gregorian($temp);

                    $request->merge([
                        $variable => $temp
                    ]);

                }

            }

            return $next($request);

        }

    }
