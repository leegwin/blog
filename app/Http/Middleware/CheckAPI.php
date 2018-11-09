<?php
/**
 * Created by PhpStorm.
 * User: leegwin
 * Date: 2018/7/29
 * Time: 下午4:56
 */

namespace App\Http\Middleware;

use Closure;
use App\Http\Middleware\CheckUser as CheckUser;

class CheckAPI extends CheckUser
{
    /**
     * override the abstract function checkSession.
     *If not override this function then the parent function will work.
     *
     * @param $request
     * @return bool|mixed
     */
    public function checkSession($request)
    {
        return false;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $this->redirectUser($request,$next,false,true);
        /* Consider all users as unregistered States check api*/
    }
}