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
    <link href="{{ URL::asset('assets/css/pagination.css')}}" rel="stylesheet" />
    <script type="text/javascript" src="{{ URL::asset('assets/js/redirect.js')}}"></script>

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
                                    <li class="active">主页</li>
                                </ol>
                            </div>
                        </h5>
                    </div>
                </div>
                <!--/.ROW-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <div class="margin-5px">
                            <span class="visit-count focus-color" id="visit-count">访问量</span>
                            <span class="topic-count unfocus-color" id="topic-count">主贴数</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/.ROW-->
                <div class="row">
                    <div class="col-md-12" >
                     <div class="col-md-3" id="num-0-0">

                     </div>
                     <div class="col-md-3" id="num-0-1">

                    </div>
                    <div class="col-md-3" id="num-0-2">
                    </div>
                    <div class="col-md-3" id="num-0-3">
                     </div>
                    </div>
            <!--       col-md-12         -->
                    <div class="col-md-12" >
                        <div class="col-md-3" id="num-1-0">
                        </div>
                        <div class="col-md-3"  id="num-1-1">

                        </div>
                        <div class="col-md-3"  id="num-1-2">

                        </div>
                        <div class="col-md-3"  id="num-1-3">

                        </div>
                     </div>
            <!--       col-md-12         -->
                    <div class="col-md-12" >
                        <div class="col-md-3" id="num-2-0">

                        </div>
                        <div class="col-md-3" id="num-2-1">

                        </div>
                        <div class="col-md-3" id="num-2-2">

                        </div>
                        <div class="col-md-3" id="num-2-3">

                        </div>
                    </div>
        <!--       col-md-12         -->
                    <div class="col-md-12" >
                        <div id="data-container" ></div>
                        <div id="pagination-container" class="float-right margin-top"></div>
                    </div>
        <!--       col-md-12         -->
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
<script type="text/javascript" src="{{ URL::asset('assets/js/main.js')}}"></script>
</html>