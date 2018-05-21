<?php

namespace sevenUtils\http;

class HttpStreamRequest
{


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
}

$errno = '';
$errstr = '';
$fd = fopen('https://api.sportradar.us/soccer-xt3/eu/en/tournaments/sr:tournament:17/seasons.xml?api_key=zhhz9bgr54g49tawbasjjqat', 'r');
if (!$fd) {
    exit('fopen failed');
}
while (1) {
    var_dump($http_response_header);
    if (isset($http_response_header['Content-Length']) && $http_response_header['Content-Length'] > 0) {
        $data = fread($fd, $http_response_header['Content-Length']);
        $http_response_header = [];
        echo $data,PHP_EOL;
    } else {
        echo 'sleep',PHP_EOL;
        sleep(3);
    }
}