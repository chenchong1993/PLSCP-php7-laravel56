<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>大众位置服务云平台</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('static/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ asset('static/vendor/metisMenu/metisMenu.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('static/dist/css/sb-admin-2.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ asset('static/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
    {{--HUI的图标库--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('static/Hui-iconfont/1.0.8/iconfont.css') }}" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="{{ asset('Ips_api_javascript/echarts.js') }}"></script>
    <script src="{{ asset('Ips_api_javascript/echartsExtent.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('static/Ips_api_javascript/dijit/themes/tundra/tundra.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('static/Ips_api_javascript/esri/css/esri.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('static/Ips_api_javascript/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('static/Ips_api_javascript/Ips/css/widget.css') }}" />
    <script type="text/javascript" src="{{ asset('static/Ips_api_javascript/init.js') }}"></script>


    <style type="text/css">
        .map-col{position:absolute;left:250px;top:130px;z-index:auto;width:1100px;height:480px;}
    </style>
</head>

<body>

<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.html">大众位置服务云平台</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#"><i class="fa fa-user fa-fw"></i> 修改资料</a>
                    </li>
                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> 设置</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="login.html"><i class="fa fa-sign-out fa-fw"></i> 注销</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->



        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="{{ url('index') }}"><i class="Hui-iconfont">&#xe625;</i>  首页</a>
                    </li>
                    <li>
                        <a href="#"> <i class="Hui-iconfont">&#xe60d;</i> 用户管理<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{ url('userList') }}">用户列表</a>
                            </li>
                            <li>
                                <a href="{{ url('userOnlineList') }}">在线用户</a>
                            </li>
                            <li>
                                <a href="{{ url('userAdd') }}">添加用户</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"> <i class="Hui-iconfont">&#xe6c9;</i> 基础地图<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{ url('normalMap')}}">基础地图</a>
                            </li>
                            <li>
                                <a href="{{ url('routeMap')}}">路网图</a>
                            </li>
                            <li>
                                <a href="{{ url('poiMap')}}">兴趣点图</a>
                            </li>
                            <li>
                                <a href="{{ url('')}}">室内导航</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"> <i class="Hui-iconfont">&#xe6c1;</i>热力图<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{ url('wifiSignalHeatMap')}}">信号强度热力图</a>
                            </li>
                            <li>
                                <a href="{{ url('heatMap')}}">定位精度热力图</a>
                            </li>
                            <li>
                                <a href="{{ url('hdopHeatMap')}}">精度因子热力图</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"> <i class="Hui-iconfont">&#xe665;</i> 普通查询<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{ url('nameSearch')}}">名称查询</a>
                            </li>
                            <li>
                                <a href="{{ url('extentSearch')}}">扩展查询</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"> <i class="Hui-iconfont">&#xe68a;</i> 消息管理<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{ url('pushToMore')}}">普通用户群发</a>
                            </li>
                            <li>
                                <a href="{{ url('pushToOne')}}">点对点发送</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"> <i class="Hui-iconfont">&#xe61a;</i> 位置大数据分析<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="{{ url('')}}">用户兴趣分析</a>
                            </li>
                            <li>
                                <a href="{{ url('')}}">区域用户群分析</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <!-- Page Content -->
    <div id="page-wrapper">
        @yield('content')
                    <!--中间内容区-->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="{{ asset('static/vendor/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('static/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{ asset('static/vendor/metisMenu/metisMenu.min.js') }}"></script>
<!-- Custom Theme JavaScript -->j
<script src="{{ asset('static/dist/js/sb-admin-2.js') }}"></script>

</body>

</html>
































