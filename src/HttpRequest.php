<?php

namespace sevenUtils;

use sevenUtils\traits\SingleInstance;

class HttpRequest
{
    use SingleInstance;

    protected $curl;

    protected $_returnArrayByJsonDecode;

    /**
     * 最近一次请求返回的原始数据 body部分
     * @var
     */
    public $lastResponse;

    public function __construct()
    {

    }

    public function init()
    {
        $this->curl = curl_init();
        if (!$this->curl) {
            throw new \Exception('init curl failed :' , 400);
        }
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        $headers = [
            'User-Agent:Mozilla/5.0 (Macintosh; Intel Mac OS X 10.12; rv:56.0) Gecko/20100101 Firefox/56.0'
        ];
        $this->setRequestHeaders($headers);
        $this->setHttpHeaderCout(false);
        $this->setHeaderOutToInfo(true);
        $this->setTimeout(15);
    }

    /**
     * @param bool $bool
     * @return self
     */
    public function returnJsonDecode($bool = true)
    {
        $this->_returnArrayByJsonDecode = $bool;
        return $this;
    }

    /**
     * @param $value boolean
     * @return self
     */
    public function setHeaderOutToInfo($value)
    {
        curl_setopt($this->curl,CURLINFO_HEADER_OUT, $value);
        return $this;
    }

    /**
     * 是否设置 把头信息输出
     * @param $value
     * @return self
     */
    public function setHttpHeaderCout($value)
    {
        curl_setopt($this->curl, CURLOPT_HEADER, $value);
        return $this;
    }

    /**
     * 设置请求的header 头
     * @param $headers
     * @eg HttpRequest::getInstance()->setRequestHeaders(['Content-type:application/json'])
     * @return self
     */
    public function setRequestHeaders($headers)
    {
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);
        return $this;
    }

    /**
     * @return $this
     */
    public function setConnIsKeepAlive()
    {
        curl_setopt($this->curl, CURLOPT_TCP_KEEPALIVE, 1);
        return $this;
    }

    /**
     * 设置请求的超时时间
     * @param int $timeout
     * @return self
     */
    public function setTimeout($timeout = 20)
    {
        curl_setopt($this->curl, CURLOPT_TIMEOUT, $timeout);
        return $this;
    }

    /**
     * 发起一个get  请求
     * @param $url
     * @return mixed
     */
    public function requestGet($url)
    {
        $this->beforeRequest($url);
        curl_setopt($this->curl, CURLOPT_URL, $url);
        $this->lastResponse = $response = curl_exec($this->curl);
        $response = $this->afterRequest($response);
        return $response;
    }

    /**
     * 发起一个post请求，data只能为一维数组 php7.1 版本是这样
     * @param $url
     * @param $data
     * @return mixed
     */
    public function requestPost($url, $data)
    {
        $this->beforeRequest($url, $data);
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        $this->lastResponse = $response = curl_exec($this->curl);
        $response = $this->afterRequest($response);
        return $response;
    }

    /**
     * 获取最近一次请求的响应状态码
     * @return mixed
     */
    public function getResponseCode()
    {
        return curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
    }

    /**
     * 获取响应头
     * @return mixed
     */
    public function getResponseHeaders()
    {
        return curl_getinfo($this->curl);
    }

    /**
     * 把文件下载到 localfile
     * @param $url
     * @param $params array post 参数，如果为空则发起get请求,否则发起post请求
     * @param $localfile
     */
    public function downLoadFile($url, $localfile, $params  = [])
    {
        $fp = fopen($localfile, 'w');
        curl_setopt($this->curl, CURLOPT_FILE, $fp);
        curl_setopt($this->curl, CURLOPT_URL, $url);
        if (!empty($params)) {
            curl_setopt($this->curl, CURLOPT_POST, true);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $params);
        }
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

    /**
     * 发起一个get请求
     * @param $url
     * @param $isUrlEncode bool 是否进行urlencode编码 如果使用了这个选项 服务器也需要对url进行解码 这是成对的
     * @return bool|string
     */
    public static function get($url, $isUrlEncode = true)
    {
        try {
            if ($isUrlEncode) {
                $url = urlencode($url);
            }
            return file_get_contents($url);
        } catch (\Exception $exception) {
            return $exception->getMessage() . ':' . $exception->getTraceAsString();
        }
    }

    /**
     * 获取错误码
     * @return int
     */
    public function getErrorCode()
    {
        return curl_errno($this->curl);
    }

    /**
     * 获取curl的错误消息
     * @return string
     */
    public function getErrorStr()
    {
        return curl_error($this->curl);
    }

    /**
     * 发起一个post请求
     * @param $url
     * @param $data array|string
     * @param $isBuildQuery bool 对data进行urlencode编码，
     * @return bool|string
     */
    public static function post($url, $data, $isBuildQuery = true)
    {
        try {
            if ($isBuildQuery) {
                $data = http_build_query($data);
            }
            if (is_array($data)) {
                $data = json_encode($data);
            }
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

    public function beforeRequest($url, $data = [])
    {

    }

    protected function afterRequest(&$response)
    {
        if ($this->_returnArrayByJsonDecode) {
            return json_decode($response, true);
        }
        return $response;
    }
}