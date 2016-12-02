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


    </head>

    <body class="gray-bg">

        <div class="page-content">

            <div class="main-container container-fluid">
                <a class="menu-toggler" id="menu-toggler" href="#">
                    <span class="menu-text"></span>
                </a>
                <div class="row-fluid">
                    <div class="span12">

                        <h3 class="header blue lighter smaller span12" style="margin-top:0px;margin-bottom:7px;">
                            <div class="row-fluid dataTables_wrapper span12">
                                <div class="text-center">

									<a data-toggle="modal" class="btn btn-primary" href="{{URL::route('admin.core.system.student.add')}}">页面登录窗口</a>
                                    <a href="javascript:;" onclick="add();" class="btn btn-outline btn-default">添加</a>
									<a data-toggle="modal" class="btn btn-primary" href="#modal-form">打开登录窗口</a>
                                    
                                </div>


                                <div class="span6" id="m_search_div">

                                    <label class="control-label" for="search_name">用户名：</label>
                                    <input name="search_name" value="" type="text" id="search_name" placeholder="请输入用户名"/>
                                    <button type="button" class="btn btn-primary btn-small" id="search_submit" onclick="search();"><i class="icon-ok bigger-110"></i>搜索</button>
                                </div>
                                <div class="span4" id="m_search_div">
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

<!--                                <button class="btn btn-small btn-primary"><i class="icon-ok bigger-110"></i>审核</button>
                                <button class="btn btn-small btn-primary"><i class="icon-undo bigger-110"></i>回复</button>
                                <button class="btn btn-small btn-danger"><i class="icon-trash bigger-110"></i>删除</button>-->


                                    </div>
                                    <div class="span4">
                                        <div class="dataTables_info" id="sample-table-2_info">
                                            共有<span id="pagetotal"></span>条记录&nbsp;&nbsp;&nbsp;每页
                                            <input type="text" value="" id="pagesize" size="3" name="pagesize" style="width:42px;"> 条</div>
                                    </div>
                                    <div class="span4">
                                        <div class="dataTables_paginate paging_bootstrap pagination">
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
		
		<div id="modal-form" class="modal fade" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6 b-r">
                            <h3 class="m-t-none m-b">学生信息添加</h3>

                            <form role="form" id='wt-form'>
                                <div class="form-group"><label>名字</label> <input type="text" id='name' name='name' placeholder="请输入您的名字" class="form-control"></div>
        <div class="form-group"><label>性别</label> <input type="radio" name ="sex"   value="1" checked="checked"/>男&nbsp;&nbsp;&nbsp;
                        <input type="radio" name ="sex"   value="2"/>女</div>
        <div class="form-group"><label>年龄</label> <input type="text" name='age' placeholder="请输入您的年龄" class="form-control"></div>
                                <div>
                                    <button class="btn btn-primary" type="submit" onclick="insert();">保存内容</button>
									<button class="btn btn-white" type="submit">取消</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
	
        <!-- 操作后提示框 -->
        <div id="wt-alert" class="hide" style="margin-bottom:-1.5em"></div>
        <!-- 全局js -->
        <script src="{{ASSET_URL}}hplus/js/jquery-2.1.1.min.js"></script>
        <script src="{{ASSET_URL}}hplus/js/bootstrap.mind797.js?v=3.4.0"></script>
        <script src="{{ASSET_URL}}hplus/js/content.mine209.js?v=1.0.0"></script>

        <!-- layer javascript -->
        <script src="{{ASSET_URL}}hplus/js/plugins/layer/layer.min.js"></script>

        <script src="js/plugins/jeditable/jquery.jeditable.js"></script>

        <script src="{{ASSET_URL}}admin/js/jquery.ui.touch-punch.min.js"></script>
        <script src="{{ASSET_URL}}admin/js/weitac/weitac.global.js"></script>	
        <script src="{{ASSET_URL}}admin/js/table/weitac.js"></script>		
        <script type="text/javascript" src="{{ASSET_URL}}admin/js/table/weitac.table.js"></script>
        <script type="text/javascript" src="{{ASSET_URL}}admin/js/table/jquery.tablesorter.js"></script>
        <script type="text/javascript" src="{{ASSET_URL}}admin/js/table/jquery.pagination.js"></script>   



        <script type="text/javascript">
            var manage_operation = '<td>\
        <div class="hidden-phone visible-desktop action-buttons">\
        <a class="blue"  href="javascript:void(0);" onclick="datalist({id});">\
        <i class="icon-zoom-in bigger-130"></i>\
        </a>\
        <a class="green"  href="javascript:void(0);" onclick="tvedit({id});">\
        <i class="icon-pencil bigger-130"></i>\
        </a>\
        <a class="red" href="javascript:void(0);" onclick="datadel({id});">\
        <i class="icon-trash bigger-130"></i>\
        </a>\
        <a class="blue" href="javascript:void(0);" onclick="qrcode({id});">&nbsp&nbsp\
        <i class="icon-qrcode bigger-130"></i>\
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
            // row_template += manage_operation;
            row_template += '</tr>';
            var tableApp = new ct.table('#sample-table-2', {
                rowIdPrefix: 'row_',
                pageSize: 15,
                rowCallback: 'init_row_event',
                jsonLoaded: json_loaded,
                dblclickHandler: '',
                template: row_template,
                baseUrl: '{{URL::route('admin.core.system.student.ajaxindex')}}?orderby=id|desc'
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


            });

        </script>


        <script type="text/javascript">
            function add() {
                parent.layer.open({
                    type:2,
                    //skin:'layui-layer-molv',
                    title: '学生信息添加',
                    area: ['500px','300px'],
                    //move: false,
                    btn: ['确定', '取消'], //按钮
                    //shade: false //不显示遮罩
                    content:['{{URL::route('admin.core.system.student.add')}}','no'],
                    yes: function (index,b) {
						var a = $('#layui-layer-iframe11');
					   alert(a.serialize());
                       parent.layer.close(index); //关闭
                    }, cancel: function (index) {
                       // alert("取消");
                    }
                });
            }
			
        </script>
    </body>


    <!-- Mirrored from www.zi-han.net/theme/hplus/index_v2.html by HTTrack Website Copier/3.x [XR&CO'2010], Sun, 06 Sep 2015 05:15:29 GMT -->
</html>