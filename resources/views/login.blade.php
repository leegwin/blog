<!DOCTYPE html>
<html lang="zh" class="no-js">
<head>
    <title>leegwin贴吧</title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/supersized.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/login.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/title.ico') }}" >
</head>
<body>
<div class="page-container" id="loginBox" >
    <div class="main_box">
        <div class="login_box">
            <div class="login_logo">
                <strong>leegwin贴吧</strong>
            </div>
            <div class="login_form">
                <form id="login_form" method="post">
                    <div class="form-group">
                        <label  class="bg_user v_align" for="username"></label>
                        <input id="username"  name="username" onblur="value=value.replace(/\s+/g,'')" type="text" class="style_x319 v_align"
                               autocomplete="off" placeholder="用户名">
                    </div>
                    <div class="form-group">
                        <label  class="bg_pd v_align" for="password"></label>
                        <input id="password" onblur="value=value.replace(/\s+/g,'')" name="password" type="password"
                               class="style_x319 v_align" placeholder="密码">
                    </div>
                    <div class="form-group" id="auto">
                        @if($errorCount>2)
                            @include('common.captcha')
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="checkbox-inline">
                            自动登录
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="optionsCheckbox" id="optionsCheckbox1" value="option1"> 1天
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="optionsCheckbox" id="optionsCheckbox2"  value="option2"> 7天
                        </label>
                    </div>
                    <div class="form-group">
                        <div id="token_error" class="error_hint" ></div>
                    </div>
                    <div class="form-group bottom_box_style">　　
                        <button type="button"  id="submit_btn"
                                class="btn btn-primary btn-lg button_style">&nbsp;登&nbsp;录&nbsp </button>
                        <input type="button" value="&nbsp;注&nbsp;册&nbsp;" class="btn btn-default btn-lg" id="register">
                    </div>
                </form>
            </div>
        </div>
        <div class="bottom">Copyright Leegwin&copy;2018</div>
    </div>
</div>
<div class="page-container" id="registerBox" style="display: none">
    <div class="register_box">
        <div class="login_box">
            <div class="login_logo">
                <strong>leegwin贴吧</strong>
            </div>
            <div class="login_form">
                <form id="register_form" method="post">
                    <div class="form-group">
                        <label  class="bg_user v_align" for="rusername"></label>
                        <input id="rusername"  name="rusername" type="text" class="style_x319 v_align"
                               autocomplete="off" onblur="value=value.replace(/\s+/g,'')" maxlength="12" placeholder="用户名">
                    </div>
                    <div class="form-group">
                        <label  class="bg_pd v_align" for="rpassword"></label>
                        <input id="rpassword" name="rpassword" type="password"
                               class="style_x319 v_align" placeholder="密码" onblur="value=value.replace(/\s+/g,'')" maxlength="12">
                    </div>
                    <div class="form-group">
                        <label  class="bg_phone v_align" for="remail"></label>
                        <input id="remail" name="remail" class="style_x319 v_align" onblur="value=value.replace(/\s+/g,'')" placeholder="邮箱">
                    </div>
                    <div class="form-group">
                        <label  class="bg_birthday v_align" for="rbirthday"></label>
                        <input id="rbirthday" name="rbirthday" class="style_x319 v_align" type="date" placeholder="生日">
                    </div>
                    <div class="form-group">
                        <label  class="bg_sex v_align" for="rsex"></label>
                        <select id="rsex" name="rsex" class="style_x319 v_align" placeholder="性别">
                            <option value="1" selected>男</option>
                            <option value="0">女</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input name="r_captcha" type="text" class="style_x164 v_align" onblur="value=value.replace(/\s+/g,'')" id="r_captcha" placeholder="验证码">
                        <img class="captcha_img v_align" alt="点击更换" title="点击更换" src="./api/captcha" id="rf-captcha" onclick="this.src='/api/captcha?rd='+Math.random();">
                        <div id="rtoken_error" class="error_hint" ></div>
                    </div>
                    <div class="form-group bottom_box_style">　　
                        <button type="button"  id="rsubmit_btn"
                                class="btn btn-primary btn-lg button_style">&nbsp;注&nbsp;册&nbsp </button>
                        <input type="button" value="&nbsp;返&nbsp;回&nbsp;" class="btn btn-default btn-lg" id="reBack">
                    </div>
                </form>
            </div>
        </div>
        <div class="bottom">Copyright Leegwin&copy;2018</div>
    </div>
</div>
</body>
<!-- Javascript -->
<script src="{{ URL::asset('assets/js/jquery-1.11.3.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/user.tooltips.js') }}"></script>
<script src="{{ URL::asset('assets/js/supersized.3.2.7.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/background-init.js') }}"></script>
<script src="{{ URL::asset('assets/js/login.js') }}"></script>
</html>