<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="renderer" content="webkit">
        <title>Weitac媒体运营管理系统</title>
        <meta name="keywords" content="weitac">
        <meta name="description" content="weitac媒体运营管理系统">
        <!--[if lt IE 8]>
        <script>
            alert('已不支持IE6-8，请使用谷歌、火狐等浏览器\n或360、QQ等国产浏览器的极速模式浏览本页面！');
        </script>
        <![endif]-->

        <link href="{{ASSET_URL}}system/hplus/css/bootstrap.mind797.css?v=3.4.0" rel="stylesheet">
        <link href="{{ASSET_URL}}system/hplus/css/font-awesome.mine0a5.css?v=4.3.0" rel="stylesheet">
        <link href="{{ASSET_URL}}system/hplus/css/animate.min.css" rel="stylesheet">
        <link href="{{ASSET_URL}}system/hplus/css/style.min2513.css?v=3.0.0" rel="stylesheet">
        <style type="text/css">
.roll-right.J_tabExit{height: 30px;}
.content-tabs .roll-nav, .page-tabs-list{height: 30px;}
.content-tabs{height: 32px;line-height:30px;}
#content-main{ height: calc(100% - 89px);}
.skin-1 .nav-header{padding: 14px 25px 6px;}

body, body.full-height-layout #page-wrapper, body.full-height-layout #wrapper, html {
    height: 100%;
    overflow-y: hidden;
    overflow-x: hidden;
}
body.canvas-menu .navbar-static-side, body.fixed-sidebar .navbar-static-side {
    position: fixed;
    width: 220px;
    z-index: 2001;
    height: 100%;
    width: 14%;
}
#page-wrapper {
    padding: 0 15px;
    position: inherit;
    margin: 0 0 0 14%;
}
.navbar {
    border: 0;
    margin-bottom: 0;
    height: 58px;
}
        </style>
    </head>

    <body class="fixed-sidebar full-height-layout gray-bg">
        <div id="wrapper">
            <!--左侧导航开始-->
            <nav class="navbar-default navbar-static-side"  role="navigation">
                <div class="nav-close"><i class="fa fa-times-circle"></i>
                </div>
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu" >
                        <li class="nav-header">
                            <div class="dropdown profile-element">
                                <span><img alt="image"  src="/assets/system/admin/images/logo.png" /></span>
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <span class="clear">
                                        <span class="text-muted text-xs block">@if(!empty($username)) {{$username}} @else Beaut-zihan @endif<b class="caret"></b></span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                    <li><a class="J_menuItem" href="" onclick="show('{{$user_id}}');">个人资料</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li><a href="javascript:void(0)" onclick="editPwd();">修改密码</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li><a href="/admin/logout">安全退出</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="logo-element">Weitac
                            </div>
                        </li>
                        @foreach($menu_data as $key=>$val)
                        <li class="active" id="menu_li_{{$val->menuid}}"  sub_menu="1" style="display:none;">
                            <a href="#">
                                <i class="fa fa-home"></i>
                                <span class="nav-label" > {{$val->name}}</span>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-second-level in" id="sub_menu_{{$val->menuid}}" >

                            </ul>

                        </li>
                        @endforeach


                    </ul>
                </div>
            </nav>
            <!--左侧导航结束-->
            <!--右侧部分开始-->
            <div id="page-wrapper" class="gray-bg dashbard-1" >
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top" role="navigation">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#">
                                <i class="fa fa-bars"></i> 
                            </a>
                                                 
                            <!-- 顶部菜单 -->
                            <ul class="nav navbar-top-links navbar-right" id="top_nav" style="margin-top:-15px;">
                                <!-- 菜单部分 -->
                                @foreach($menu_data as $key=>$val)
                                <li class="dropdown" style="background:none;margin-right:10px;height:50px;" t_nav="1">
                                    <a class="dropdown-toggle count-info" data-toggle="dropdown" style="height:48px;" href="#" tn="{{$val->menuid}}">
                                        {{$val->name}}
                                    </a>
                                    <ul class="dropdown-menu dropdown-alerts menu-top" id="top_sec_{{$val->menuid}}" t_nav_ul="1" style="width:140px">

                                    </ul>
                                </li>
                                @endforeach
                                <!-- 菜单部分 -->
                            </ul>
                            <!-- 顶部菜单 end  -->
                    </nav>
                </div>
                        
                <div class="row content-tabs">
                    <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
                    </button>
                    <nav class="page-tabs J_menuTabs">
                        <div class="page-tabs-content">
                            <a href="javascript:;" class="active J_menuTab" data-id="index_v1.html">首页</a>
                        </div>
                    </nav>
                    <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i>
                    </button>
                    <button class="roll-nav roll-right dropdown J_tabClose"><span class="dropdown-toggle" data-toggle="dropdown">关闭<span class="caret"></span></span>
                        <ul role="menu" class="dropdown-menu dropdown-menu-right">
                            <li class="J_tabShowActive"><a>定位当前选项卡</a>
                            </li>
                            <li class="divider"></li>
                            <li class="J_tabCloseAll"><a>关闭全部选项卡</a>
                            </li>
                            <li class="J_tabCloseOther"><a>关闭其他选项卡</a>
                            </li>
                        </ul>
                    </button>
                    <a href="/admin/logout" class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> 退出</a>
                </div>
                        
                <div class="row J_mainContent" id="content-main">
                    <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="/admin/default" frameborder="0" data-id="index_v1.html" seamless></iframe>
                </div>
