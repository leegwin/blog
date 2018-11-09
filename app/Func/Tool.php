<?php
/**
 * Created by PhpStorm.
 * User: leegwin
 * Date: 2018/7/27
 * Time: 下午2:29
 */

namespace App\Func;


class Tool
{
    /**
     * static data reback function
     *
     * @param $array
     * @param bool $status
     */
    static function reback($array,$status = false)
    {
        echo json_encode(array("status"=>$status,$status == true?"data":"msg"=>$array));
    }

    /**
     * Determine data whether or not it is empty
     *
     * @param $obj
     * @param $array
     * @return bool
     */
    static function checkEmpty($obj,$array)
    {
        for($index = 0;$index<count($array);++$index)
        {
            $str = $array[$index];
            if(!isset($obj[$str])||$obj[$str]=='')
                return true;
        }
        return false;
    }

    /**
     * Get the client IP method
     *
     * @return array|false|string
     */
    static function getIP()

    {

        $IP='';

        if (isset($_SERVER)){

            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){

                $IP = $_SERVER["HTTP_X_FORWARDED_FOR"];

            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {

                $IP = $_SERVER["HTTP_CLIENT_IP"];

            } else {

                $IP = $_SERVER["REMOTE_ADDR"];

            }

        } else {

            if (getenv("HTTP_X_FORWARDED_FOR")){

                $IP = getenv("HTTP_X_FORWARDED_FOR");

            } else if (getenv("HTTP_CLIENT_IP")) {

                $IP = getenv("HTTP_CLIENT_IP");

            } else {

                $IP = getenv("REMOTE_ADDR");

            }

        }

        return $IP;
    }

    /**
     * Symmetric encryption algorithm：encryption
     *
     * @param $data
     * @param $key
     * @return string
     */
    static function encrypt($data, $key)
    {
        $key	=	md5($key);
        $x		=	0;
        $len	=	strlen($data);
        $l		=	strlen($key);
        $char = '';
        $str = '';
        for ($i = 0; $i < $len; $i++)
        {
            if ($x == $l)
            {
                $x = 0;
            }
            $char .= $key{$x};
            $x++;
        }
        for ($i = 0; $i < $len; $i++)
        {
            $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);
        }
        return base64_encode($str);
    }

    /**
     *Symmetric encryption algorithm： Decrypt
     *
     * @param $data
     * @param $key
     * @return string
     */
    static function decrypt($data, $key)
    {
        $key = md5($key);
        $x = 0;
        $data = base64_decode($data);
        $len = strlen($data);
        $l = strlen($key);
        $char = '';
        $str = '';
        for ($i = 0; $i < $len; $i++)
        {
            if ($x == $l)
            {
                $x = 0;
            }
            $char .= substr($key, $x, 1);
            $x++;
        }
        for ($i = 0; $i < $len; $i++)
        {
            if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1)))
            {
                $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
            }
            else
            {
                $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
            }
        }
        return $str;
    }
    /**$data = 'admin|<>|172.21.14.84|<>|1467124656'; //被加密信息格式
      *  $key = 'key123';					//密钥
      *  $encrypt = encrypt($data, $key);//加密
      *  $decrypt = decrypt($encrypt, $key);//解密
      */

}