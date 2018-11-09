<?php
/**
 * Created by PhpStorm.
 * User: leegwin
 * Date: 2018/7/26
 * Time: 下午2:30
 */
namespace App\Http\Controllers;

use App\Func\ValidateCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class ValidateController extends Controller
{
    /**
     * @var ValidateCode
     */
    private $_vc;

    /**
     * ValidateController constructor.
     */
    function __construct() {
        $this->_vc = new ValidateCode;
        $this->_vc->doimg();
    }

    /**
     * Get the captcha code from the session
     *
     * @param Request $request
     */
    public function getCode(Request $request)
    {
        session(['captcha' => $this->_vc->getCode()]);
    }
}