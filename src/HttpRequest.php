<?php

namespace sevenUtils;

class HttpRequest
{


    public static function get($url)
    {
        return file_get_contents($url);
    }

    public static function post($url, $data)
    {
        $data = http_build_query($data);
        $http = [
            'http' => [
                'method' => 'POST',
                'header' => "Content-type:application/x-www-form-urlencoded\r\n" . 'Content-Length:' . strlen($data) . "\r\n",
                'content' => $data
            ],
        ];
        $context = stream_context_create($http);
        return file_get_contents($url, false, $context);
    }
}