<?php

if (!function_exists('active_class')) {
    function active_class(string $routeName): string
    {
        return request()->routeIs($routeName) ? 'active' : '';
    }
}
