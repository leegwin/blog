<?php
/**
 * Created by PhpStorm.
 * User: leegwin
 * Date: 2018/7/29
 * Time: 下午9:57
 */

namespace App\Http\Controllers;

use App\Access\SectionAccess as SectionAccess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Func\Tool as Tool;
use Config;

class SectionController extends Controller
{
    /**
     * @var SectionAccess
     */
    private $section;

    /***
     * SectionController constructor.
     */
    function __construct() {
        $this->section = new SectionAccess;

    }

    /**
     * Get section list array
     *
     * @param Request $request
     * @return response|mixed
     */
    public function getList(Request $request)
    {
        /*Validate the request start...*/
        $check = array('pageSize','pageNumber','sort');
        if(Tool::checkEmpty($request,$check))
        {
            return $this->response("数据格式有误！");
        }
        $pageSize=$request['pageSize'];
        $pageNumber=$request['pageNumber'];
        $sort = $request['sort'];

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
        $result = $this->section->getSecList($pageSize,$pageNumber,$sort);
        if(!$result['status'])
        {
            return $this->response($result['msg']);
        }
        $data = $result['data'];
        return $this->response($data,true);
    }

    /**
     * Get selected list for topic release content section id and section name
     *
     * @param Request $request
     * @return response|mixed
     */
    public function getIndex(Request $request)
    {
        $result = $this->section->getIndex();
        if(!$result['status'])
        {
            return $this->response($result['msg']);
        }
        $data = $result['data'];
        return $this->response($data,true);
    }

}