<?php

    use Illuminate\Support\Facades\Route;

    if (!function_exists('isActiveRoute')) {
        function isActiveRoute($routePatterns, $output = "active")
        {
            if (!is_array($routePatterns)) {
                $routePatterns = [$routePatterns];
            }

            $currentRouteName = Route::currentRouteName();

            foreach ($routePatterns as $pattern) {
                // Check if the pattern ends with '*'
                if (str_ends_with($pattern, '*')) {
                    // Get the prefix by removing the '*' at the end
                    $prefix = rtrim($pattern, '*');
                    // Check if the current route name starts with the prefix
                    if (str_starts_with($currentRouteName, $prefix)) {
                        return $output;
                    }
                } elseif ($currentRouteName === $pattern) {
                    return $output;
                }
            }

            return '';
        }
    }

    function successBack($message = null) {
        return back()->with('message',$message ?? trans('custom.message.success'));
    }

    function failBack($message = null) {
        return back()->with('message',$message ?? trans('custom.message.failed'));
    }
