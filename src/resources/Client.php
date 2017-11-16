<?php

namespace sevenUtils\resources;

use OSS\OssClient;

class Client
{

    // 生命周期相关常量
    const LIFECYCLE_EXPIRATION = "Expiration";
    const LIFECYCLE_TIMING_DAYS = "Days";
    const LIFECYCLE_TIMING_DATE = "Date";
    //OSS 内部常量
    const BUCKET = 'bucket';
    const OBJECT = 'object';
    const METHOD = 'method';
    const QUERY = 'query';
    const BASENAME = 'basename';
    const MAX_KEYS = 'max-keys';
    const UPLOAD_ID = 'uploadId';
    const PART_NUM = 'partNumber';
    const COMP = 'comp';
    const LIVE_CHANNEL_STATUS = 'status';
    const LIVE_CHANNEL_START_TIME = 'startTime';
    const LIVE_CHANNEL_END_TIME = 'endTime';
    const POSITION = 'position';
    const MAX_KEYS_VALUE = 100;
    const FILE_SLICE_SIZE = 8192;
    const PREFIX = 'prefix';
    const DELIMITER = 'delimiter';
    const MARKER = 'marker';
    const ACCEPT_ENCODING = 'Accept-Encoding';
    const CONTENT_MD5 = 'Content-Md5';
    const SELF_CONTENT_MD5 = 'x-oss-meta-md5';
    const CONTENT_TYPE = 'Content-Type';
    const CONTENT_LENGTH = 'Content-Length';
    const IF_MODIFIED_SINCE = 'If-Modified-Since';
    const IF_UNMODIFIED_SINCE = 'If-Unmodified-Since';
    const IF_MATCH = 'If-Match';
    const IF_NONE_MATCH = 'If-None-Match';
    const CACHE_CONTROL = 'Cache-Control';
    const EXPIRES = 'Expires';
    const PREAUTH = 'preauth';
    const CONTENT_COING = 'Content-Coding';
    const CONTENT_DISPOSTION = 'Content-Disposition';
    const RANGE = 'range';
    const ETAG = 'etag';
    const LAST_MODIFIED = 'lastmodified';
    const OS_CONTENT_RANGE = 'Content-Range';
    const BODY = 'body';
    const HOST = 'Host';
    const DATE = 'Date';
    const AUTHORIZATION = 'Authorization';
    const FILE_DOWNLOAD = 'fileDownload';
    const FILE_UPLOAD = 'fileUpload';
    const PART_SIZE = 'partSize';
    const SEEK_TO = 'seekTo';
    const SIZE = 'size';
    const QUERY_STRING = 'query_string';
    const SUB_RESOURCE = 'sub_resource';
    const DEFAULT_PREFIX = 'x-oss-';
    const CHECK_MD5 = 'checkmd5';
    const DEFAULT_CONTENT_TYPE = 'application/octet-stream';

    //私有URL变量
    const URL_ACCESS_KEY_ID = 'OSSAccessKeyId';
    const URL_EXPIRES = 'Expires';
    const URL_SIGNATURE = 'Signature';
    //HTTP方法
    const HTTP_GET = 'GET';
    const HTTP_PUT = 'PUT';
    const HTTP_HEAD = 'HEAD';
    const HTTP_POST = 'POST';
    const HTTP_DELETE = 'DELETE';
    const HTTP_OPTIONS = 'OPTIONS';
    //其他常量
    const ACL = 'x-oss-acl';
    const OBJECT_ACL = 'x-oss-object-acl';
    const OBJECT_GROUP = 'x-oss-file-group';
    const MULTI_PART = 'uploads';
    const MULTI_DELETE = 'delete';
    const OBJECT_COPY_SOURCE = 'x-oss-copy-source';
    const OBJECT_COPY_SOURCE_RANGE = "x-oss-copy-source-range";
    const PROCESS = "x-oss-process";
    const CALLBACK = "x-oss-callback";
    const CALLBACK_VAR = "x-oss-callback-var";
    //支持STS SecurityToken
    const SECURITY_TOKEN = "x-oss-security-token";
    const ACL_TYPE_PRIVATE = 'private';
    const ACL_TYPE_PUBLIC_READ = 'public-read';
    const ACL_TYPE_PUBLIC_READ_WRITE = 'public-read-write';
    const ENCODING_TYPE = "encoding-type";
    const ENCODING_TYPE_URL = "url";


    /**
     * @var OssClient
     */
    protected $driver;

    /**
     * @var string
     */
    public $bucket;

