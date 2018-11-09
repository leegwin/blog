<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//**view route start**//
Route::group ( ['namespace' => 'ViewController',], function () {

    Route::get('user/active',"ViewController@active");
    Route::group(['middleware' => 'checkLogin',], function () {
        Route::get ('/', "ViewController@loginView");
        Route::get ('/login', "ViewController@loginView");
    });

    Route::group(['middleware' => 'checkAuthority',], function () {
        Route::get('/main',"ViewController@mainView" );
        Route::get('/topic',"ViewController@topicView" );
        Route::get('/reply',"ViewController@replyView" );
        Route::get('/zone/releaseTopic',"ViewController@releaseTopicView" );
    });
} );
//**view route end**//

//**api route start**//
Route::group([
    'prefix' => '/api','middleware' => 'api',], function () {

    Route::get('captcha',"ValidateController@getCode");
    //**prefix user group**//
    Route::group([
        'prefix' => '/user',], function () {
        Route::post('login',"UserController@login");
        Route::post('enroll',"UserController@enroll");
        });
    //**check api group**//
    Route::group([
        'middleware' => 'checkApi',], function () {
        Route::group([
            'prefix' => '/email',], function () {
            Route::post('validate',"UserController@sendValidate");
        });
        //**user api group**//
        Route::group([
            'prefix' => '/user',], function () {
            Route::post('altPd',"UserController@altPd");
            Route::get('logOut',"UserController@logOut");
        });
        //**section api group**//
        Route::group([
            'prefix' => '/section',], function () {
            Route::get('list',"SectionController@getList");
            Route::post('list',"SectionController@getIndex");
        });
        //**topic api group**//
        Route::group([
            'prefix' => '/topic',], function () {
            Route::get('list',"TopicController@getList");
            Route::post('find',"TopicController@findTopic");
            Route::post('release',"TopicController@release");
        });
        //**reply api group**//
        Route::group([
            'prefix' => '/reply',], function () {
            Route::get('list',"ReplyController@getList");
            Route::post('release',"ReplyController@release");
        });
        //**user release topic api group**//
        Route::group([
            'prefix' => '/zone',], function () {

        });
    });

});
//**api route end**//