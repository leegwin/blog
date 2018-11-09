<?php
/**
 * Created by PhpStorm.
 * User: leegwin
 * Date: 2018/7/26
 * Time: 下午2:06
 */
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * The attribute  table name.
     *
     * @var string
     */
    protected $table = 'users';
    /**
     * The attribute user primary key.
     *
     * @var int
     */
    protected $primaryKey = 'uId';
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
    protected $fillable = ['uName','uPassword','token','roId','uPhone','uEmail','uBirthday','uSex','uRegDate','uState','uMark'];
    /**
     * The attribute Blacklist
     *
     * @var array $guarded
     */
    protected $guarded = ['uId'];
    /**
     * get user information by user name(uName).
     *
     * @param  string  $name
     * @return user object
     */
    public function getByName($name)
    {
        return $this::where(['uName'=>$name])->first();
    }
    /**
     * get user information by user id(uId).
     *
     * @param  int  $id
     * @return user object
     */
    public function getById($id)
    {
        return $this::where(['uId'=>$id])->first();
    }
    /**
     * get user information by user phone number(uPhone).
     *
     * @param  string  $phone
     * @return user object
     */
    public function getByPhone($phone)
    {
        return $this::where(['uPhone'=>$phone])->first();
    }
    /**
     * get user information by user email(uEmail).
     *
     * @param  string  $email
     * @return user object
     */
    public function getByEmail($email)
    {
        return $this::where(['uEmail'=>$email])->first();
    }
    /**
     * set user token by user name and token.
     *
     * @param  string  $name
     * @param  string $token
     * @return bool
     */
    public function setToken($name,$token)
    {
        return $this::where('uName','=',$name)->update(['token' => $token]);
    }
    /**
     * set user status by user name .
     *
     * @param  string  $name
     * @return bool
     */
    public function setStatus($name)
    {
        return $this::where(['uName'=>$name])->update(['uState' => 0]);;
    }
    /**
     * set user password by user id and password.
     *
     * @param  integer  $id
     * @param  string $pd
     * @return bool
     */
    public function setPassword($id,$pd)
    {
        return $this::where('uId','=',$id)->update(['uPassword' => $pd]);

    }
    /**
     * create a user information into database.
     *
     * @param  string  $name
     * @param  string $pd
     * @param  string $email
     * @param  date $birth
     * @param  bool sex
     * @param  dateTime $regDate
     * @return bool
     */
    public function createUser($name,$pd,$email,$birth,$sex,$regDate)
    {
        $userObj = new self;
        $userObj->uName = $name;
        $userObj->uPassword = $pd;
        $userObj->uEmail = $email;
        $userObj->uBirthday = $birth;
        $userObj->uSex = $sex;
        $userObj->uRegDate = $regDate;
        return $userObj->save();
    }

}