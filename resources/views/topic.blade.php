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
                                    <li class="active">主贴</li>
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
                            <span class="visit-count focus-color" id="create-time">创建时间</span>
                            <span class="topic-count unfocus-color" id="like-count">点赞量</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/.ROW-->
                <div class="row">
                    <div class="col-md-12" >
                        <div class="col-md-1"></div>
                     <div class="col-md-8" id="num-0">

                     </div>
                    </div>
                    <!--       col-md-12         -->
                    <div class="col-md-12" >
                        <div class="col-md-1"></div>
                        <div class="col-md-8" id="num-1">

                        </div>
                    </div>
                    <!--       col-md-12         -->
                    <div class="col-md-12" >
                        <div class="col-md-1"></div>
                        <div class="col-md-8" id="num-2">

                        </div>
                    </div>
                    <!--       col-md-12         -->
                    <div class="col-md-12" >
                        <div class="col-md-1"></div>
                        <div class="col-md-8" id="num-3">

                        </div>
                    </div>
                    <!--       col-md-12         -->
                    <div class="col-md-12" >
                        <div class="col-md-1"></div>
                        <div class="col-md-8" id="num-4">

                        </div>
                    </div>
                    <!--       col-md-12         -->
                    <div class="col-md-12" >
                        <div class="col-md-1"></div>
                        <div class="col-md-8" id="num-5">

                        </div>
                    </div>
                    <!--       col-md-12         -->
                    <div class="col-md-12" >
                        <div class="col-md-1"></div>
                        <div class="col-md-8" id="num-6">

                        </div>
                    </div>
                    <!--       col-md-12         -->
                    <div class="col-md-12" >
                        <div class="col-md-1"></div>
                        <div class="col-md-8" id="num-7">

                        </div>
                    </div>
                    <!--       col-md-12         -->
                    <div class="col-md-12" >
                        <div class="col-md-1"></div>
                        <div class="col-md-8" id="num-8">

                        </div>
                    </div>
                    <!--       col-md-12         -->
                    <div class="col-md-12" >
                        <div class="col-md-1"></div>
                        <div class="col-md-8" id="num-9">

                        </div>
                    </div>
                    <!--       col-md-12         -->
                    <div class="col-md-12" >
                        <div class="col-md-1"></div>
                        <div class="col-md-8" id="num-10">

                        </div>
                    </div>
                    <!--       col-md-12         -->
                    <div class="col-md-12" >
                        <div class="col-md-1"></div>
                        <div class="col-md-8" id="num-11">

                        </div>
                    </div>
                    <!--       col-md-12         -->
                    <div class="col-md-12" >
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
<script type="text/javascript" src="{{ URL::asset('assets/js/topic.js')}}"></script>
</html>