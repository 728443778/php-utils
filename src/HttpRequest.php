<?php

namespace sevenUtils;

class HttpRequest
{

    protected $curl;

    public function __construct()
    {
        $this->curl = curl_init();
        if (!$this->curl) {
            throw new \Exception('init curl failed :' , 400);
        }
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        $headers = [
            'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10.12; rv:56.0) Gecko/20100101 Firefox/56.0'
        ];
        curl_setopt($this->curl, CURLOPT_HEADER, $headers);
        $this->setTimeout(15);
    }

    public function setRequestHeaders($headers)
    {
        curl_setopt($this->curl, CURLOPT_HEADER, $headers);
    }

    public function setTimeout($timeout = 20)
    {
        curl_setopt($this->curl, CURLOPT_TIMEOUT, $timeout);
    }

    public function requestGet($url)
    {
        curl_setopt($this->curl, CURLOPT_URL, $url);
        return curl_exec($this->curl);
    }

    public function requestPost($url, $data)
    {
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        return curl_exec($this->curl);
    }

    public function getResponseCode()
    {
        return curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
    }

    public function getResponseHeaders()
    {
        return curl_getinfo($this->curl);
    }

    public function downLoadFile($url, $params, $localfile)
    {
        $fp = fopen($localfile, 'w');
        curl_setopt($this->curl, CURLOPT_FILE, $fp);
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $params);
        curl_exec($this->curl);
    }

    /**
     * 生产curl 上传的文件
     * @param $filename string 文件路径
     * @param $mimetype string 文件的mime类型
     * @param $postname string 在提交的时候，服务器获取到的文件名在客户端的文件名字
     * @return \CURLFile
     */
    public function createFile($filename, $mimetype, $postname)
    {
        return curl_file_create($filename, $mimetype, $postname);
    }

    public static function get($url)
    {
        try {
            $url = urlencode($url);
            return file_get_contents($url);
        } catch (\Exception $exception) {
            return $exception->getMessage() . ':' . $exception->getTraceAsString();
        }
    }

    public function getErrorCode()
    {
        return curl_errno($this->curl);
    }

    public function getErrorStr()
    {
        return curl_error($this->curl);
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

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        curl_close($this->curl);
    }
}