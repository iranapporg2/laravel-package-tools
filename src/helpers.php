<?php

	use Illuminate\Support\Facades\Route;
	use iranapp\Tools\Helpers\ConversionHelper;

	if (!function_exists('isActiveRoute')) {
		function isActiveRoute($routePatterns, $output = "active", $queryParameters = [])
		{
			$currentRoute = request()->route()->getName();
			$currentParams = request()->all();

			// Check if the current route matches any pattern in the $routePatterns array
			$routeMatch = collect((array) $routePatterns)->contains(function ($pattern) use ($currentRoute) {
				return fnmatch($pattern, $currentRoute);
			});

			// Check if the $queryParameters are present in the current request parameters
			$queryMatch = collect($queryParameters)->every(function ($value, $key) use ($currentParams) {
				return isset($currentParams[$key]) && $currentParams[$key] == $value;
			});

			return $routeMatch && $queryMatch ? $output : '';
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
