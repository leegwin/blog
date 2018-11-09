<?php
/**
 * Created by PhpStorm.
 * User: leegwin
 * Date: 2018/7/29
 * Time: 上午11:15
 */

namespace App\Http\Middleware;

use App\Http\Middleware\UserMiddleware as UserMiddleware;
use App\Func\Tool as Tool;
use Config;

class CheckUser extends UserMiddleware
{
    /**
     * override the abstract function checkSession.
     * The function of this function checks whether the session is legitimate.
     *
     * @param $request
     * @return bool|mixed
     */
    public function checkSession($request)
    {
        /*get the data for Access method*/
        $name = session('user');
        $uId = session($name);
        /*check the data use Access method*/
        $result =  $this->user->getAuthority($uId);
        if($result['status'])
        {
            $data = $result['data'];
            $request->merge($data);/*merge data*/
            return true;
        }
        return false;
    }

    /**
     * override the abstract function checkCookie.
     * The function of this function checks whether the cookie is legitimate.
     *
     * @param $request
     * @return bool|mixed
     */
    public function checkCookie($request)
    {
        /*get the data for Access method*/
        $userIP=Tool::getIP();
        $block = Config::get('system.block');
        $key=Config::get('system.key');
        $sid = $request->cookie('sid');
        $tokenArray=explode($block,Tool::decrypt($sid, $key));
        if(count($tokenArray)!=4)
            return false;
        $tokenName = $tokenArray[0];
        $tokenPd = $tokenArray[1];
        $tokenIP = $tokenArray[2];
        $tokenExpiry = $tokenArray[3];
        /*check the data use Access method*/
        $result =  $this->user->check($tokenName,$tokenPd);
        if(!$result['status'])
            return false;
        /*get the data for validate*/
        $data = $result['data'];
        $token = $data['token'];
        $uId = $data['uId'];
        $uEmail = $data['uEmail'];
        $name = $tokenName;
        /*validate the data*/
        $expiry=(double)$tokenExpiry-time();
        if(($token==$sid)&&($tokenIP==$userIP)&&($expiry>0))
        {
            $result =  $this->user->getAuthority($uId);
            if($result['status'])
            {
                session(['user' => $name,'email'=>$uEmail]);/**set session*/
                session([session('user') => $uId]);
                $data = $result['data'];
                $request->merge($data);/*merge data*/
                return true;
            }
            return false;
        }
        return false;

    }
}