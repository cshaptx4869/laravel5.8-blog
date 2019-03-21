<!doctype html>
<html lang="en">
    {{-- 加载head--}}
    @include('backend.layouts.head')
<body class="no-skin">
{{-- 头部栏--}}
<div id="navbar" class="navbar navbar-default ace-save-state">
    <div class="navbar-container ace-save-state" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <div class="navbar-header pull-left">
            <a href="{{ url('welcome') }}" class="navbar-brand">
                <small>
                    <i class="fa fa-leaf"></i>
                    在下坂本有何贵干
                </small>
            </a>
        </div>

        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="light-blue dropdown-modal">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <img class="nav-user-photo" src="{{asset('assets/images/avatars/user.jpg')}}" alt="Jason's Photo"/>
                        <span class="user-info">
                            <small>欢迎,</small>{{session('userinfo')}}
                        </span>
                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>
                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="{{ url('logout') }}">
                                <i class="ace-icon fa fa-power-off"></i>
                                退出
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

{{-- 内容栏 --}}
<div class="main-container ace-save-state" id="main-container">
    {{-- 菜单栏 --}}
    <div id="sidebar" class="sidebar responsive ace-save-state">
        <ul class="nav nav-list">
            <li class="active">
                <a href="{{url('article/index')}}">
                    <i class="menu-icon fa fa-tachometer"></i>
                    <span class="menu-text"> 文章管理</span>
                </a>
                <b class="arrow"></b>
            </li>
        </ul>

        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
            <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state"
               data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>
    </div>

    {{-- 主体内容 --}}
    <div class="main-content">
        <div class="main-content-inner">
            {{-- 头部条 --}}
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <i class="ace-icon fa fa-home home-icon"></i>
                        <a href="{{ url('welcome') }}">首页</a>
                    </li>
                    <li class="active">@yield('breadcrumb')</li>
                </ul>
            </div>
            {{-- 内容展示 --}}
            <div class="page-content">
                <div class="row">
                    <div class="col-xs-12">
                        @yield('content','内容位')
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 尾部内容 --}}
    <div class="footer">
        <div class="footer-inner">
            <div class="footer-content">
                <span class="bigger-120">
                    <span class="blue bolder">Ace</span> 在下坂本有何贵干 &copy; 2019-2029
                </span>&nbsp; &nbsp;
                <span class="action-buttons">
                    <a href="#">
                        <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
                    </a>
                    <a href="#">
                        <i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
                    </a>
                    <a href="#">
                        <i class="ace-icon fa fa-rss-square orange bigger-150"></i>
                    </a>
                </span>
            </div>
        </div>
    </div>

    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
        <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
    </a>
</div>

{{-- 加载ace相关的js文件--}}
@include('backend.layouts.script')

{{-- 自定义js --}}
@yield('js')

</body>
</html>