//form check
jQuery(document).ready(function($) {
    $('#register').on('click',function(){
        document.getElementById("loginBox").style.display="none";
        document.getElementById("registerBox").style.display="";
    });
    $('#reBack').on('click',function(){
        document.getElementById("loginBox").style.display="";
        document.getElementById("registerBox").style.display="none";
    });
	$('.page-container form').submit(function(){
		var username = $(this).find('.username').val();
		var password = $(this).find('.password').val();
		if(username == '') {
			$(this).find('.error').fadeOut('fast', function(){
				$(this).css('top', '27px');
			});
			$(this).find('.error').fadeIn('fast', function(){
				$(this).parent().find('.username').focus();
			});
			return false;
		}
		if(password == '') {
			$(this).find('.error').fadeOut('fast', function(){
				$(this).css('top', '96px');
			});
			$(this).find('.error').fadeIn('fast', function(){
				$(this).parent().find('.password').focus();
			});
			return false;
		}
	});

	$('.page-container form .username, .page-container form .password').keyup(function(){
		$(this).parent().find('.error').fadeOut('fast');
	});
    $('#submit_btn').on('click',function(){
        if($("#username").val()=="")
        {
            show_err_msg('用户名不能为空');
            $("#username").focus();

        }else if($("#password").val()=="")
        {
            show_err_msg('密码不能为空');
            $("#password").focus();

        }else if($("#j_captcha").length > 0 && $("#j_captcha").val()=="") {
            show_err_msg('验证码不能为空');
            $("#j_captcha").focus();
        }else
        {
            var opt={
                type:"POST",
                url:"/api/user/login",
                data:{username:$("#username").val().trim(),
                    password:$("#password").val().trim(),
                    captcha:function () {
                        if($("#j_captcha").length > 0)
                            return $("#j_captcha").val().trim();
                        return null;},
                    holdStatus:function (){
                        if($("#optionsCheckbox1").prop("checked"))
                            return 1;//one day
                        if($("#optionsCheckbox2").prop("checked"))
                            return 2;//seven day
                        return 0;},
                },
                success:function(data){
                    data = $.parseJSON(data);
                    if(data.status){
                        show_msg("登录成功…","main");
                    }else {
                        var validate = '<input id="j_captcha" name="j_captcha" type="text" onblur="value=value.replace(/\\s+/g,\'\')" class="style_x164 v_align" placeholder="验证码">\n' +
                            '<img id="captcha" class="captcha_img v_align" alt="点击更换" title="点击更换" src="/api/captcha" onclick="this.src=\'/api/captcha?rd=\'+Math.random();">\n'
                        data = data.msg;
                        if(data.code)
                            $("#auto").html(validate);
                        $("#token_error").html(data.msg);
                    }
                }
            };$.ajax(opt);
        }
        $('#captcha').click();
    });
    document.onkeydown=function(event){
        var e = event || window.event || arguments.callee.caller.arguments[0];
        if(e && e.keyCode==13){ // enter 键
            document.getElementById("submit_btn").click();
        }
    };
    $('#optionsCheckbox1').on('click',function(){
        if($("#optionsCheckbox2").prop("checked"))
        {
            $("#optionsCheckbox2").prop("checked",false)
        }
    });
    $('#optionsCheckbox2').on('click',function(){
        if($("#optionsCheckbox1").prop("checked"))
        {
            $("#optionsCheckbox1").prop("checked",false)
        }
    });
    $('#j_captcha').on('onfocus',function(){
        document.getElementById('token_error').innerHTML = "";
    });
    function checkEmail(str){
        var re = /^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/;
        if (re.test(str)) {
            return true;
        } else {
            return false;
        }
    };
//register information

    $('#rsubmit_btn').on('click',function(){
        if($("#rusername").val()=="")
        {
            $('#rtoken_error').html('用户名不能为空');
            $("#rusername").focus();

        }else if($("#rpassword").val()=="")
        {
            $('#rtoken_error').html('密码不能为空');
            $("#rpassword").focus();

        } else if($("#remail").val()=="")
        {
            $('#rtoken_error').html('邮箱不能为空');
            $("#remail").focus();

        } else if(!checkEmail($("#remail").val()))
        {
            $('#rtoken_error').html('邮箱格式错误');
            $("#remail").focus();

        }else if($("#rbirthday").val()=="")
        {
            $('#rtoken_error').html('生日不能为空');
            $("#rbirthday").focus();

        } else if($("#r_captcha").val()=="")
        {
            $('#rtoken_error').html('验证码不能为空');
            $("#r_captcha").focus();

        }else
        {
            var opt={
                type:"POST",
                url:"/api/user/enroll",
                data:{username:$("#rusername").val().trim(),
                    password:$("#rpassword").val().trim(),
                    email:$("#remail").val().trim(),
                    birthday:$("#rbirthday").val().trim(),
                    sex:$('#rsex option:selected') .val(),
                    captcha:$("#r_captcha").val().trim()},
                success:function(data){
                    data = $.parseJSON(data);
                    if(data.status == true){
                        data = data.data;
                        show_msg("注册成功,前往邮箱激活账号…",data.url);
                    }else {
                        $('#rtoken_error').html(data.msg);
                    }
                }
            };$.ajax(opt);
        }
        $("#rf-captcha").click();
    });
});