<?php
/**
 * Created by PhpStorm.
 * User: leegwin
 * Date: 2018/7/29
 * Time: 下午9:59
 */

namespace App\Access;

use App\Model\User;
use App\Model\Section;
use App\Access\Access as Access;

class SectionAccess extends Access
{
    /**
     * @var Section
     */
    private $section;

    /**
     * SectionAccess constructor.
     */
    function __construct() {
        $this->section = new Section;
    }

    /**
     * get section list use section model
     *
     * @param $pageSize
     * @param $pageNumber
     * @param $sort
     * @return array
     */
    public function getSecList($pageSize,$pageNumber,$sort)
    {
        $total = $this->section->getAll();
        $begin = $pageSize*($pageNumber-1);
        $reg = '';
        if($sort==0)
            $reg='sClickCount';
        else
            $reg='sTopicCount';

        $list = array();
        $this->result = $this->section->getAllList($reg,$begin, $pageSize);
        foreach ($this->result as $key=>$section) {

            $obj=array("index"=>$section['sId'],"name"=>$section['sName'],"img"=>$section['sImg'],"authority"=>$section['uId'],"mark"=>$section['sMark']
            ,"clickCount"=>$section['sClickCount'],"topicCount"=>$section['sTopicCount'],"time"=>$section['sTime']);
            array_push($list,$obj);
        }
        return $this->reback(array("total"=>$total,"list"=>$list),true);
    }

    /**
     * get the section list for selected option use section model
     *
     * @return array
     */
    public function getIndex()
    {
        $this->result = $this->section->getAllIndex();
        $list = array();
        foreach ($this->result as $key=>$section) {

            $obj=array("index"=>$section['sId'],"sec"=>$section['sName']);
            array_push($list,$obj);
        }
        return $this->reback($list,true);
    }

}