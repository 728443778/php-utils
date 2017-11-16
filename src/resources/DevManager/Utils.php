<?php

namespace sevenUtils\resources\DevManager;

class Utils
{
    const OPERATION_UPLOAD_OBJECT = 1;
    const OPERATION_CREATE_BUCKET = 2;
    const OPERATION_DELETE_BUCKET= 3;
    const OPERATION_UPLOAD_DIR = 4;
    const OPERATION_DELETE_OBJECT = 5;
    const OPERATION_BUCKET_IS_EXIST = 6;
    const OPERATION_LIST_BUCKETS = 7;
    const OPERATION_SET_BUCKET_ACL = 8;
    const OPERATION_GET_BUCKET_ACL = 9;
    const OPERATION_PUT_CONTENT_TO_OBJECT = 10;
    const OPERATION_GET_OBJECT = 11;
    const OPERATION_SIGN_URL = 12;

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


    public static function getErrorStrByErrorCode($errorCode)
    {
        switch ($errorCode) {
            default:
                return $errorCode;
        }
    }
}