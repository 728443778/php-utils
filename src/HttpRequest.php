<?php

namespace sevenUtils;

class HttpRequest
{


    public static function get($url)
    {
        try {
            $url = urlencode($url);
            return file_get_contents($url);
        } catch (\Exception $exception) {
            return $exception->getMessage() . ':' . $exception->getTraceAsString();
        }
    }

    public static function post($url, $data)
    {
        try {
            $data = http_build_query($data);
            $http = [
                'http' => [
                    'method' => 'POST',
                    'header' => "Content-type:application/x-www-form-urlencoded\r\n" . 'Content-Length:' . strlen($data) . "\r\n",
                    'content' => $data
                ],
            ];
            $context = stream_context_create($http);
            $url = urlencode($url);
            return file_get_contents($url, false, $context);
        } catch (\Exception $exception) {
            return $exception->getMessage() . ':' . $exception->getTraceAsString();
        }
    }
}