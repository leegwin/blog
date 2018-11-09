<?php
/**
 * Created by PhpStorm.
 * User: leegwin
 * Date: 2018/7/30
 * Time: 上午10:52
 */

namespace App\Http\Controllers;

use App\Access\TopicAccess as TopicAccess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Func\Tool as Tool;
use Illuminate\Support\Facades\Cookie;
use Config;

class TopicController extends Controller
{
    /**
     * @var TopicAccess
     */
    private $topic;

    /**
     * TopicController constructor.
     */
    function __construct() {
        $this->topic = new TopicAccess;

    }

    /**
     * Get the topic list
     *
     * @param Request $request
     * @return response|mixed
     */
    public function getList(Request $request)
    {
        /*Validate the request start...*/
        $check = array('pageSize','pageNumber','sort','key');
        if(Tool::checkEmpty($request,$check))
        {
            return $this->response("数据格式有误！");
        }
        $pageSize=$request['pageSize'];
        $pageNumber=$request['pageNumber'];
        $sort = $request['sort'];
        $key = $request['key'];

        $pregKey = '/^[1-9]\d*$/';
        if(!preg_match($pregKey,$key))
        {
            return $this->response("key值有误！");
        }
        $pregSort = '/^[0-1]$/';
        if(!preg_match($pregSort,$sort))
        {
            return $this->response("排序格式有误！");
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
        $result = $this->topic->getTopList($pageSize,$pageNumber,$sort,$key);
        if(!$result['status'])
        {
            return $this->response($result['msg']);
        }
        $data = $result['data'];
        return $this->response($data,true);

    }

    /**
     *Get the appoint topic information
     *
     * @param Request $request
     * @return response|mixed
     */
    public function findTopic(Request $request)
    {
        /*Validate the request start...*/
        $check = array('tid');
        if(Tool::checkEmpty($request,$check))
        {
            return $this->response("数据格式有误！");
        }
        $tId=$request['tid'];
        $pregId = '/^[1-9]\d*$/';
        if(!preg_match($pregId,$tId))
        {
            return $this->response("id值有误！");
        }
        /*Validate the request end...*/
        $result = $this->topic->getTopic($tId);
        if(!$result['status'])
        {
            return $this->response($result['msg']);
        }
        $data = $result['data'];
        return $this->response($data,true);

    }

    /**
     * release topic
     *
     * @param Request $request
     * @return response|mixed
     */
    public function release(Request $request)
    {
        /*Validate the request start...*/
        $check = array('index','topic','content');
        if(Tool::checkEmpty($request,$check))
        {
            return $this->response("数据格式有误！");
        }
        $sId=$request['index'];
        $content=$request['content'];
        $topic = $_POST['topic'];
        $time =date('Y-m-d H:i:s');
        $name = session('user');
        $uId = session($name);

        $pregId = '/^[1-9]\d*$/';
        if(!preg_match($pregId,$sId))
        {
            return $this->response("id值有误！");
        }
        /*Validate the request end...*/
        $result = $this->topic->release($sId,$uId,$topic,$content,$time);
        if(!$result['status'])
        {
            return $this->response($result['msg']);
        }
        return $this->response(array(),true);

    }


}