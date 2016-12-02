<!DOCTYPE html>
<html>

    <!-- Mirrored from www.zi-han.net/theme/hplus/index_v2.html by HTTrack Website Copier/3.x [XR&CO'2010], Sun, 06 Sep 2015 05:15:10 GMT -->
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="renderer" content="webkit">

        <title>学生列表</title>
        <meta name="keywords" content="H+后台主题,后台bootstrap框架,会员中心主题,后台HTML,响应式后台">
        <meta name="description" content="H+是一个完全响应式，基于Bootstrap3最新版本开发的扁平化主题，她采用了主流的左右两栏式布局，使用了Html5+CSS3等现代技术">
        <link rel="stylesheet" href="{{ASSET_URL}}admin/css/jquery-ui-1.10.3.full.min.css" />
        <link href="{{ASSET_URL}}admin/css/bootstrap.min.css" rel="stylesheet" />
        <link href="{{ASSET_URL}}hplus/css/font-awesome.mine0a5.css?v=4.3.0" rel="stylesheet">
        <link href="{{ASSET_URL}}hplus/css/animate.min.css" rel="stylesheet">

        <link href="{{ASSET_URL}}hplus/css/plugins/iCheck/custom.css" rel="stylesheet">
        <link href="{{ASSET_URL}}hplus/css/style.min2513.css?v=3.0.0" rel="stylesheet">

        <!--<link rel="stylesheet" href="{{ASSET_URL}}admin/css/ace-fonts.css" />-->
        <!--<link rel="stylesheet" href="{{ASSET_URL}}admin/css/ace.min.css" />-->
        <!--<link rel="stylesheet" href="{{ASSET_URL}}admin/css/ace-responsive.min.css" />
        <link rel="stylesheet" href="{{ASSET_URL}}admin/css/ace-skins.min.css" />-->
        <link href="{{ASSET_URL}}admin/css/bootstrap-responsive.min.css" rel="stylesheet" /><!-- 按钮的排版样式 -->
       <!-- <link rel="stylesheet" href="{{ASSET_URL}}admin/css/font-awesome.min.css" /> 原按钮的样式-->


    </head>

    <body class="gray-bg">

        <div class="page-content">

            <div class="main-container container-fluid">
                <a class="menu-toggler" id="menu-toggler" href="#">
                    <span class="menu-text"></span>
                </a>
                <div class="row-fluid">
                    <div class="span12">

                        <h3 class="header blue lighter smaller span12" style="margin-top:10px;margin-bottom:7px;">
                            <div class="span12">
                                <div class="span2">
                                    <a href="javascript:;" onclick="add();" class="btn btn-outline btn-default"><i class="fa fa-plus text-navy"></i>添加</a>

                                </div>


                                <div class="form-group" >

                                    <label class="col-sm-6 control-label" >用户名：
									
										<input name="search_name" value="" type="text" id="search_name" placeholder="请输入用户名"/>
										<button type="button" class="btn btn-primary btn-small" id="search_submit" onclick="search();"><i class="fa fa-search"></i>搜索</button>
									
									</label>
									
                                </div>

							</div>                                         <!--<button class="btn btn-small btn-primary " id="addtv" onclick="history.go(-1);" ><i class="icon-reply bigger-110" ></i>返回</button>-->
                        </h3>
                        <br>

                        <div role="grid" class="dataTables_wrapper" id="sample-table-2_wrapper">
                            <div class="span12">
                                <table id="sample-table-2" class="table table-striped table-bordered table-hover  dataTable">
                                    <thead>
                                        <tr>
                                            <th class="center">
                                                <label>
                                                    <input type="checkbox" class="ace" />
                                                    <span class="lbl"></span>
                                                </label>
                                            </th>
                                            <th name="id" class="hidden-phone sorting">

                                                <span name="id" >内容ID</span>
                                            </th>
                                            <th >姓名</th>
                                            <th name="phone">性别</th>
                                            <th >年龄</th>
                                            <th  class="hidden-480">
                                                <i class="icon-time bigger-110 hidden-phone"></i>
                                                操作
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>								
                                <div class="row-fluid">
                                    <div class="span4">

                              <button class="btn btn-small btn-primary"><i class="fa fa-trash-o"></i>删除</button>
                               <!--   <button class="btn btn-small btn-primary"><i class="icon-undo bigger-110"></i>回复</button>
                                <button class="btn btn-small btn-danger"><i class="icon-trash bigger-110"></i>删除</button>-->


                                    </div>
                                    <div class="span4">
                                        <div class="dataTables_info" id="sample-table-2_info">
                                            共有<span id="pagetotal"></span>条记录&nbsp;&nbsp;&nbsp;每页
                                            <input type="text" value="" id="pagesize" size="3" name="pagesize" style="width:42px;"> 条</div>
                                    </div>
                                    <div class="span4">
                                        <div class="dataTables_paginate paging_bootstrap pagination" style="margin: 0px 0;">
                                            <ul  id="pagination">
                                                <li class="prev disabled"><a href="#"><i class="icon-double-angle-left"></i></a></li>
                                                <li class="active"><a href="#">1</a></li>
                                                <li><a href="#">2</a></li>
                                                <li><a href="#">3</a></li>
                                                <li class="next"><a href="#"><i class="icon-double-angle-right"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div><!--/.main-container-->
        </div>

        <!-- 操作后提示框 -->
        <div id="wt-alert" class="hide" style="margin-bottom:-1.5em"></div>
        <!-- 全局js -->
        <script src="{{ASSET_URL}}hplus/js/jquery-2.1.1.min.js"></script>
        <script src="{{ASSET_URL}}hplus/js/bootstrap.mind797.js?v=3.4.0"></script>
        <script src="{{ASSET_URL}}hplus/js/content.mine209.js?v=1.0.0"></script>

        <!-- layer javascript -->
        <script src="{{ASSET_URL}}hplus/js/plugins/layer/layer.min.js"></script>


        <script src="{{ASSET_URL}}admin/js/jquery.ui.touch-punch.min.js"></script>

        <script src="{{ASSET_URL}}admin/js/table/weitac.js"></script>		
        <script type="text/javascript" src="{{ASSET_URL}}admin/js/table/weitac.table.js"></script>
        <script type="text/javascript" src="{{ASSET_URL}}admin/js/table/jquery.tablesorter.js"></script>
        <script type="text/javascript" src="{{ASSET_URL}}admin/js/table/jquery.pagination.js"></script>   



        <script type="text/javascript">
                                                var manage_operation = '<td>\
<div class="hidden-phone visible-desktop action-buttons">\
<a class="btn btn-primary btn-rounded"  href="javascript:void(0);" title="查看" onclick="tvedits({id});">\
<i class="fa fa-search "></i>\
</a>\
<a class="btn btn-white btn-bitbucket"  href="javascript:void(0);" title="弹窗修改" onclick="tvedit({id});">\
<i class="fa fa-pencil"></i>\
</a>\
<a  href="javascript:void(0);"  onclick="datadel({id});">\
<i class="fa fa-trash-o fa-2x" ></i>\
</a>\
</div>\
<div class="hidden-desktop visible-phone">\
<div class="inline position-relative">\
<button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown">\
<i class="icon-caret-down icon-only bigger-120"></i>\
</button>\
<ul class="dropdown-menu dropdown-icon-only dropdown-yellow pull-right dropdown-caret dropdown-close">\
<li>\
<a href="#" class="tooltip-info" data-rel="tooltip" title="View">\
<span class="blue">\
<i class="icon-zoom-in bigger-120"></i>\
</span>\
</a>\
</li>\
<li><a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">\
<span class="green">\
<i class="icon-edit bigger-120"></i>\
</span>\
</a>\
</li>\
<li>\
<a href="#" class="tooltip-error" data-rel="tooltip" title="Delete" onclick="datadel({id});">\
<span class="red">\
<i class="icon-trash bigger-120"></i>\
</span>\
</a>\
</li>\
<li><a href="#" class="tooltip-success" data-rel="tooltip" title="Edit" onclick="qrcode({id});">\
<span class="green">\
<i class="icon-qrcode bigger-120"></i>\
</span>\
</a>\
</li>\
</ul>\
</div>\
</div>\
</td>';
                                                var row_template = '<tr>';
                                                row_template += '<td class="center"><label><input type="checkbox" class="ace" /><span class="lbl"></span></label></td>';
                                                row_template += '<td>{id}</td>';
                                                row_template += '<td>{name}</td>';
                                                row_template += '<td>{sex}</td>';
                                                row_template += '<td>{age}</td>';
                                                //row_template +='<td>{isweixin}</td>';
                                                row_template += manage_operation;
                                                row_template += '</tr>';
                                                var tableApp = new ct.table('#sample-table-2', {
                                                rowIdPrefix: 'row_',
                                                        pageSize: 15,
                                                        rowCallback: 'init_row_event',
                                                        jsonLoaded: json_loaded,
                                                        dblclickHandler: '',
                                                        template: row_template,
                                                        baseUrl: '{{URL::route('admin.core.system.text.ajaxindex')}}?orderby=id|desc'
                                                });
                                                function json_loaded(a) {

                                                $('#pagetotal').html(a.total);
                                                        for (d = 0; a.data[d]; d++) {
                                                if (a.data[d]) {
                                                a.data[d].key = d + 1;
                                                }
                                                }
                                                }




                                        function init_row_event(id, tr)
                                        {


                                        }
                                        $(function () {

                                        tableApp.load();
                                                $('#pagesize').val(tableApp.getPageSize());
                                                $('#pagesize').blur(function () {
                                        var p = $(this).val();
                                                tableApp.setPageSize(p);
                                                tableApp.load();
                                        });
                                        });</script>


        <script type="text/javascript">
                    //添加页面,弹框行
                            function add() {
                            layer.open({
                            type: 2,
                                    title: '学生信息添加',
                                    maxmin: true,
                                    shadeClose: true, //点击遮罩关闭层
                                    area : ['800px', '520px'],//弹框的大小
                                    content: ['{{URL::route('admin.core.system.text.add')}}', 'no'],//
                            });
                            }

                    //添加
                    function insert(){
						//获取弹框页面的数据
						var obj = layer.getChildFrame('#wt-forms');
						alert(obj.serialize());
                            var actionUrl = "{{URL::route('admin.core.system.student.insert')}}";
                            $.ajax({
                            type:'get',
                                    url:'{{URL::route('admin.core.system.text.insert')}}',
                                    data:obj.serialize(),
                                    async: false,//需要将ajax改为同步执行
                                    //cache:false,
                                    success:function(data){
                                    // 验证不通过
                                    layer.confirm('添加成功', {icon: 3}, function(index){
                                    layer.close(index); //关闭
                                    });
                                            //关闭弹出页面
                                            layer.closeAll('iframe');
                                            tableApp.load();//刷新页面
                                    },
                                    error:function(data){
                                    layer.confirm('添加失败', {icon: 3}, function(index){
                                    layer.close(index); //关闭
                                    });
                                            layer.closeAll('iframe');
                                            tableApp.load();
                                    }
                            });
                    }

                    //修改，全页面
                    function tvedit(id){
                    layer.open({
                    type: 2,
                            title: '学生信息修改',
                            //maxmin: true,
                            shadeClose: true, //点击遮罩关闭层
                            area : ['100%', '100%'],//将大小改为100%
                            content: ["{{URL::route('admin.core.system.text.edit')}}?id=" + id, 'no'],
                            style: 'width:100%; height:' + document.documentElement.clientHeight + 'px; background-color:#F2F2F2; border:none;'//样式
                    });
                    }

					//修改数据
                    function update(){
						//获取修改页面的数据
						var obj = layer.getChildFrame('#wt-forms');
                            var actionUrl = "{{URL::route('admin.core.system.text.update')}}";
                            $.ajax({
                            type:'get',
                                    url:actionUrl,
                                    data:obj.serialize(),
                                    async: false,
                                    //cache:false,
                                    success:function(data){
                                    // 验证不通过，提示弹框
                                    layer.confirm('修改成功', {icon: 3}, function(index){
										layer.close(index); //关闭
                                    });
                                            //关闭弹出页面
                                            layer.closeAll('iframe');
                                            tableApp.load();//刷新页面
                                    },
                                    error:function(data){
                                    layer.confirm('修改失败', {icon: 3}, function(index){
										layer.close(index); //关闭
                                    });
                                            //关闭弹出页面
                                            layer.closeAll('iframe');
                                            tableApp.load();
                                    }
                            });
                    }


                    //判断删除
                    function datadel(id){
                    layer.confirm('确定操作？', {icon: 3}, function(index){
						tvdel(id);
                            layer.close(index); //关闭
                    });
                    }
// 删除
                    function tvdel(id)
                    {
                    var obj = 'listid=' + id;
                            var actionUrl = "{{URL::route('admin.core.system.text.del')}}";
                            $.ajax({
                            type: 'get',
                                    url: actionUrl,
                                    data: obj,
                                    async: false,
                                    //cache:false,
                                    success: function(data) {
                                    // 验证不通过
                                    if (data.status != true)
                                    {
                                    layer.confirm('删除失败！', {icon: 3}, function(index){
                                    layer.close(index); //关闭
                                    });
                                    }
                                    // 验证通过
                                    else
                                    {
                                    layer.confirm('删除成功！', {icon: 3}, function(index){
                                    layer.close(index); //关闭
                                    });
                                            tableApp.load();
                                    }
                                    },
                                    error: function(data) {
                                    layer.confirm('网络通信错误！', {icon: 3}, function(index){
                                    layer.close(index); //关闭
                                    });
                                    }
                            });
                    }

					
	//关闭窗口，在弹出的页面点击取消后去关闭页面
	function Closes(){
		layer.closeAll('iframe');
	}
        </script>
    </body>


    <!-- Mirrored from www.zi-han.net/theme/hplus/index_v2.html by HTTrack Website Copier/3.x [XR&CO'2010], Sun, 06 Sep 2015 05:15:29 GMT -->
</html>