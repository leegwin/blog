<?php
/**
 * Created by PhpStorm.
 * User: leegwin
 * Date: 2018/7/30
 * Time: 上午10:55
 */

namespace App\Access;

use App\Model\User;
use App\Model\Topic;
use App\Model\Section;
use App\Access\Access as Access;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class TopicAccess extends Access
{
    /**
     * @var Topic
     */
    private $topic;

    /**
     * TopicAccess constructor.
     */
    function __construct() {
        $this->topic = new Topic;
    }

    /**
     * get topic list use topic model
     *
     * @param $pageSize
     * @param $pageNumber
     * @param $sort
     * @param $key
     * @return array
     */
    public function getTopList($pageSize,$pageNumber,$sort,$key)
    {
        $total = $this->topic->getAllBysId($key);
        $begin = $pageSize*($pageNumber-1);
        $reg = '';
        if($sort==0)
            $reg = 'tTime';
        else
            $reg = 'tClickLike';
        $list = array();
        $index = 0;
        $this->result = $this->topic->getAllList($reg,$begin, $pageSize,$key);
        foreach ($this->result as $key=>$topic) {

            $obj=array("index"=>++$index,"tid"=>$topic['tId'],"sid"=>$topic['sId'],"uid"=>$topic['uId'],"topic"=>$topic['tTopic'],"content"=>$topic['tContents']
            ,"createTime"=>$topic['tTime'],"lastClick"=>$topic['tLastClickTime'],"clickLike"=>$topic['tClickLike'],"clickHate"=>$topic['tClickHate']);
            array_push($list,$obj);
        }
        return $this->reback(array("total"=>$total,"list"=>$list),true);
    }

    /**
     * Base topic model get topic information by topic id
     *
     * @param $tId
     * @return array
     */
    public function getTopic($tId)
    {
        $this->result = $this->topic->getBytId($tId);
        if(count($this->result))
        {
            $topic = $this->result;
            return $this->reback(array("sid"=>$topic['sId'],"uid"=>$topic['uId'],"topic"=>$topic['tTopic'],"content"=>$topic['tContents']
                ,"createTime"=>$topic['tTime'],"lastClick"=>$topic['tLastClickTime'],"clickLike"=>$topic['tClickLike'],"clickHate"=>$topic['tClickHate'])
                ,true);
        }else
            return $this->reback("主贴不存在！");

    }

    /**
     * republic a topic use topic model
     *
     * @param $sId
     * @param $uId
     * @param $topic
     * @param $content
     * @param $time
     * @return array
     */
    public function release($sId,$uId,$topic,$content,$time)
    {
        $sec = new Section;
        $tp = $this->topic;
        try{
            $this->result = DB::transaction(function () use( &$sec,&$tp,$sId,$uId,$topic,$content,$time){
                $tp->createTopic($sId,$uId,$topic,$content,$time);
                $sec->plusTopicCount($sId);
                return true;
            });

        }catch (QueryException $e){
            app('sql-log')->info($e->getMessage(), compact('time'));
        }
        if($this->result)
            return $this->reback(array(),true);
        return $this->reback("回复失败！");

    }
}