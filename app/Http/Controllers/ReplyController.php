<?php
/**
 * Created by PhpStorm.
 * User: leegwin
 * Date: 2018/7/30
 * Time: 上午10:52
 */

namespace App\Http\Controllers;

use App\Access\ReplyAccess as ReplyAccess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Func\Tool as Tool;
use Illuminate\Support\Facades\Cookie;
use Config;

class ReplyController extends Controller
{
    /**
     * @var ReplyAccess
     */
    private $reply;

    /**
     * ReplyController constructor.
     */
    function __construct() {
        $this->reply = new ReplyAccess;

    }

    /**
     * Get reply list information
     *
     * @param Request $request
     * @return response|mixed
     */
    public function getList(Request $request)
    {
        /*Validate the request start...*/
        $check = array('pageSize','pageNumber','key');
        if(Tool::checkEmpty($request,$check))
        {
            return $this->response("数据格式有误！");
        }
        $pageSize=$request['pageSize'];
        $pageNumber=$request['pageNumber'];
        $key = $request['key'];

        $pregKey = '/^[1-9]\d*$/';
        if(!preg_match($pregKey,$key))
        {
            return $this->response("key值有误！");
        }
        $pregSize = '/^[1-9]\d{1}$/';
        if(!preg_match($pregSize,$pageSize))
        {
            return $this->response("页面显示条数超出范围(10-99)！");
        }
        $pregN = '/^[1-9]\d*$/';
        if(!preg_match($pregN,$pageNumber))
        {
            return $this->response("页码格式有误！");
        }
        /*Validate the request end...*/
        $result = $this->reply->getRepList($pageSize,$pageNumber,$key);
        if(!$result['status'])
        {
            return $this->response($result['msg']);
        }
        $data = $result['data'];
        return $this->response($data,true);
    }

    /**
     * release reply
     *
     * @param Request $request
     * @return response|mixed
     */
    public function release(Request $request)
    {
        /*Validate the request start...*/
        $check = array('tid','content');
        if(Tool::checkEmpty($request,$check))
        {
            return $this->response("数据格式有误！");
        }
        $tId=$request['tid'];
        $content=$request['content'];
        $time =date('Y-m-d H:i:s');
        $name = session('user');
        $uId = session($name);

        $pregId = '/^[1-9]\d*$/';
        if(!preg_match($pregId,$tId))
        {
            return $this->response("id值有误！");
        }
        /*Validate the request end...*/
        $result = $this->reply->createReply($tId,$content,$time,$uId);
        if(!$result['status'])
        {
            return $this->response($result['msg']);
        }
        return $this->response(array(),true);

    }

}