<!--                <div class="footer">
                    <div class="pull-right">&copy; 北京赢点科技
                    </div>
                </div>-->
            </div>
            <!--右侧部分结束-->

            <!--mini聊天窗口开始-->
<!--            <div class="small-chat-box fadeInRight animated">

                <div class="heading" draggable="true">
                    <small class="chat-date pull-right">
                        2015.9.1
                    </small> 与 Beau-zihan 聊天中
                </div>

                <div class="content">

                    <div class="left">
                        <div class="author-name">
                            Beau-zihan <small class="chat-date">
                                10:02
                            </small>
                        </div>
                        <div class="chat-message active">
                            你好
                        </div>

                    </div>
                    <div class="right">
                        <div class="author-name">
                            游客
                            <small class="chat-date">
                                11:24
                            </small>
                        </div>
                        <div class="chat-message">
                            你好，请问H+有帮助文档吗？
                        </div>
                    </div>
                    <div class="left">
                        <div class="author-name">
                            Beau-zihan
                            <small class="chat-date">
                                08:45
                            </small>
                        </div>
                        <div class="chat-message active">
                            有，购买的H+源码包中有帮助文档，位于docs文件夹下
                        </div>
                    </div>
                    <div class="right">
                        <div class="author-name">
                            游客
                            <small class="chat-date">
                                11:24
                            </small>
                        </div>
                        <div class="chat-message">
                            那除了帮助文档还提供什么样的服务？
                        </div>
                    </div>
                    <div class="left">
                        <div class="author-name">
                            Beau-zihan
                            <small class="chat-date">
                                08:45
                            </small>
                        </div>
                        <div class="chat-message active">
                            1.所有源码(未压缩、带注释版本)；
                            <br> 2.说明文档；
                            <br> 3.终身免费升级服务；
                            <br> 4.必要的技术支持；
                            <br> 5.付费二次开发服务；
                            <br> 6.授权许可；
                            <br> ……
                            <br>
                        </div>
                    </div>


                </div>
                <div class="form-chat">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control"> <span class="input-group-btn"> <button
                                class="btn btn-primary" type="button">发送
                            </button> </span>
                    </div>
                </div>

            </div>
            <div id="small-chat">
                <span class="badge badge-warning pull-right">5</span>
                <a class="open-small-chat">
                    <i class="fa fa-comments"></i>

                </a>
            </div>-->
            <!--mini聊天窗口结束-->
        </div>

        <!-- 全局js -->
        <script src="{{ASSET_URL}}system/hplus/js/2.1.3/jquery.min.js"></script>
        <script src="{{ASSET_URL}}system/hplus/js/bootstrap.mind797.js?v=3.4.0"></script>
        <script src="{{ASSET_URL}}system/hplus/js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="{{ASSET_URL}}system/hplus/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="{{ASSET_URL}}system/hplus/js/plugins/layer/layer.min.js"></script>

        <!-- 自定义js -->
        <script src="{{ASSET_URL}}system/hplus/js/hplus.min2513.js?v=3.0.0"></script>
        <script type="text/javascript" src="{{ASSET_URL}}system/hplus/js/contabs.min.js"></script>

        <!-- 第三方插件 -->
        <script src="{{ASSET_URL}}system/hplus/js/plugins/pace/pace.min.js"></script>

        <div class="theme-config" style="top:10px;">
            <div class="theme-config-box">
                <div class="spin-icon">
                    <i class="fa fa-cog fa-spin"></i>
                </div>
                <div class="skin-setttings">
                    <div class="title">主题设置</div>
                    <div class="setings-item">
                        <span>
                            收起左侧菜单
                        </span>

                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="collapsemenu">
                                <label class="onoffswitch-label" for="collapsemenu">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
                        <span>
                            固定顶部
                        </span>

                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="fixednavbar" class="onoffswitch-checkbox" id="fixednavbar">
                                <label class="onoffswitch-label" for="fixednavbar">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="setings-item">
                        <span>
                            固定宽度
                        </span>

                        <div class="switch">
                            <div class="onoffswitch">
                                <input type="checkbox" name="boxedlayout" class="onoffswitch-checkbox" id="boxedlayout">
                                <label class="onoffswitch-label" for="boxedlayout">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="title">皮肤选择</div>
                    <div class="setings-item default-skin">
                        <span class="skin-name ">
                            <a href="#" class="s-skin-0">
                                默认皮肤
                            </a>
                        </span>
                    </div>
                    <div class="setings-item blue-skin">
                        <span class="skin-name ">
                            <a href="#" class="s-skin-1">
                                蓝色主题
                            </a>
                        </span>
                    </div>
                    <div class="setings-item yellow-skin">
                        <span class="skin-name ">
                            <a href="#" class="s-skin-3">
                                黄色/紫色主题
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
		<script type="text/javascript">
			//查看
			function show(id){
				layer.open({
					type: 2,
					title: '用户详细',
					//maxmin: true,
					shadeClose: true, //点击遮罩关闭层
					area : ['100%', '100%'],
					content: ['{{URL::route('admin.user.show')}}?user_id='+id],
				});
			}
		</script>

         /*
        修改密码js
        */
        <script type="text/javascript">
        /*
        修改密码操作
        */
        function editPwd(){
            var index=layer.open({
                    type:2,
                    title:["修改密码","font-size:14px;background:#2b9af6;color:#fff"],
                    move:".layui-layer-title",
                    area:["500px;","300px"],
                    shade:[0.5,"#000"],
                    shadeClose:true,
                    shift:0,
                    content:['{{URL::route("admin.user.editPwd")}}'],
                    btn:['确定','取消'],
                    yes:function(index){
                        var obj=layer.getChildFrame("#wt-forms",index);
                        var actionUrl="{{URL::route('admin.weixin.updatePwd')}}";
                        var password=obj.find("#password").val();
                        if(password==""){
                            layer.msg("密码不能为空",{
                                        icon:3,
                                        time:1500,
                                        skin:'layer-ext-moon'
                                    });
                            return;
                        }
                        $.ajax({
                            type:"post",
                            url:actionUrl,
                            data:obj.serialize(),
                            cache:false,
                            success:function(data){
                                if(data.status){
                                    layer.msg(data.msg,{
                                        icon:1,
                                        time:1500,
                                        skin:'layer-ext-moon'
                                    });
                                    layer.close(index);
                                    $("#table").bootstrapTable('refresh','');
                                }
                                else{
                                    layer.msg(data.msg,{
                                        icon:3,
                                        time:1500,
                                        skin:'layer-ext-moon'
                                    });
                                }
                            },
                            errot:function(data){
                                
                            }
                        });
                    }
                });
        }
        </script>


        <script type="text/javascript">
