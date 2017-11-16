<?php

namespace sevenUtils\resources;

use OSS\OssClient;
use sevenUtils\resources\DevManager\Utils;

class Client
{

    public function getErrorMessage()
    {
        return $this->driver->getErrorMessage();
    }

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

    public function createBucket($bucket = null, $acl = Utils::ACL_TYPE_PUBLIC_READ, $options = NULL)
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

    public function uploadFile($object, $filePath, $bucket = null, $options = [])
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