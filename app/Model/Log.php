<?php
/**
 * Created by PhpStorm.
 * User: leegwin
 * Date: 2018/7/27
 * Time: 上午10:34
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Log extends Model /*默认规则是小写的模型类名复数格式作为与其对应的表名*/
{
    protected $table = 'log';
    protected $primaryKey = 'logId';
    protected $connection = 'mysql';

    public $timestamps = false;
    protected $fillable = ['uName','logIp','logTime'];
    protected $guarded = ['logId'];


}