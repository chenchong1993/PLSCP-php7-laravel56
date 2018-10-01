<!DOCTYPE HTML>
<html>
<head>
<!--_meta 作为公共模版分离出去-->
@section('meta')
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    {{--<meta http-equiv="X-UA-Compatible" content="IE=edge">--}}
    {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="Bookmark" href="favicon.ico" >
    <link rel="Shortcut Icon" href="favicon.ico" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="{{ asset('hui/lib/html5.js') }}"></script>
    <script type="text/javascript" src="{{ asset('hui/lib/respond.min.js') }}"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="{{ asset('hui/static/h-ui/css/H-ui.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('hui/static/h-ui.admin/css/H-ui.admin.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('hui/lib/Hui-iconfont/1.0.8/iconfont.css') }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('hui/static/h-ui.admin/skin/default/skin.css') }}" id="skin" />
    <link rel="stylesheet" type="text/css" href="{{ asset('hui/static/h-ui.admin/css/style.css') }}" />
    <!--[if IE 6]>
    <script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script><![endif]-->
    <!--/meta 作为公共模版分离出去-->
    <link rel="stylesheet" href="{{ asset('static/bootstrap/css/bootstrap.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('static/Ips_api_javascript/dijit/themes/tundra/tundra.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('static/Ips_api_javascript/esri/css/esri.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('static/Ips_api_javascript/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('static/Ips_api_javascript/Ips/css/widget.css') }}" />
    {{--<script type="text/javascript" src="{{ asset('static/Ips_api_javascript/init.js') }}"></script>--}}

        <style type="text/css">
            .col-md-9{position:absolute;left:0px;top:0px;z-index:auto;width:1100px;height:500px;}
        </style>

@show
</head>
<body>
<!--_header 作为公共模版分离出去-->
@section('header')
<header class="navbar-wrapper">
    <div class="navbar navbar-fixed-top">
        <div class="container-fluid cl"> <a class="logo navbar-logo f-l mr-10 hidden-xs" href="/aboutHui.shtml">大众位置服务云平台</a> <a class="logo navbar-logo-m f-l mr-10 visible-xs" href="/aboutHui.shtml"></a> <span class="logo navbar-slogan f-l mr-10 hidden-xs">v2.0</span> <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
            <nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
                <ul class="cl">
                    <li>超级管理员</li>
                    <li class="dropDown dropDown_hover"> <a href="#" class="dropDown_A">admin <i class="Hui-iconfont">&#xe6d5;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript:;" onClick="myselfinfo()">个人信息</a></li>
                            <li><a href="#">切换账户</a></li>
                            <li><a href="#">退出</a></li>
                        </ul>
                    </li>
                    {{--消息--}}
                    {{--<li id="Hui-msg"> <a href="#" title="消息"><span class="badge badge-danger">1</span><i class="Hui-iconfont" style="font-size:18px">&#xe68a;</i></a> </li>--}}
                    <li id="Hui-skin" class="dropDown right dropDown_hover"> <a href="javascript:;" class="dropDown_A" title="换肤"><i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            <li><a href="javascript:;" data-val="default" title="默认（黑色）">默认（黑色）</a></li>
                            <li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
                            <li><a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
                            <li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
                            <li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
                            <li><a href="javascript:;" data-val="orange" title="橙色">橙色</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
@show

<!--_menu 作为公共模版分离出去-->
@section('menu')
<aside class="Hui-aside">

    <div class="menu_dropdown bk_2">
        <dl id="menu-member">
            <dt><i class="Hui-iconfont">&#xe60d;</i> 用户管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a href="{{ url('PLSCP/USER/list') }}" title="用户列表">用户列表</a></li>
                    <li><a href="{{ url('PLSCP/USER/add') }}" title="增加用户">增加用户</a></li>
                    <li><a href="{{ url('PLSCP/USER/add') }}" title="增加用户">在线用户</a></li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-map">
            <dt><i class="Hui-iconfont">&#xe6c9;</i> 基础地图<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a href="{{ url('PLSCP/MAP/normalmap')}}" title="基础地图">基础地图</a></li>
                    <li><a href="{{ url('PLSCP/MAP/routemap')}}" title="路网图">路网图</a></li>
                    <li><a href="{{ url('PLSCP/MAP/poimap')}}" title="路网图">路网图</a></li>
                    <li><a href="{{ url('')}}" title="室内导航">室内导航</a></li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-heatmap">
            <dt><i class="Hui-iconfont">&#xe6c1;</i> 热力图<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a href="" title="信号强度热力图">信号强度热力图</a></li>
                    <li><a href="" title="定位精度热力图">定位精度热力图</a></li>
                    <li><a href="" title="精度因子热力图">精度因子热力图</a></li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-search">
            <dt><i class="Hui-iconfont">&#xe665;</i> 普通查询<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a href="" title="名称查询">名称查询</a></li>
                    <li><a href="" title="扩展查询">扩展查询</a></li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-msg">
            <dt><i class="Hui-iconfont">&#xe68a;</i> 消息管理<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a href="" title="普通用户群发">普通用户群发</a></li>
                    <li><a href="" title="点对点发送">点对点发送</a></li>
                    <li><a href="" title="管理员群发">管理员群发</a></li>
                </ul>
            </dd>
        </dl>
        <dl id="menu-search">
            <dt><i class="Hui-iconfont">&#xe61a;</i> 位置大数据分析<i class="Hui-iconfont menu_dropdown-arrow">&#xe6d5;</i></dt>
            <dd>
                <ul>
                    <li><a href="" title="用户兴趣分析">用户兴趣分析</a></li>
                    <li><a href="" title="区域用户群分析">区域用户群分析</a></li>
                </ul>
            </dd>
        </dl>
    </div>
</aside>
<div class="dislpayArrow hidden-xs"><a class="pngfix" href="javascript:void(0);" onClick="displaynavbar(this)"></a></div>
@show

<section class="Hui-article-box">
    <nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/" class="maincolor">首页</a> <span class="c-999 en">&gt;</span><span class="c-666">空白页</span></nav>
    <div class="Hui-article">
        <article class="col-md-9">
            @yield('content')
        </article>
    </div>
</section>

<!--_footer 作为公共模版分离出去-->
@section('footer')
<script type="text/javascript" src="{{ asset('hui/lib/jquery/1.9.1/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('hui/lib/layer/2.4/layer.js') }}"></script>

<script type="text/javascript" src="{{ asset('hui/lib/jquery.validation/1.14.0/jquery.validate.js') }}"></script>
<script type="text/javascript" src="{{ asset('hui/lib/jquery.validation/1.14.0/validate-methods.js') }}"></script>
<script type="text/javascript" src="{{ asset('hui/lib/jquery.validation/1.14.0/messages_zh.js') }}"></script>
<script type="text/javascript" src="{{ asset('hui/static/h-ui/js/H-ui.js') }}"></script>
<script type="text/javascript" src="{{ asset('hui/static/h-ui.admin/js/H-ui.admin.page.js') }}"></script>


<!-- Bootstrap JavaScript 文件 -->
{{--<script src="{{ asset('static/bootstrap/js/bootstrap.min.js') }}"></script>--}}

@show

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript">

</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>