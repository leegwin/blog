<?php
/**
 * Created by PhpStorm.
 * User: leegwin
 * Date: 2018/7/26
 * Time: 下午2:30
 */
namespace App\Http\Controllers;

use App\Access\UserAccess as UserAccess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Func\Tool as Tool;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;
use App\Jobs\SendEmail;
use Config;
use Storage;


class UserController extends Controller
{
    /**
     * @var UserAccess
     */
    private $user;

    /**
     * UserController constructor.
     */
    function __construct() {
        $this->user = new UserAccess;

    }

    /**
     * Check whether the user's login is legitimate
     *
     * @param Request $request
     * @return response|mixed
     */
    public function login(Request $request)
    {
        /*Validate the request start...*/
        $check = array('username');
        if(Tool::checkEmpty($request,$check))
        {
            $error = array('msg'=>"用户名不能为空！",'code'=>0);
            return $this->response($error);
        }
        $ipErrorCount = intval(Redis::get("IP:".$request->ip()));
        $userErrorCount = intval(Redis::get("NAME:".$request['username']));
        if($ipErrorCount>2||$userErrorCount>2)
        {
            $check = array('captcha','password','holdStatus');
            $code = strtolower($request['captcha']);
            if($code != session('captcha'))
            {
                $error = array('msg'=>"验证码输入有误！",'code'=>0);
                return $this->response($error);
            }
        }
        else
            $check = array('password','holdStatus');

        if(Tool::checkEmpty($request,$check))
        {
            $error = array('msg'=>"数据格式有误！",'code'=>0);
            return $this->response($error);
        }
        $name = $request['username'];
        $holdStatus = $request['holdStatus'];
        $pd = md5($request['password']);/**Using MD5 to encrypt the password*/
        /*Validate the request end...*/
        $result =  $this->user->check($name,$pd);
        if(!$result['status'])
        {
            ++$ipErrorCount;
            ++$userErrorCount;
            Redis::set("IP:".$request->ip(),$ipErrorCount);
            Redis::set("NAME:".$name,$userErrorCount);
            if($ipErrorCount>2||$userErrorCount>2)
                $error = array('msg'=>$result['msg'],'code'=>1);
            else
                $error = array('msg'=>$result['msg'],'code'=>0);
            return $this->response($error);
        }
        Redis::del("IP:".$request->ip());
        Redis::del("NAME:".$name);
        $uId = $result['data']['uId'];
        $uEmail = $result['data']['uEmail'];
        $IP=Tool::getIP();
        $holdTime = intval(Config::get('system.expiry'));
        if($holdStatus ==1)
            $holdTime =$holdTime*24;/**1 day*/
        if($holdStatus ==2)
            $holdTime = $holdTime*24*7;/**7 day*/
        $expiry=time()+$holdTime;
        $block = Config::get('system.block');
        $key=Config::get('system.key');
        $value=$name.$block.$pd.$block.$IP.$block.$expiry;
        $token=Tool::encrypt($value, $key);
        session(['user' => $name,'email'=>$uEmail]);/**set session*/
        session([session('user') => $uId]);
        Cookie::queue('sid',$token,$holdTime/60);
        /**set cookie The queue method is automatically added to reponse with a valid time unit of minutes.*/
        $this->user->putToken($name,$token);/**update token*/
        return $this->response(array(),true);

    }

    /**
     * user logout
     *
     * @param Request $request
     * @return response|mixed
     */
    public function logOut(Request $request)
    {
        $name = session('user');
        $this->user->putToken($name,null);/**update token*/
        $request->session()->forget('user');
        $request->session()->forget($name);
        $cookie = Cookie::forget('sid');
        Cookie::queue($cookie);
        return $this->response(array(),true);

    }

