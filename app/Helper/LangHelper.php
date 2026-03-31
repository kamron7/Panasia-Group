<?php

use Illuminate\Support\Facades\Request;

if (!function_exists('switch_lang_uri')) {

    function switch_lang_uri(string $lang): string
    {
        $segments = Request::segments();
        $supported = ['uz', 'ru', 'en', 'oz', 'uz-Latn'];

        if (isset($segments[0]) && in_array($segments[0], $supported)) {
            $segments[0] = $lang;
        } else {
            array_unshift($segments, $lang);
        }

        return url(implode('/', $segments));
    }
}
