<?php
/**
 * Created by PhpStorm.
 * User: leegwin
 * Date: 2018/7/27
 * Time: 上午10:15
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    /**
     * The attribute  table name.
     *
     * @var string
     */
    protected $table = 'topic';
    /**
     * The attribute user primary key.
     *
     * @var int
     */
    protected $primaryKey = 'tId';
    /**
     * The attribute connection engine.
     *
     * @var string
     */
    protected $connection = 'mysql';
    /**
     * The attribute control 'update_at' and 'create_at' field exit .
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The attribute White list
     *
     * @var array $fillable
     */
    protected $fillable = ['sId','uId','tTopic','tContents','tTime','tFlag','tMark','tLastClickTime','tClickLike','tClickHate'];
    /**
     * The attribute Blacklist forbid create by id
     *
     * @var array $guarded
     */
    protected $guarded = ['tId'];
    /**
     * get all topic information by section id(sId).
     *
     * @param  int  $key
     * @return integer
     */
    public function getAllBysId($key)
    {
        return $this::where(['sId'=>$key])->count();
    }
    /**
     * get topic list information for pagination by section id(sId) and other params.
     *
     * @param  string  $reg
     * @param  int $begin
     * @param  int $pageSize
     * @param  int $key
     * @return array
     */
    public function getAllList($reg,$begin, $pageSize,$key)
    {
        return $this::where(['sId'=>$key])->orderBy($reg, 'DESC')->skip($begin)->limit($pageSize)->get()->toArray();
    }
    /**
     * get topic information by topic id(tId).
     *
     * @param  int  $tId
     * @return array
     */
    public function getBytId($tId)
    {
        return $this::where(['tId'=>$tId])->first()->toArray();
    }
    /**
     * insert topic information into database.
     *
     * @param  int  $sId
     * @param  int $uId
     * @param  string $topic
     * @param  string $content
     * @param  dateTime $time
     * @return bool
     */
    public function createTopic($sId,$uId,$topic,$content,$time)
    {
        $topicObj = new self;
        $topicObj->uId = $uId;
        $topicObj->sId = $sId;
        $topicObj->tTopic = $topic;
        $topicObj->tContents = $content;
        $topicObj->tTime = $time;
        return $topicObj->save();
    }
}