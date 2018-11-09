<?php
/**
 * Created by PhpStorm.
 * User: leegwin
 * Date: 2018/7/27
 * Time: 上午11:09
 */
namespace App\Access;

use App\Model\User;
use App\Model\Role;
use App\Access\Access as Access;

class UserAccess extends Access
{
    /**
     * @var User
     */
    private $user;

    /**
     * UserAccess constructor.
     */
    function __construct() {
        $this->user = new User;
    }

    /**
     * check user information use user model
     *
     * @param $name
     * @param $pd
     * @return array
     */
    public function check($name,$pd)
    {
        $this->result = $this->user->getByName($name);
         if($this->result)
         {
             if($this->result->uPassword == $pd)
             {
                 if($this->result->uState)
                 {
                     return $this->reback("该账号未激活！");
                 }else
                     return $this->reback(array("token"=>$this->result->token,"uId"=>$this->result->uId,
                                        "uEmail"=>$this->result->uEmail),true);
             }else
                 return $this->reback("用户名或密码有误！");
         }else
             return $this->reback("用户名或密码有误！");
    }

    /**
     * Base user model get user authority by user id
     *
     * @param $uId
     * @return array
     */
    public function getAuthority($uId)
    {
        $this->result = $this->user->getById($uId);
        if($this->result)
        {
            $roId = $this->result->roId;
            $role = new Role;
            $this->result = $role->getById($roId);
            if($this->result)
            {
                return $this->reback(array("sec"=>$this->result->authSec,"top"=>$this->result->authTop,
                    "rep"=>$this->result->authRep,"man"=>$this->result->authMan),true);
            }
            return $this->reback("角色不存在！");
        }
        return $this->reback("用户不存在！");

    }

    /**
     * update user token
     *
     * @param $name
     * @param $token
     * @return bool
     */
    public function putToken($name,$token)
    {
         return $this->user->setToken($name,$token);/**返回值为true或false*/
    }

    /**
     * update user password
     *
     * @param $uId
     * @param $newPd
     * @param $oldPd
     * @return array
     */
    public function putPassword($uId,$newPd,$oldPd)
    {
        $this->result = $this->user->getById($uId);
        if($this->result)
        {
            if($this->result->uPassword == $oldPd)
            {
                if($this->result->uState)
                {
                    return $this->reback("该账号未激活！");
                }else
                {
                    if($this->user->setPassword($uId,$newPd))
                    {
                        return $this->reback(array(),true);
                    }else
                        return $this->reback("修改密码失败，请稍后重试！");
                }
            }else
                return $this->reback("原密码有误！");
        }else
            return $this->reback("用户名不存在！");
    }

    /**
     * enroll user
     *
     * @param $name
     * @param $pd
     * @param $email
     * @param $birthday
     * @param $sex
     * @param $regTime
     * @return array
     */
    public function enroll($name,$pd,$email,$birthday,$sex,$regTime)
    {
        if($this->user->getByName($name))
        {
            return $this->reback("用户名已经存在！");
        }else if($this->user->getByEmail($email))
            return $this->reback("邮箱已经被绑定！");
        else
        {
            $this->result = $this->user->createUser($name,$pd,$email,$birthday,$sex,$regTime);
            if($this->result)
                return $this->reback(array(),true);
            return $this->reback("注册失败！");
        }

    }

    /**
     * active enroll user
     *
     * @param $name
     * @param int $time
     * @return array
     */
    public function active($name,$time=0)
    {
        $this->result = $this->user->getByName($name);
        if($this->result)
        {
            $regTime = strtotime($this->result->uRegDate);
            if($time>time()||$time<$regTime)
                return $this->reback("你正在进行非法操作！");
            if(!$this->result->uState)
                return $this->reback("该账户已激活，请勿重复操作！");
            $this->user->setStatus($name);
            return $this->reback(array(),true);
        }else
            return $this->reback("用户不存在！");

    }

}