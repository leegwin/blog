<nav class="navbar navbar-default top-navbar" role="navigation">
    <div class="navbar-header">
        <script type="text/javascript"> function main(){ location.href="/main" }</script>
        <a class="navbar-brand" style="cursor: pointer" onclick="main()">leegwin贴吧</a>
    </div>
    <!-- /.company-icon -->
    <ul class="nav navbar-right">
        <li style="color: #ffffff;">欢迎你</li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;">
                <span id="login_user" style="font-weight: bold"> {{$user}}</span><span class="fa fa-caret-down"></span>
            </a>
<ul class="dropdown-menu dropdown-user">
    <li data-toggle="modal" data-target="#userModal"><a style="cursor: pointer"><i class="fa fa-gear fa-fw"></i>修改密码</a>
    </li>
    <li class="divider"></li>
    <li onclick="quit_confirm();"><a style="cursor: pointer" ><i class="fa fa-sign-out fa-fw"></i>注销登录</a>
    </li>
</ul>
<!-- /.dropdown-user -->
</li>
<!-- /.dropdown -->
</ul>
</nav>
<!--/. NAV TOP  -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width: 400px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="closeModal-1" class="close"
                        data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h5 class="modal-title">
                    修改用户信息
                </h5>
            </div>
            <div class="modal-body">
                <form id="user-data" role="form" action="" method="post">
                    <div class="form-group ">
                        <label for="user-id">用户名<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="user-id" value="{{$user}}" readonly/>
                    </div>
                    <div class="form-group ">
                        <label for="user-email">邮箱<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="user-email" value="{{$email}}" readonly/>
                    </div>
                    <div class="form-group ">
                        <input type="button" id="send-email" value="发送验证码"/>
                    </div>
                    <div class="form-group ">
                        <label for="email-validate">验证码</label>
                        <input type="text" class="form-control" id="email-validate" name="email-validate"
                               maxlength="4" onblur="value=value.replace(/[^\d]/g,'')" placeholder="请输入邮箱验证码"/>
                    </div>
                    <div class="form-group ">
                        <label for="user-pd">原密码</label>
                        <input type="password" class="form-control" id="user-pd" name="user-pd"
                                maxlength="16" onblur="value=value.replace(/\s+/g,'')" placeholder="请输入密码"/>
                    </div>
                    <div class="form-group ">
                        <label for="newUser-pd">新密码</label>
                        <input type="password" class="form-control" id="newUser-pd" name="newUser-pd"
                               maxlength="16" onblur="value=value.replace(/\s+/g,'')" placeholder="请输入密码"/>
                    </div>
                    <div class="form-group ">
                        <label for="conform-pd">新密码</label>
                        <input type="password" class="form-control" id="conform-pd" name="conform-pd"
                               maxlength="16" onblur="value=value.replace(/\s+/g,'')" placeholder="请输入密码"/>
                    </div>
                    <div class="form-group ">
                        <div id="tip-msg"></div>
                    </div>
                </form><!--/.form-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal" id="closeModal-2">关闭
                </button>
                <button type="button" class="btn btn-primary" id="user-submit">
                    提交
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modalDialog -->
</div><!--/.modalEnd-->