    /**
     * Client constructor.
     * @param $objectParams array
     * [
     *      'class' => 'oss\client',
     *      'construct_params' => ['image', 'aaaaa', 'bbbbb'], //构造函数的第一个参数，第二个参数，第三个参数，最多支持9个参数
     *      'driver_properties' => ['aaa' => 'bbbb'],       //为驱动类的属性赋值
     *      'bucket' => 'image'     //为本类的属性赋值
     * ]
     */
    public function __construct($objectParams)
    {
        if (!isset($objectParams['class'])) {
            throw new  \Exception('must define class', 400);
        }
        $driverClass = $objectParams['class'];
        unset($objectParams['class']);
        if (isset($objectParams['construct_params'])) {
            $constructParams = $objectParams['construct_params'];
            unset($objectParams['construct_params']);
            $paramsCount = count($constructParams);
            if ($paramsCount == 1) {
                $this->driver = new $driverClass($constructParams[0]);
            } elseif ($paramsCount == 2) {
                $this->driver = new $driverClass($constructParams[0], $constructParams[1]);
            } elseif ($paramsCount == 3) {
                $this->driver = new $driverClass($constructParams[0], $constructParams[1], $constructParams[2]);
            } elseif ($paramsCount == 4) {
                $this->driver = new $driverClass($constructParams[0], $constructParams[1], $constructParams[2], $constructParams[3]);
            } elseif ($paramsCount == 5) {
                $this->driver = new $driverClass($constructParams[0], $constructParams[1], $constructParams[2], $constructParams[3], $constructParams[4]);
            } elseif ($paramsCount == 6) {
                $this->driver = new $driverClass($constructParams[0], $constructParams[1], $constructParams[2], $constructParams[3], $constructParams[4],
                    $constructParams[5]);
            } elseif ($paramsCount == 7) {
                $this->driver = new $driverClass($constructParams[0], $constructParams[1], $constructParams[2], $constructParams[3], $constructParams[4],
                    $constructParams[5], $constructParams[6]);
            } elseif ($paramsCount == 8) {
                $this->driver = new $driverClass($constructParams[0], $constructParams[1], $constructParams[2], $constructParams[3], $constructParams[4],
                    $constructParams[5], $constructParams[6], $constructParams[7]);
            } elseif ($paramsCount == 9) {
                $this->driver = new $driverClass($constructParams[0], $constructParams[1], $constructParams[2], $constructParams[3], $constructParams[4],
                    $constructParams[5], $constructParams[6], $constructParams[7], $constructParams[8]);
            } else {
                throw new \Exception('only support max 9 construct params', 400);
            }
        } else {
            $this->driver = new $driverClass;
        }
        if (isset($objectParams['driver_properties'])) {
            $driverProperties = $objectParams['driver_properties'];
            unset($objectParams['driver_properties']);
            foreach ($driverProperties as $key=>$value) {
                $this->driver->$key = $value;
            }
        }
        if (!empty($objectParams)) {
            foreach ($objectParams as $key=>$value) {
                $this->$key = $value;
            }
        }
    }

    public function createBucket($bucket = null, $acl = self::ACL_TYPE_PUBLIC_READ, $options = NULL)
    {
        if (!$bucket) {
            $bucket = $this->bucket;
        }
        return $this->driver->createBucket($bucket, $acl, $options);
    }

    public function doesBucketExist($bucket = null)
    {
        if (!$bucket) {
            $bucket = $this->bucket;
        }
        return $this->driver->doesBucketExist($bucket);
    }

    public function listBuckets($options)
    {
        return $this->driver->listBuckets($options);
    }

    public function deleteBucket($bucket = null, $options = [])
    {
        if (!$bucket) {
            $bucket = $this->bucket;
        }
        return $this->driver->deleteBucket($bucket, $options);
    }

    public function putBucketAcl($acl, $bucket = null, $options = [])
    {
        if (!$bucket) {
            $bucket = $this->bucket;
        }
        return $this->driver->putBucketAcl($bucket, $acl, $options);
    }

    public function getBucketAcl($bucket = null, $options = [])
    {
        if (!$bucket) {
            $bucket = $this->bucket;
        }
        return $this->driver->getBucketAcl($bucket, $options);
    }

    public function putObject($object, $content,$bucket, $options = [])
    {
        if (!$bucket) {
            $bucket = $this->bucket;
        }
        return $this->driver->putObject($bucket, $object, $content, $options);
    }

    public function uploadFile($object, $filePath, $bucket, $options = [])
    {
        if (!$bucket) {
            $bucket = $this->bucket;
        }
        return $this->driver->uploadFile($bucket, $object, $filePath, $options);
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
        if (!$bucket) {
            $bucket = $this->bucket;
        }
        return $this->driver->uploadDir($bucket, $name, $localDir,$exclude, $recursive, $checkMd5);
    }

    public function getObject($object, $bucket = null, $options = [])
    {
        if (!$bucket) {
            $bucket = $this->bucket;
        }
        return $this->driver->getObject($object, $bucket, $options);
    }

    public function signUrl($object, $timeout = 3600, $bucket = null)
    {
        if (!$bucket) {
            $bucket = $this->bucket;
        }
        return $this->driver->signUrl($bucket, $object, $timeout);
    }

    public function __call($name, $arguments)
    {
        $paramsCount = count($arguments);
        if ($paramsCount == 0) {
            return $this->driver->$name();
        } elseif ($paramsCount == 1) {
            return $this->driver->$name($arguments[0]);
        } elseif ($paramsCount == 2) {
            return $this->driver->$name($arguments[0], $arguments[1]);
        } elseif ($paramsCount == 3) {
            return $this->driver->$name($arguments[0], $arguments[1], $arguments[2]);
        } elseif ($paramsCount == 4) {
            return $this->driver->$name($arguments[0], $arguments[1], $arguments[2], $arguments[3]);
        } elseif ($paramsCount == 5) {
            return $this->driver->$name($arguments[0], $arguments[1], $arguments[2], $arguments[3], $arguments[4]);
        } elseif ($paramsCount == 6) {
            return $this->driver->$name($arguments[0], $arguments[1], $arguments[2], $arguments[3], $arguments[4],
                $arguments[5]);
        } elseif ($paramsCount == 7) {
            return $this->driver->$name($arguments[0], $arguments[1], $arguments[2], $arguments[3], $arguments[4],
                $arguments[5], $arguments[6]);
        } elseif ($paramsCount == 8) {
            return $this->driver->$name($arguments[0], $arguments[1], $arguments[2], $arguments[3], $arguments[4],
                $arguments[5], $arguments[6], $arguments[7]);
        } elseif ($paramsCount == 9) {
            return $this->driver->$name($arguments[0], $arguments[1], $arguments[2], $arguments[3], $arguments[4],
                $arguments[5], $arguments[6], $arguments[7], $arguments[8]);
        } else {
            throw new \Exception('only support max 9 params', 400);
        }
        // TODO: Implement __call() method.
    }
}