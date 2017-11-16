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


    public static function getErrorStrByErrorCode($errorCode)
    {
        switch ($errorCode) {
            default:
                return 'other error';
        }
    }
}