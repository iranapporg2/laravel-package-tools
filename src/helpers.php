<?php

    use Illuminate\Support\Facades\Route;
	use iranapp\Tools\Helpers\ConversionHelper;

	if (!function_exists('isActiveRoute')) {
		function isActiveRoute($routePatterns, $output = "active", $queryParameters = [])
		{
			if (!is_array($routePatterns)) {
				$routePatterns = [$routePatterns];
			}

			$currentRouteName = Route::currentRouteName();
			$currentQueryParameters = request()->query(); // Get the current query parameters

			foreach ($routePatterns as $pattern) {
				// Check if the pattern ends with '*'
				if (str_ends_with($pattern, '*')) {
					// Get the prefix by removing the '*' at the end
					$prefix = rtrim($pattern, '*');
					// Check if the current route name starts with the prefix
					if (str_starts_with($currentRouteName, $prefix)) {
						if (empty($queryParameters) || array_intersect_assoc($queryParameters, $currentQueryParameters)) {
							return $output;
						}
					}
				} elseif ($currentRouteName === $pattern) {
					if (empty($queryParameters) || array_intersect_assoc($queryParameters, $currentQueryParameters)) {
						return $output;
					}
				}
			}

			return '';
		}
	}

    function successBack($message = null) {
        return back()->with('message',$message ?? trans('custom.message.success'));
    }

    function errorBack($message = null) {
        return back()->with('message',$message ?? trans('custom.message.failed'));
    }

	if (!function_exists('conversion')) {
		function conversion() {
			return new ConversionHelper();
		}
	}
