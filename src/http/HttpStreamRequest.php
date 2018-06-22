<?php

namespace sevenUtils\http;

use sevenUtils\traits\SingleInstance;

class HttpStreamRequest
{
    use SingleInstance;

    public function __construct($url = '')
    {

    }

    public function test($url, $timeout)
    {
        $errno = '';
        $errstr = '';
        $fd = stream_socket_client($url, $errno, $errstr, $timeout);
        $data = stream_socket_recvfrom($fd, 10240);
        var_dump($data);
    }

    public function requestHttp($url, $method, $data = [], $headers = [], $timeOut = 5)
    {
        $requestContent = [];
        if (!empty($data)) {
            $data = http_build_query($data);
            $requestContent['content'] = $data;
        }
        if (!empty($headers)) {
            $requestContent['header'] = $headers;
        }
        $method = ucwords($method);
        $requestContent['method'] = $method;
        $context = stream_context_create(['http' => $requestContent]);
        $errno = null;
        $errstr = '';
        $fd = stream_socket_client($url, $errno, $errstr, $timeOut, null, $context);
        $data = stream_socket_recvfrom($fd, 102400);
        fclose($fd);
        return $data;
    }
}
