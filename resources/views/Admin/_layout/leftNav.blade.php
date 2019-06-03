<!--左侧导航开始-->
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="nav-close"><i class="fa fa-times-circle"></i>
    </div>
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span><img alt="image" class="img-circle" style="height: 75px;width: 75px;" src="{{ session('admin_info.avatar') }}" /></span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs"><strong class="font-bold">{{ session('admin_info.nickname') }}</strong></span>
                            <span class="text-muted text-xs block">超级管理员<b class="caret"></b></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{ url('Admin/index/logout',[],config('crucis.http_secure')) }}">安全退出</a>
                        </li>
                    </ul>
                </div>
                <div class="logo-element">Crucis
                </div>
            </li>
            <li>
                <a class="J_menuItem" href="{{ url('Admin/Statistics/index',[],config('crucis.http_secure')) }}"
                   data-id="{{ url('Admin/Statistics/index',[],config('crucis.http_secure')) }}">
                    <i class="fa fa-chart-pie"></i>
                    <span class="nav-label">统计</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-toggle-on"></i>
                    <span class="nav-label">设置</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level">
                    <li>
                        <a class="J_menuItem" href="">基础设置</a>
                    </li>
                </ul>
                <ul class="nav nav-second-level">
                    <li>
                        <a class="J_menuItem" href="{{ url('Admin/Sign',[],config('crucis.http_secure')) }}">每日签到</a>
                    </li>
                </ul>
                <ul class="nav nav-second-level">
                    <li>
                        <a class="J_menuItem" href="">支付设置</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-newspaper"></i> <span class="nav-label">房间 </span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a class="J_menuItem" href="{{ url('Admin/Room',[],config('crucis.http_secure')) }}">房间列表</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-newspaper"></i> <span class="nav-label">文章 </span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a class="J_menuItem" href="{{ url('Admin/Article/cateList',[],config('crucis.http_secure')) }}">分类列表</a>
                    </li>
                    <li>
                        <a class="J_menuItem" href="{{ url('Admin/Article/index',[],config('crucis.http_secure')) }}">文章列表</a>
                    </li>
                    <li>
                        <a class="J_menuItem" href="{{ url('Admin/Article/add',[],config('crucis.http_secure')) }}">新增文章</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fab fa-adversal"></i> <span class="nav-label">广告</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a class="J_menuItem" href="{{ url('Admin/Advertisement',[],config('crucis.http_secure')) }}">广告列表</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-envelope"></i> <span class="nav-label">反馈</span><span
                            class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a class="J_menuItem" href="{{ url('Admin/Feedback',[],config('crucis.http_secure')) }}">反馈意见</a>
                    </li>
                </ul>
                <ul class="nav nav-second-level">
                    <li>
                        <a class="J_menuItem" href="{{ url('Admin/Report',[],config('crucis.http_secure')) }}">用户申诉</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-weight-hanging"></i> <span class="nav-label">商品</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a class="J_menuItem" href="{{ url('Admin/Goods/goodsCategoryList',[],config('crucis.http_secure')) }}">分类列表</a>
                    </li>
                    <li>
                        <a class="J_menuItem" href="{{ url('Admin/Attribute/attributeCategoryList',[],config('crucis.http_secure')) }}">属性列表</a>
                    </li>
                    <li>
                        <a class="J_menuItem" href="{{ url('Admin/Goods/goodsList',[],config('crucis.http_secure')) }}">商品列表</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-money-bill"></i> <span class="nav-label">交易</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a class="J_menuItem" href="{{ url('Admin/Order/orderList',[],config('crucis.http_secure')) }}">订单列表</a>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fab fa-expeditedssl"></i> <span class="nav-label">权限</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a class="J_menuItem" href="{{ url('Admin/Auth/admin_list',[],config('crucis.http_secure')) }}">管理员列表</a>
                    </li>
                    <li><a class="J_menuItem" href="{{ url('Admin/Auth/role_list',[],config('crucis.http_secure')) }}">管理组列表</a>
                    </li>
                    <li><a class="J_menuItem" href="{{ url('Admin/Auth/permission_list',[],config('crucis.http_secure')) }}">权限列表</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-user"></i> <span class="nav-label">会员</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a class="J_menuItem" href="{{ url('Admin/User',[],config('crucis.http_secure')) }}">会员列表</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-image"></i> <span class="nav-label">相册</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a class="J_menuItem" href="{{ url('Admin/Album',[],config('crucis.http_secure')) }}">相册列表</a>
                    </li>
                    <li>
                        <a class="J_menuItem" href="{{ url('Admin/Album/create',[],config('crucis.http_secure')) }}">创建相册</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-bug"></i> <span class="nav-label">系统</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a class="J_menuItem" href="{{ url('Admin/SystemLog/index',[],config('crucis.http_secure')) }}">系统日志</a>
                    </li>
                    <li>
                        <a class="J_menuItem" href="{{ url('Admin/System/phpinfo',[],config('crucis.http_secure')) }}">phpinfo</a>
                    </li>
                    <li>
                        <a class="J_menuItem" href="{{ url('Admin/System/tz',[],config('crucis.http_secure')) }}">服务器状态</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<!--左侧导航结束-->