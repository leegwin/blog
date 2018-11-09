<?php
/**
 * Created by PhpStorm.
 * User: leegwin
 * Date: 2018/8/10
 * Time: 下午2:21
 */

namespace App\Http\Middleware;
use Closure;
use App\Func\Tool as Tool;

class Filter
{
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
        app('request-log')->info(Tool::getIP()." ".$request, compact('time'));
        return $next($request);
    }

}