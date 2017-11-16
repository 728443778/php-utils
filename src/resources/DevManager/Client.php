<?php

namespace sevenUtils\resources\DevManager;

use sevenUtils\HttpRequest;

class Client
{
    public $accessId;

    public $accessKeySecret;

    public $endpoint;

    protected $httpClient;

    protected $response;

    protected $errorCode = 0;

    public function getErrorMessage()
    {
        if ($this->httpClient->getErrorCode()) {
            $error =  $this->httpClient->getErrorStr();
            if ($error) {
                return $error;
            }
        }
        $error = Utils::getErrorStrByErrorCode($this->errorCode);
        if ($error) {
            return $error;
        }
        return $this->response;
    }

    public function authParams()
    {
        $time = time();
        return [
            'access_id' => $this->accessId,
            'access_token' => md5($this->accessKeySecret . $time),
            'access_at' => $time
        ];
    }

    public function __construct($accessId, $accessKeySecret, $endpoint)
    {
        $this->accessId = $accessId;
        $this->accessKeySecret = $accessKeySecret;
        $this->endpoint = $endpoint;
        $this->httpClient = new HttpRequest();
    }

    protected function requestIsOk($response)
    {
        $this->errorCode = 0;
        $this->response = $response;
        $result = json_decode($response, true);
        if (isset($result['code']) && $result['code'] == ERROR_NONE) {
            return $result;
        }
        if (isset($result['code'])) {
            $this->errorCode = $result['code'];
            return false;
        }
        $this->errorCode = $this->httpClient->getErrorCode();
        return false;
    }

    public function createBucket($bucket, $acl, $options = NULL)
    {
        $params = $this->authParams();
        $params['bucket'] = $bucket;
        $params['acl'] = $acl;
        $params['options'] = $options;
        $params['operation'] = Utils::OPERATION_CREATE_BUCKET;
        $response = $this->httpClient->requestPost($this->endpoint, $params);
        if ($this->requestIsOk($response)) {
            return true;
        }
        return false;
    }

    public function doesBucketExist($bucket = null)
    {
        $params = $this->authParams();
        $params['bucket'] = $bucket;
        $params['operation'] = Utils::OPERATION_BUCKET_IS_EXIST;
        $response = $this->httpClient->requestPost($this->endpoint, $params);
        return $this->requestIsOk($response);
    }

    public function listBuckets($options)
    {
        $params = $this->authParams();
        $params['options'] = $options;
        $params['operation'] = Utils::OPERATION_LIST_BUCKETS;
        $responose = $this->httpClient->requestPost($this->endpoint, $params);
        $result = $this->requestIsOk($responose);
        if (!$result) {
            return false;
        }
        return $result['data'];
    }

    public function deleteBucket($bucket = null, $options = [])
    {
        $params = $this->authParams();
        $params['operation'] = Utils::OPERATION_DELETE_BUCKET;
        $params['options'] = $options;
        $params['bucket'] = $bucket;
        $response = $this->httpClient->requestPost($this->endpoint, $params);
        return $this->requestIsOk($response);
    }

    public function putBucketAcl($acl, $bucket = null, $options = [])
    {
        $params = $this->authParams();
        $params['bucket'] = $bucket;
        $params['acl'] = $acl;
        $params['options'] = $options;
        $params['operation'] = Utils::OPERATION_SET_BUCKET_ACL;
        $response = $this->httpClient->requestPost($this->endpoint, $params);
        return $this->requestIsOk($response);
    }

    public function getBucketAcl($bucket = null, $options = [])
    {
        $params = $this->authParams();
        $params['bucket'] = $bucket;
        $params['options'] = $options;
        $params['operation'] = Utils::OPERATION_GET_BUCKET_ACL;
        $response = $this->httpClient->requestPost($this->endpoint, $params);
        $result = $this->requestIsOk($response);
        if (!$result) {
            return false;
        }
        return $result['data'];
    }

    public function putObject($object, $content,$bucket, $options = [])
    {
        $params = $this->authParams();
        $params['bucket'] = $bucket;
        $params['object'] = $object;
        $params['content'] = $content;
        $params['options'] = $options;
        $params['operation'] = Utils::OPERATION_PUT_CONTENT_TO_OBJECT;
        return $this->requestIsOk($this->httpClient->requestPost($this->endpoint, $params));
    }

    public function uploadFile($object, $filePath, $bucket, $options = [])
    {
        if (!is_file($filePath)) {
            throw new \Exception($filePath .' is not file', 400);
        }
        $file = $this->httpClient->createFile($filePath, 'aaa', 'file');
        $params = $this->authParams();
        $params['object'] = $object;
        $params['file'] = $file;
        $params['bucket'] = $bucket;
        $params['options'] = $options;
        return $this->requestIsOk($this->httpClient->requestPost($this->endpoint, $params));
    }

    /**
     * @param $name string 上传到远程服务器的名字
     * @param $localDir
     * @param null $bucket
     * @param string $exclude
     * @param bool $recursive
     * @param bool $checkMd5
     * @return array
     */
    public function uploadDir($name, $localDir,$bucket = null, $exclude = '.|..|.svn|.git', $recursive = false, $checkMd5 = true)
    {
        throw new \Exception('unsupport methods uploadDir', 400);
    }

    public function getObject($object, $bucket, $options = [])
    {
        $params = $this->authParams();
        $params['bucket'] = $bucket;
        $params['object'] = $object;
        $params['operation'] = Utils::OPERATION_GET_OBJECT;
        if (isset($options['local_file'])) {
            $this->httpClient->downLoadFile($this->endpoint, $params, $options['local_file']);
            return true;
        }
        return $this->httpClient->requestPost($this->endpoint, $params);
    }

    public function signUrl($object, $timeout = 3600, $bucket = null)
    {
        $params = $this->authParams();
        $params['bucket'] = $bucket;
        $params['timeout'] = $timeout;
        $params['object'] = $object;
        $response = $this->httpClient->requestPost($this->endpoint, $params);
        $result = $this->requestIsOk($response);
        if (!$result) {
            return false;
        }
        return $result['data'];
    }


}