//绑定事件
        function top_nav_bind_event(menuid) {

        var flag = false;
                if (menuid == undefined) {
        var topNavA = $('#top_nav a[data-toggle="dropdown"]');
                var topNavLi = $('#top_nav [t_nav="1"]');
        } else {
        var topNavA = $('#top_nav a[data-toggle="dropdown"][tn="' + menuid + '"]');
                var topNavLi = $('#top_nav [t_nav="1"] a[tn="' + menuid + '"]').parent();
                var leftNavLiHtml = '<li style="display:none;" sub_menu="1" id="sub_menu_' + menuid + '"></li>';
                $('ul.nav.nav-list').append(leftNavLiHtml);
                flag = true;
        }




        topNavLi.hover(function () {

        var mid = $(this).find('a[data-toggle="dropdown"]').attr('tn');
                var html = $('#top_sec_' + mid).attr('t_nav_ul');
                if (html == '1') {
        var url = '{{URL::route('admin.core.system.menu.getchilds')}}?menuid=' + mid;
                $.get(url, function (data) {
                top_nav(data, false);
                }, 'json');
        } else {
        //不再重复请求
        $('#top_sec_' + mid).show();
        }

        }, function () {

        $('.menu-top').hide();
        });
        }


top_nav_bind_event();
        function top_nav(data, left) {

        if (left == undefined) {
        left = true;
        }

        var name = data.name;
                var menuid = data.menuid;
                var url = data.url

                var l_top_html = '';
                var top_sec_html = '';


                for (var mi in data.childs) {

                 l_top_html += '<li id="nav_third_li' + data.childs[mi].menuid + '" class="nav_third_li">'
                l_top_html += '				<a class="J_menuItem" href="' + data.childs[mi].url + '"  sub_menu="2" tn="' + data.childs[mi].menuid + '" onclick="sub_menu_3(this)" >'
                l_top_html += '					<i class="icon-double-angle-right"></i>'
                l_top_html += '<i class="fa fa-inbox"></i>'+data.childs[mi].name;
                if (data.childs[mi].childids){
                    l_top_html += '<span class="fa arrow"></span>';
                }
                l_top_html += '				</a>'
                l_top_html += '				<ul class="nav nav-third-level" id="sub_menu_' + data.childs[mi].menuid + '" aria-expanded="false"></ul>'
                l_top_html += '			</li>'

                top_sec_html += '<li><a  class="J_menuItem" href="' + data.childs[mi].url + '" onclick="top_menu_check(this)" tsn="' + data.childs[mi].menuid + '" psn="' + menuid + '"><div>' + data.childs[mi].name + '</div></a></li>';
        }


        top_sec_html += '<li class="divider"></li>';



                $('#sub_menu_' + menuid).html(l_top_html);
                $('#top_sec_' + menuid).html(top_sec_html);
                $('#top_sec_' + menuid).show();
                $('#top_sec_' + menuid).attr('t_nav_ul', '2');
                $.getScript('{{ASSET_URL}}system/hplus/js/contabs.min.js');
        }

