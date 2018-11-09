<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /**
     * encapsulation user information to response class,
     * All return information is passed through this class
     *
     * @param json $data
     * @param bool $status
     * @param int $statusCode
     * @param string $contentType
     * @param string $charSet
     * @return mixed|response
     */
    public function response($data,$status=false,$statusCode=200,$contentType='text/html',$charSet = 'utf-8')
    {
        $content = array("status"=>$status,$status == true?"data":"msg"=>$data);
        $response = response($content,$statusCode)->setCharset($charSet)->header('Content-Type', $contentType);
        app('response-log')->info($response, compact('time'));
        return $response;
    }
}
