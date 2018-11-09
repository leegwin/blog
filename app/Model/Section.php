<?php
/**
 * Created by PhpStorm.
 * User: leegwin
 * Date: 2018/7/27
 * Time: 上午10:15
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    /**
     * The attribute  table name.
     *
     * @var string
     */
    protected $table = 'section';
    /**
     * The attribute user primary key.
     *
     * @var int
     */
    protected $primaryKey = 'sId';
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
    protected $fillable = ['sName','sImg','uId','sMark','sClickCount','sTopicCount','sTime'];
    /**
     * The attribute Blacklist forbid create by id
     *
     * @var array $guarded
     */
    protected $guarded = ['sId'];
    /**
     * Get the number of all the section.
     *
     * @return integer
     */
    public function getAll()
    {
        return $this::all()->count();
    }
    /**
     * Get all information of the section.
     *
     * @return array
     */
    public function getAllIndex()
    {
        return $this::all()->toArray();
    }

    /**
     * Update the number of topics in the section(plus)
     * @param $sId
     * @return mixed
     */
    public function plusTopicCount($sId)
    {
        $section = $this::where(['sId'=>$sId])->first();
        $section->sTopicCount = $section->sTopicCount + 1;
        return $section->save();
    }
    /**
     * Update the number of topics in the section(minus)
     * @param $sId
     * @return mixed
     */
    public function minusTopicCount($sId)
    {
        $section = $this::where(['sId'=>$sId])->first();
        $section->sTopicCount = $section->sTopicCount - 1;
        return $section->save();
    }

    /**
     * Get pagination section information
     *
     * @param $reg
     * @param $begin
     * @param $pageSize
     * @return mixed
     */
    public function getAllList($reg,$begin, $pageSize)
    {
        return $this::orderBy($reg, 'DESC')->skip($begin)->limit($pageSize)->get()->toArray();
    }

}