//显示左边的菜单
function top_menu_check(dd) {
var mid = $(dd).attr('tsn');
        var pid = $(dd).attr('psn');
        $('[sub_menu="1"]').hide();
        $('#menu_li_' + pid).show();
}

function sub_menu_3(dd) {
var mid = $(dd).attr('tn');
        var url = '{{URL::route('admin.core.system.menu.getchilds')}}?menuid=' + mid;
        $.get(url, function(data){
        if (data.ischilds){
        top_nav_2(data);
        } else{
        
        }
        }, 'json');
        
}

			function top_nav_2(data) {
				
				var name = data.name;
				var menuid = data.menuid;
				var url = data.url;
				var l_top_html = ''
				
				for (var mi in data.childs) {
				
					l_top_html += '			<li id="sub_menu_'+data.childs[mi].menuid+'" >'
					l_top_html += '				<a class="J_menuItem" href="'+data.childs[mi].url+'"  sub_menu="2"  >'
					l_top_html += data.childs[mi].name;
					
					l_top_html += '				</a>'
					l_top_html += '			</li>'
				
				}
                                

				if ($('#sub_menu_'+menuid).html()==''){
                                    $('.nav_third_li').removeClass('active');
                                     $('.nav-third-level').html("");
                                     
                                    $('#nav_third_li'+menuid).addClass('active');  
                                 $('#sub_menu_'+menuid).html(l_top_html);
                            }else{

                                $('.nav_third_li').removeClass('active');
                                $('.nav-third-level').html("");
                            }
                                
				$.getScript('{{ASSET_URL}}system/hplus/js/contabs.min.js');
				
			}

        </script>



        <script>
            $("#fixednavbar").click(function () {
            if ($("#fixednavbar").is(":checked")) {
            $(".navbar-static-top").removeClass("navbar-static-top").addClass("navbar-fixed-top");
                    $("body").removeClass("boxed-layout");
                    $("body").addClass("fixed-nav");
                    $("#boxedlayout").prop("checked", false);
                    if (localStorageSupport) {
            localStorage.setItem("boxedlayout", "off")
            }
            if (localStorageSupport) {
            localStorage.setItem("fixednavbar", "on")
            }
            } else {
            $(".navbar-fixed-top").removeClass("navbar-fixed-top").addClass("navbar-static-top");
                    $("body").removeClass("fixed-nav");
                    if (localStorageSupport) {
            localStorage.setItem("fixednavbar", "off")
            }
            }
            });
                    $("#collapsemenu").click(function () {
            if ($("#collapsemenu").is(":checked")) {
            $("body").addClass("mini-navbar");
                    SmoothlyMenu();
                    if (localStorageSupport) {
            localStorage.setItem("collapse_menu", "on")
            }
            } else {
            $("body").removeClass("mini-navbar");
                    SmoothlyMenu();
                    if (localStorageSupport) {
            localStorage.setItem("collapse_menu", "off")
            }
            }
            });
                    $("#boxedlayout").click(function () {
            if ($("#boxedlayout").is(":checked")) {
            $("body").addClass("boxed-layout");
                    $("#fixednavbar").prop("checked", false);
                    $(".navbar-fixed-top").removeClass("navbar-fixed-top").addClass("navbar-static-top");
                    $("body").removeClass("fixed-nav");
                    if (localStorageSupport) {
            localStorage.setItem("fixednavbar", "off")
            }
            if (localStorageSupport) {
            localStorage.setItem("boxedlayout", "on")
            }
            } else {
            $("body").removeClass("boxed-layout");
                    if (localStorageSupport) {
            localStorage.setItem("boxedlayout", "off")
            }
            }
            });
                    $(".spin-icon").click(function () {
            $(".theme-config-box").toggleClass("show")
            });
                    $(".s-skin-0").click(function () {
            $("body").removeClass("skin-1");
                    $("body").removeClass("skin-2");
                    $("body").removeClass("skin-3")
            });
                    $(".s-skin-1").click(function () {
            $("body").removeClass("skin-2");
                    $("body").removeClass("skin-3");
                    $("body").addClass("skin-1")
            });
                    $(".s-skin-3").click(function () {
            $("body").removeClass("skin-1");
                    $("body").removeClass("skin-2");
                    $("body").addClass("skin-3")
            });
                    if (localStorageSupport) {
                        skin2();
            var collapse = localStorage.getItem("collapse_menu");
                    var fixednavbar = localStorage.getItem("fixednavbar");
                    var boxedlayout = localStorage.getItem("boxedlayout");
                    if (collapse == "on") {
            $("#collapsemenu").prop("checked", "checked")
            }
            if (fixednavbar == "on") {
            $("#fixednavbar").prop("checked", "checked")
            }
            if (boxedlayout == "on") {
            $("#boxedlayout").prop("checked", "checked")
            }
            }
            ;
            
            function skin2() {
            $("body").removeClass("skin-2");
                    $("body").removeClass("skin-3");
                    $("body").addClass("skin-1")
            }
        </script>

        <style>
            .fixed-nav .slimScrollDiv #side-menu {
                padding-bottom: 60px;
            }
        </style>
    </body>

</html>