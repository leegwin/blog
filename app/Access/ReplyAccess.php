<?php
/**
 * Created by PhpStorm.
 * User: leegwin
 * Date: 2018/7/30
 * Time: 上午10:56
 */

namespace App\Access;

use App\Model\User;
use App\Model\Section;
use App\Model\Topic;
use App\Model\Reply;
use App\Access\Access as Access;

class ReplyAccess extends Access
{
    /**
     * @var Reply
     */
    private $reply;

    /**
     * ReplyAccess constructor.
     */
    function __construct() {
        $this->reply = new Reply;
    }

    /**
     * Get reply list information from the reply model
     *
     * @param $pageSize
     * @param $pageNumber
     * @param $key
     * @return array
     */
    public function getRepList($pageSize,$pageNumber,$key)
    {
        $total = $this->reply->getAllBytId($key);
        $begin = $pageSize*($pageNumber-1);
        $list = array();
        $index = 0;
        $this->result = $this->reply->getAllList($begin, $pageSize,$key);
        foreach ($this->result as $key=>$reply) {

            $obj=array("index"=>++$index,"content"=>$reply['rContents'],"time"=>$reply['rTime'],"type"=>$reply['rType']);
            array_push($list,$obj);
        }
        return $this->reback(array("total"=>$total,"list"=>$list),true);
    }

    /**
     * create reply information use reply model
     *
     * @param $tId
     * @param $content
     * @param $time
     * @param $uId
     * @return array
     */
    public function createReply($tId,$content,$time,$uId)
    {
        $this->result = $this->reply->createReply($tId,$content,$time,$uId);
        if($this->result)
            return $this->reback(array(),true);
        return $this->reback("回复失败！");

    }

}