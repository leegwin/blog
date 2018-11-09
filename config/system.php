<?php
/**
 * Created by PhpStorm.
 * User: leegwin
 * Date: 2018/7/27
 * Time: 下午4:28
 */
return [

    /*
    |--------------------------------------------------------------------------
    | set token expiry time
    |--------------------------------------------------------------------------
    |
    */
    'expiry' => 3600,/*默认登录后cookie有效期1小时*/
    'key' => 'leegwin123',/*密钥*/
    'block' => '|<>|',/*密钥分割块*/
    'host' => 'http://www.blog.com',/*host url*/
    'emailExpiry' => 5,/*默认邮箱验证码有效期5分钟*/
];
