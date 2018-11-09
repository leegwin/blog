var msgdsq;
function show_err_msg(msg){
	jQuery('.msg_bg').html('');
	clearTimeout(msgdsq);
	jQuery('body').append('<div class="sub_err" style="position:absolute;top:60px;left:0;width:500px;z-index:999999;"></div>');
	var errhtml='<div  class="bac" style="padding:8px 0px;width:100%;margin:0 auto;background-color:transparent;color:#FFF;text-align:center;line-height:15px;font-weight:bold;"><img style="margin-right:10px;vertical-align: middle;" src="/assets/images/error.png">';
	var errhtmlfoot='</div>';
	jQuery('.msg_bg').height(jQuery(document).height());
	jQuery('.sub_err').html(errhtml+msg+errhtmlfoot);
	var left=(jQuery(document).width()-500)/2;
	jQuery('.sub_err').css({'left':left+'px'});
	var scroll_height=jQuery(document).scrollTop();
	jQuery('.sub_err').animate({'top': scroll_height+120},300);
	msgdsq=setTimeout(function(){
		jQuery('.sub_err').animate({'top': scroll_height+80},300);
		setTimeout(function(){
			jQuery('.msg_bg').remove();
			jQuery('.sub_err').remove();
		},300);
	}, "1000");
}
function show_msg(msg,url){
	jQuery('.msg_bg').html('');
	clearTimeout(msgdsq);
	jQuery('body').append('<div class="sub_err" style="position:absolute;top:60px;left:0;width:500px;z-index:999999;"></div>');
	var htmltop='<div  class="bac" style="padding:8px 0px;width:100%;margin:0 auto;background-color:transparent;color:#FFF;text-align:center;line-height:15px;font-weight:bold;""><img style="margin-right:10px;" src="/assets/images/loading.gif">';
	var htmlfoot='</div>';
	jQuery('.msg_bg').height(jQuery(document).height());
	var left=(jQuery(document).width()-500)/2;
	jQuery('.sub_err').css({'left':left+'px'});
	jQuery('.sub_err').html(htmltop+msg+htmlfoot);
	var scroll_height=jQuery(document).scrollTop();
	jQuery('.sub_err').animate({'top': scroll_height+120},500);
	msgdsq=setTimeout(function(){
		jQuery('.sub_err').animate({'top': scroll_height+80},500);
		setTimeout(function(){
			jQuery('.msg_bg').remove();
			jQuery('.sub_err').remove();
			if(url!=''&&url!=undefined)
			{
				location.href=url;
			}
		},800);

	}, "1200");
}
function tip_msg(msg){
    clearTimeout(msgdsq);
    var str='<div class="msg_bg" style="background:#000;opacity:0.5;filter:alpha(opacity=50);z-index:99998;width:100%;position:absolute;left:0;top:0;bottom: 0"></div>';
    str+='<div class="msg_content" style="z-index:99999;width:100%;position:absolute;left:0;top:0;bottom 0;text-align:center;"><div class="tipmsg"><img style="margin-right:10px;" src="/assets/images/loading.gif">' +
        msg+'</div></div>'
    jQuery('body').append(str);
    jQuery('.msg_bg').height("100%");
    jQuery('.msg_content').animate({'top': '300px'},300);
    msgdsq=setTimeout(function(){
        var scroll_height=jQuery(document).scrollTop();
        jQuery('.msg_content').animate({'top': scroll_height+80},500);
        setTimeout(function(){
            jQuery('.msg_content').remove();
            jQuery('.msg_bg').remove();
        },800);
    }, "1200");
}
function delete_loading() {
	jQuery('.msg_bg').remove();
	jQuery('.msg_content').remove();

}
function delete_msgContent() {
	jQuery('.msg_content').remove();
}
function quit_confirm()
{
	var str='<div class="msg_bg" style="background:#000;opacity:0.5;filter:alpha(opacity=50);z-index:99998;width:100%;position:absolute;left:0;top:0;bottom: 0"></div>';
	str+='<div class="msg_content" style="z-index:99999;width:100%;position:absolute;left:0;top:0;bottom 0;text-align:center;"><div class="tipbox"><a class="dialog_close" onclick="delete_loading();">关闭</a><div class="dialog_title">确认退出吗？</div>' +
		'<div class="dialog_content"><a class="confirm_bt"  href="javascript:;" onclick="logout();">确定</a><a class="cancel_bt" href="javascript:;" onclick="delete_loading();">取消</a></div></div></div>'
	jQuery('body').append(str);
	jQuery('.msg_bg').height("100%");
	jQuery('.msg_content').animate({'top': '300px'},300);
}

function logout()
{
    event.preventDefault();
	jQuery(document).ready(function($){
		$.get("/api/user/logOut",
			function(data,status){
			data = $.parseJSON(data);
				if(data.status) {
					delete_msgContent();
					show_msg("注销成功…","/login");
				} else {
					alert(data.msg);
				}
			});
	});
}
jQuery(document).ready(function($){
    var succ = '<div id="pdInfo-success" class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>成功！</strong>密码修改成功。</div>';
     function errorTip(msg)
	{
        var error = '<div id="pdInfo" class="alert alert-danger alert-dismissable">' +
			'<a href="#" class="close" data-dismiss="alert">&times;</a><strong>错误！</strong>'+msg+'</div>';
        return error;

    }
    function succTip(msg)
    {
        var succ ='<div id="pdInfo-success" class="alert alert-success">' +
            '<a href="#" class="close" data-dismiss="alert">&times;</a><strong>成功！</strong>'+msg+'</div>';
        return succ;
    }
    $('#user-submit').on('click', function () {
        var npd = $('#newUser-pd').val();
        var cnpd = $('#conform-pd').val();
        var pd = $('#user-pd').val();
        var email = $('#email-validate').val();
        if (email =='') {
            $("#tip-msg").html(errorTip("请输入邮箱验证码！"));
        }else if (pd == '') {
            $("#tip-msg").html(errorTip("请输入原始密码！"));
        } else if (npd != cnpd) {
            $("#tip-msg").html(errorTip("两次密码输入不一致！"));
        } else if (npd == '') {
            $("#tip-msg").html(errorTip("请输入新密码！"));
        }else {
            var opt = {
                type: "POST",
                url: "/api/user/altPd",
                data: {
                    newPd: $('#newUser-pd').val().trim(),
                    oldPd: $('#user-pd').val().trim(),
                    email:$('#email-validate').val().trim(),
                },
                success: function (data) {
                    data = JSON.parse(data);
                    if (data.status) {
                        $("#tip-msg").html(succTip('密码修改成功！'));
                        show_msg('跳转至登录页……','/login')
                    } else {
                        $("#tip-msg").html(errorTip(data.msg));
                    }
                }
            };$.ajax(opt);
        }
    });
    $('#send-email').on('click', function () {
        var opt = {
            type: "POST",
            url: "/api/email/validate",
            success: function (data) {
                data = JSON.parse(data);
                if (data.status) {
                    $("#tip-msg").html(succTip('验证码发送成功，请注意查收！'));
                } else {
                    $("#tip-msg").html(errorTip(data.msg));
                }
            }
        }; $.ajax(opt);
    });
    $('#closeModal-1').on('click', function () {
        var npd = $('#newUser-pd').val('');
        var cnpd = $('#conform-pd').val('');
        var pd = $('#user-pd').val('');
        $('#email-validate').val('');
    });
    $('#closeModal-2').on('click', function () {
        var npd = $('#newUser-pd').val('');
        var cnpd = $('#conform-pd').val('');
        var pd = $('#user-pd').val('');
        $('#email-validate').val('');
    });
});