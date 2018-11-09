<!DOCTYPE html>
<html lang="zh">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>leegwin贴吧</title>
    <!-- Bootstrap Styles-->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css')}}" rel="stylesheet"/>
    <!-- FontAwesome Styles-->
    <link href="{{ URL::asset('assets/css/font-awesome.css')}}" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="{{ URL::asset('assets/css/custom-styles.css')}}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/css/mainpage.css')}}" rel="stylesheet" />
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/title.ico')}}" >

</head>
<body>
@include('common.nav')
<div id="wrapper">
    @include('common.side-menu')
    <div class="frame-body">
        <div id="page-wrapper">
		 <div id="page-inner">
			<div class="row">
                 <div class="col-md-12">
                       <h5 class="page-header">
                           <div class="his_title">
                               <ol class="breadcrumb">
                                   <li class="li-color">个人中心</li>
                                   <li class="active">发帖</li>
                               </ol>
                           </div>
                        </h5>
                    </div>
             </div>
             <!--/.ROW-->
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">发帖编辑</div>
                        <div class="panel-body">
                            <div class="table-responsive" style="text-align: center">
                                <label for="topic" class="font-style margin-lef">帖文标题</label>
                                <input id="topic" class="input-numid-xx" name="topic">
                            </div>
                            <div class="table-responsive">
                                <script type="text/plain" id="myEditor"></script>
                            </div>
                        </div>
                    </div>
                   <!--End Advanced Tables -->
                 </div>
               <!-- /. col-md-12  -->
            </div>
          <!-- /. ROW  -->
             <div class="row">
                 <div class="col-md-12" style="text-align: center;color: red">
                     <div id="msg"></div>
                 </div>
                 <div class="col-md-12" style="text-align: right">
                     <div class="border-style">
                         <label for="section" class="font-style margin-lef">所在板块</label>
                         <select id="section" class="input-numid-x" name="section"></select>
                     </div>
                     <div class="border-style">
                         <button class="btn-style" id="btn-submit">发布</button>
                     </div>
                 </div>
             </div>
             <!--/.ROW-->
       </div>
      <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
   </div>
   <!-- /. PAGE FRAME-BODY  -->
  </div>
  <!-- /. WRAPPER  -->
</body>
<!-- JS Scripts-->
<!-- jQuery Js -->
<script type="text/javascript" src="{{ URL::asset('assets/js/jquery-1.11.3.min.js')}}"></script>
<!-- Bootstrap Js -->
<script type="text/javascript" src="{{ URL::asset('assets/js/bootstrap.min.js')}}"></script>
<!-- Metis Menu Js -->
<script type="text/javascript" src="{{ URL::asset('assets/js/jquery.metisMenu.js')}}"></script>
<!-- Custom Js -->
<script type="text/javascript" src="{{ URL::asset('assets/js/metisMenu-init.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/user.tooltips.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/pagination.min.js')}}"></script>
<!--my uEditor work area-->
<script type="text/javascript" charset="utf-8" src="{{ URL::asset('ueditor/ueditor.config.js')}}"></script>
<script type="text/javascript" charset="utf-8" src="{{ URL::asset('ueditor/ueditor.all.min.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('ueditor/lang/zh-cn/zh-cn.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/js/zone.topic.js')}}"></script>

</html>