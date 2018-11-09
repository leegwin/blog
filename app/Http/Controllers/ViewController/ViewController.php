<?php
/**
 * Created by PhpStorm.
 * User: leegwin
 * Date: 2018/7/28
 * Time: 下午9:02
 */

namespace App\Http\Controllers\ViewController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Func\Tool as Tool;
use Illuminate\Support\Facades\Redis;
use App\Access\UserAccess as UserAccess;
use Config;


class ViewController extends Controller
{
    private $user;
    private $email;
    function __construct()
    {
        $this->user = session('user');
        $email = session('email');
        $email_array = explode("@", $email);
        $prevfix = (strlen($email_array[0]) < 4) ? substr($email, 0, strlen($email_array[0])-1) : substr($email, 0, 3);
        $count = 0;
        $str = preg_replace('/([\d\w+_-]{0,100})@/', '***@', $email, -1, $count);
        $this->email = $prevfix . $str;

    }
    public function getViewData(Request $request)
    {
        $auth = array("sec"=>$request->get('sec'),"top"=>$request->get('top'),
            "rep"=>$request->get('rep'),"man"=>$request->get('man'));

        return ["user"=>$this->user,"email"=>$this->email,"auth"=>$auth ];
    }
    public function loginView(Request $request)
    {
        return view('login')->with(array('errorCount'=>intval(Redis::get($request->ip()))));

    }
    public function mainView(Request $request)
    {
        return view('main')->with($this->getViewData($request));
    }
    public function topicView(Request $request)
    {
        return view('topic')->with($this->getViewData($request));
    }
    public function replyView(Request $request)
    {
        return view('reply')->with($this->getViewData($request));
    }
    public function releaseTopicView(Request $request)
    {
        return view('releaseTopic')->with($this->getViewData($request));
    }
    public function active(Request $request)
    {
        /*Validate the request start...*/
        $check = array('key');
        if(Tool::checkEmpty($request,$check))
        {
            return view('active')->with(array('msg'=>"你正在进行非法操作！"));
        }
        /*Validate the request end...*/

        $activeCode = $request['key'];
        $block = Config::get('system.block');
        $key=Config::get('system.key');
        $keyValue=Tool::decrypt($activeCode, $key);
        $activeArray=explode($block,$keyValue);
        if(count($activeArray)!=2)
            return view('active')->with(array('msg'=>"你正在进行非法操作！"));

        $name = $activeArray[0];
        $time = $activeArray[1];
        if(!$name)
            return view('active')->with(array('msg'=>"你正在进行非法操作！"));

        $preg = '/[0-9].*/';
        if(!preg_match($preg,$time))
        {
            return view('active')->with(array('msg'=>"你正在进行非法操作！"));
        }
        $user = new UserAccess;
        $result = $user->active($name,$time);
        if(!$result['status'])
        {
            return view('active')->with(array('msg'=>$result['msg']));
        }
        return view('active')->with(array('msg'=>'恭喜你激活成功！'));

    }

}