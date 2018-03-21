<?php
//错误号都1w起，避免和系统级别的错误混淆
define('ERROR_NONE', 0);
define('ERROR_NOT_FOUND', 404);
define('ERROR_MOBILE_NUMBER_EXISTS', 10001);
define('ERROR_MOBILE_NUMBER_INVALID', 10002);
define('ERROR_CAPTCHA_INVALID', 10003);
define('ERROR_MOBILE_CAPTCHA_INVALID', 10004);
define('ERROR_INVALID_PARAM', 10005);
define('ERROR_PASSWORD_LENGTH_INVALID', 10006);
define('ERROR_MOBILE_NUMBER_NOT_EXISTS', 10007);
define('ERROR_LOGIN_PASSWORD_ERROR', 10008);
define('ERROR_LOGIN_MOBILE_OR_PASSWORD_EMPTY', 10009);
define('ERROR_AUTH_TIME_OUT', 10010);
define('ERROR_PLATFORM_ID_PARAM_EMPTY', 10011);
define('ERROR_AUTH_TOKEN_PARAM_EMPTY', 10012);
define('ERROR_AUTH_TIME_PARAM_EMPTY', 10013);
define('ERROR_APP_ID_PARAM_EMPTY', 10014);
define('ERROR_PLATFORM_NOT_EXISTS', 10015);
define('ERROR_PLATFORM_ACCESS_AUTH_FAILED', 10016);
define('ERROR_LOGIN_FAILED', 10017);
define('ERROR_APP_NOT_EXISTS', 10018);
define('ERROR_APP_ACCESS_AUTH_FAILED', 10019);
define('ERROR_USER_STATUS_IS_DISABLE', 10020);
define('ERROR_USER_NOT_LOGIN', 10021);
define('ERROR_OPERATION_FAILED', 10022);
define('ERROR_GOLD_NOT_ENOUGH', 10023);
define('ERROR_OPEARTION_TOO_BUSY', 10024);
define('ERROR_BALANCE_NOT_ENOUGH', 10025);
define('ERROR_EXCHANGE_GOLD_IS_NEGATIVE', 10026);
define('ERROR_REQUEST_PARAM_MISS_USER_IP', 10027);
define('ERROR_CLIENT_IP_DATA_INVALID', 10028);  //客户端ip地址格式错误
define('ERROR_SEND_SMS_FAILED', 10029); //发送短信失败
define('ERROR_CAPTCHA_IS_SEND', 10030);
define('ERROR_CAPTCHA_VERIFY_FAILED', 10031);
define('ERROR_CAPTCHA_NOT_FOUND', 10032);
define('ERROR_REQUEST_TOO_BUSY', 10033);
define('ERROR_USER_NOT_EXISTS', 10034);
define('ERROR_OLD_PASSWORD_REQUIRED', 10035);
define('ERROR_PASSWORD_ERROR', 10036);
define('ERROR_REQUEST_DATA_EMPTY', 10037);
define('ERROR_UPLOAD_FILE_NUMBER_ERROR', 10038);
define('ERROR_UPLOAD_FILE_FAILED', 10039);
define('ERROR_UPLOAD_FILE_TYPE_ERROR', 10040);
define('ERROR_BUCKET_NOT_EXISTS', 10041);
define('ERROR_OBJECT_NAME_INVALID', 10042);
define('ERROR_BUCKET_PARAM_INVALID', 10043);
define('ERROR_ACCESS_FORBIDDEN', 403);
define('ERROR_UPLOAD_FILE_SIZE_ERROR', 10044);
define('ERROR_REQUEST_DATA_INVALID', 10045);
define('ERROR_OBJECTS_DOES_NOT_EXISTS', 10046);
define('ERROR_REQUEST_METHOD_INVALID', 10047);
define('ERROR_REGISTER_FAILED', 10048);
define('ERROR_INVALID_REQUEST_METHOD', 10049);
define('ERROR_PROCESS_FAILED', 10050);
define('ERROR_GET_MONGODB_CONNECTION_FAILED', 20000);
define('ERROR_SELECT_MONGODB_COLLECTION_FAILED', 20001);