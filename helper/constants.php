<?php
/**
 * 常量定义
 * User: kang
 * Date: 16/6/5
 * Time: 16:05
 */

/***************系统常量*****************/
define('APP_LARAVEL_PATH',dirname(__DIR__));//laravel 目录路径
define('APP_STATICFILE_PATH',dirname(__DIR__).'/resources/static');    //用到的静态文件存放位置
define('APP_TEMPFILE_OUTPUT_PATH',dirname(__DIR__).'/storage/app/public'); //生成的临时文件存放位置
define('APP_TEMPFILE_OUTPUT_PEN_TMP',dirname(__DIR__).'/storage/app/public/tmp.jpeg'); //生成的临时文件存放位置


/***************错误信息*****************/
define('CODE_SUCCESS',0);
define('CODE_FAIL',1);

//通用提示 CODE_B_XXXX
define('CODE_B_VALID_FAIL', 10000);
define('CODE_B_ACCOUNT_NOT_EXIST',10100);
define('CODE_B_ACCOUNT_EXIST',10101);
define('CODE_B_ACCOUNT_PASSWORD_ERR',10102);
define('CODE_B_DB_INSERT_FAIL',10201); // 数据库插入失败
define('CODE_B_DB_UPDATE_FAIL',10201); // 数据库更新失败

//转换错误提示
define('CODE_C_UPLOAD_FILE_TYPE_ERR',20000);