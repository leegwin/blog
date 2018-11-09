<?php
/**
 * Created by PhpStorm.
 * User: leegwin
 * Date: 2018/7/27
 * Time: 上午10:33
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $table = 'reply';
    protected $primaryKey = 'rId';
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
    protected $fillable = ['tId','uId','rContents','rTime','rType'];
    /**
     * The attribute Blacklist forbid create by id
     *
     * @var array $guarded
     */
    protected $guarded = ['rId'];

    /**
     * Get reply information by topic id (tId)
     * @param $key
     * @return integer
     */
    public function getAllBytId($key)
    {
        return $this::where(['tId'=>$key])->count();
    }

    /**
     * Get pagination reply information
     *
     * @param $begin
     * @param $pageSize
     * @param $key
     * @return array
     */
    public function getAllList($begin, $pageSize,$key)
    {
        return $this::where(['tId'=>$key])->orderBy('rTime', 'ASC')->skip($begin)->limit($pageSize)->get()->toArray();
    }

    /**
     * create reply
     *
     * @param $tId
     * @param $content
     * @param $time
     * @param $uId
     * @return bool
     */
    public function createReply($tId,$content,$time,$uId)
    {
        $replyObj = new self;
        $replyObj->tId = $tId;
        $replyObj->uId = $uId;
        $replyObj->rContents = $content;
        $replyObj->rTime = $time;
        return $replyObj->save();
    }

}