    /**
     * update user password
     *
     * @param Request $request
     * @return response|mixed
     */
    public function altPd(Request $request)
    {
        /*Validate the request start...*/
        $check = array('newPd','oldPd','email');
        if(Tool::checkEmpty($request,$check))
        {
            return $this->response("数据格式有误！");
        }
        if(strlen($request['newPd'])<6||strlen($request['newPd'])>12)
        {
            return $this->response("密码长度必须介于6位和12位之间！");
        }
        $preg = '/^[A-Za-z0-9]+$/';
        if(!preg_match($preg,$request['newPd']))
        {
            return $this->response("密码只能由数字和字母组成！");
        }
        /*Validate the request end...*/
        $name = session('user');
        $uId = session($name);
        $newPd = md5($request['newPd']);
        $oldPd = md5($request['oldPd']);
        $email = session('email');
        $code = strval($request['email']);
        if(strval(Redis::get("EMAIL:".$email)) != $code)
            return $this->response("验证码错误");
        $result = $this->user->putPassword($uId,$newPd,$oldPd);
        if(!$result['status'])
        {
            return $this->response($result['msg']);
        }
        return $this->response(array(),true);


    }

    /**
     * update user telephone information
     *
     * @param Request $request
     * @return response|mixed
     */
    public function bindPhone(Request $request)
    {
        /*Validate the request start...*/
        $check = array('phone');
        if(Tool::checkEmpty($request,$check))
        {
            return $this->response("数据格式有误！");
        }
        $pattern="/^((1[3,5,8][0-9])|(14[5,7])|(17[0,6,7,8])|(19[7]))\d{8}$/";
        if(!preg_match($pattern,$request['phone']))
        {
            return $this->response("手机号格式有误！");
        }
        /*Validate the request end...*/

    }

    /**
     * enroll user
     *
     * @param Request $request
     * @return response|mixed
     */
    public function enroll(Request $request)
    {
        /*Validate the request start...*/
        $check = array('username','password','email','birthday','sex','captcha');
        if(Tool::checkEmpty($request,$check))
        {
            return $this->response("数据格式有误！");
        }
        if(strlen($request['username'])<3||strlen($request['username'])>12)
        {
            return $this->response("用户名长度必须介于3位和12位之间！");
        }
        if(strlen($request['password'])<6||strlen($request['password'])>12)
        {
            return $this->response("密码长度必须介于6位和12位之间！");
        }
        $preg = '/^[A-Za-z0-9]+$/';
        if(!preg_match($preg,$request['password']))
        {
            return $this->response("密码只能由数字和字母组成！");
        }
        $pattern="/^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/";
        if(!preg_match($pattern,$request['email']))
        {
            return $this->response("邮箱格式有误！");
        }
        $time = '/^[1-9]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/';
        if(!preg_match($time,$request['birthday']))
        {
            return $this->response("日期格式有误！");
        }
        $sex = '/^[0-1]$/';
        if(!preg_match($sex,$request['sex']))
        {
            return $this->response("性别格式有误！");
        }
        if($request['captcha'] != session('captcha'))
        {
            return $this->response("验证码输入有误！");
        }
        /*Validate the request end...*/

        $name = $request['username'];
        $pd = md5($request['password']);
        $email = $request['email'];
        $birthday = $request['birthday'];
        $sex = $request['sex'];
        $regTime=date('Y-m-d H:i:s',time());
        $result = $this->user->enroll($name,$pd,$email,$birthday,$sex,$regTime);
        if(!$result['status'])
        {
            return $this->response($result['msg']);
        }
        /*send active email start...*/
        $block = Config::get('system.block');
        $key=Config::get('system.key');
        $value=$name.$block.time();
        $keyValue=Tool::encrypt($value, $key);
        $host =Config::get('system.host');
        $activeUrl = $host."/user/active?key=".$keyValue;
        $sendEmail = new SendEmail($email,$activeUrl);
        $this->dispatch($sendEmail);
        $mailArray=explode('@',$email);
        $mailUrl = 'http://mail.'.$mailArray[1];
        /*send active email end...*/
        return $this->response(array('url'=>$mailUrl),true);
    }

    /**
     * send validate code for user modify the password
     *
     * @param Request $request
     * @return response|mixed
     */
    public function sendValidate(Request $request)
    {

        /*send active email start...*/
        $email = session('email');
        if(Redis::get("EMAIL:".$email))
            return $this->response(Config::get('system.emailExpiry').'分钟内请勿重复点击！');
        $timeout = intval(Config::get('system.emailExpiry'))*60;
        $code = substr(strval(rand(10001,19999)),1,4);
        Redis::setex("EMAIL:".$email,$timeout,$code);/*时间单位为秒*/
        $sendEmail = new SendEmail($email,$code,true);
        $this->dispatch($sendEmail);
        /*send active email end...*/
        return $this->response(array(),true);
    }
}