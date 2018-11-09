<?php
/**
 * Created by PhpStorm.
 * User: leegwin
 * Date: 2018/7/27
 * Time: 上午10:14
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attribute  table name.
     *
     * @var string
     */
    protected $table = 'roles';
    /**
     * The attribute user primary key.
     *
     * @var int
     */
    protected $primaryKey = 'roId';
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
    protected $fillable = ['roName','authSec','authTop','authRec','authMan'];
    /**
     * The attribute Blacklist forbid create by id
     *
     * @var array $guarded
     */
    protected $guarded = ['roId'];

    /**
     * Get role information by role id
     *
     * @param $id
     * @return role object
     */
    public function getById($id)
    {
        return $this::where(['roId'=>$id])->first();
    }

}