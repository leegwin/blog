<?php
/**
 * Created by PhpStorm.
 * User: leegwin
 * Date: 2018/7/27
 * Time: 上午11:14
 */

namespace App\Access;


class Access
{
    /**
     * @var string|object
     */
    protected $result;

    /**
     * @return object|string
     */
    protected function getResult()
    {
        return $this->result;
    }

    /**
     * The unified export of the access layer to return information
     *
     * @param $msg string|array
     * @param bool $status
     * @return array
     */
    protected function reback($msg,$status = false)
    {
        return array("status"=>$status,$status==true?"data":"msg"=>$msg);
    }
}