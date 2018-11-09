<?php
/**
 * Created by PhpStorm.
 * User: leegwin
 * Date: 2018/7/31
 * Time: 下午1:05
 */

namespace App\Http\Middleware;
use Closure;
use App\Access\UserAccess as UserAccess;

abstract class UserMiddleware
{
    /**
     * @var UserAccess
     */
    protected $user;

    /**
     * UserMiddleware constructor.
     */
    function __construct()
    {
        $this->user = new UserAccess;
    }

    /**
     * abstract function check session
     *
     * @param $request
     * @return mixed
     */
    abstract function checkSession($request);

    /**abstract function check cookie
     * @param $request
     * @return mixed
     */
    abstract function checkCookie($request);

    /**
     * This is a Template function loginFlag equal true is after login check.
     * responseFlag equal true the method will response content.
     * @param $request
     * @param Closure $next
     * @param $loginFlag
     * @param $responseFlag
     * @param string $url
     * @return redirect|response|next
     */
    protected function redirectUser($request,Closure $next,$loginFlag,$responseFlag,$url='/')
    {
        $response = response('Unauthorized.', 401);
        if($request->session()->has('user'))/*check session*/
            if ($this->checkSession($request))
                return $loginFlag == true ? ($responseFlag == true ? $response:redirect($url)) : $next($request);

        if($request->cookie('sid'))/*check cookie*/
            if($this->checkCookie($request))
                return $loginFlag == true ? ($responseFlag == true ? $response:redirect($url)) : $next($request);
            else
                return $loginFlag == true ? $next($request):($responseFlag == true? $response : redirect($url));

        return $loginFlag ==true ? $next($request) : ($responseFlag == true ? $response:redirect($url));

    }

}