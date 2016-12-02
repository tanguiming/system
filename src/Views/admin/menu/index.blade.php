<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="renderer" content="webkit">
        <title>系统菜单管理</title>
        <link rel="stylesheet" href="{{ASSET_URL}}system/admin/css/ace-fonts.css" />
        <link rel="stylesheet" href="{{ASSET_URL}}system/admin/css/ace-skins.min.css" />
        <link href="{{ASSET_URL}}system/admin/css/bootstrap.min.css" rel="stylesheet" />
        <link href="{{ASSET_URL}}system/hplus/css/font-awesome.mine0a5.css?v=4.3.0" rel="stylesheet">
        <link rel="stylesheet" href="{{ASSET_URL}}system/admin/css/font-awesome.min.css" />

        <style>
            /*删除按钮红色样式*/
            body .del-class .layui-layer-btn .layui-layer-btn0{background:#CD8A37;} 
        </style>

    </head>
    <body class="gray-bg">
        
        <!-- content -->
        <div class="page-content">
            <!--main-container-->
            <div class="main-container container-fluid">
                <a class="menu-toggler" id="menu-toggler" href="#">
                    <span class="menu-text"></span>
                </a>
                <div class="row-fluid">
                        <!-- 工具栏 -->
                        <div class="span12">
                            <h3>
                                  <input type="hidden" name="return_id" value="{{$return_id}}" id="return_id">
                                  <input type="hidden" name="menuid" value="{{$menuid}}" id="menuid">
                                 <button class="btn btn-small btn-success" type="button" onclick="add()">添加菜单</button>

                                 @if($menuid!="")
                                        
                                        <a href="/admin/core/system/menu/index?menuid={{$return_id}}" class="J_menuItem btn btn-small btn-info"   target="_self">返回上级</a>
                                 @endif
                            
                            </h3>
                        </div><!-- 工具栏 end -->

                        <!-- 列表内容 -->
                        <div role="grid" class="dataTables_wrapper" id="sample-table-2_wrapper">
                            <div class="span12">
                                 <table id="sample-table-2" class="table table-striped table-bordered table-hover  dataTable">
                                    <!-- 列表标题 -->
                                    <thead>
                                        <tr>
                                            <th class="center">
                                                <label>
                                                    <input type="checkbox" class="ace" />
                                                    <span class="lbl"></span>
                                                </label>
                                            </th>
                                            <th >排序</th>
                                            <th >名称</th>
                                            <th >链接地址</th>
                                            <th >状态</th>
                                            <th  class="hidden-480">
                                                <i class="icon-time bigger-110 hidden-phone"></i>
                                                操作
                                            </th>
                                        </tr>
                                    </thead>
                                    <!-- 列表标题 end -->

                                    <!-- 加载数据列表 -->
                                    <tbody>
                                    </tbody>
                                   <!-- 加载数据列表 end -->
                                </table>

                                <!-- 底部操作栏 -->
                                 <div class="row-fluid">
                                        <div class="span4">

                                        <!--  <button class="btn btn-small btn-primary"><i class="icon-ok bigger-110"></i>审核</button>
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
                                <!-- 底部操作栏 end -->
                            </div>
                        </div>
                        <!-- 列表内容 end -->
                </div>
            </div>
            <!--main-container end-->
        </div> 
        <!-- content end-->
		
<!-- 操作后提示框 -->
        <div id="wt-alert" class="hide" style="margin-bottom:-1.5em"></div>
        <form id="wt-category" class="modal fade hide form-horizontal" method="post" tabindex="-1" onsubmit="return false;" enctype="multipart/form-data"></form>
        <form id="wt-field" class="modal fade hide form-horizontal" method="post" tabindex="-1" onsubmit="return false;"></form>
<!-- 操作后提示框 -->

        <!-- 全局js -->
        <script src="{{ASSET_URL}}system/hplus/js/jquery-2.1.1.min.js"></script>
        <script src="{{ASSET_URL}}system/hplus/js/bootstrap.mind797.js?v=3.4.0"></script>
        <!-- // <script src="{{ASSET_URL}}hplus/js/content.mine209.js?v=1.0.0"></script> -->

        <!-- layer javascript -->
        <script src="{{ASSET_URL}}system/hplus/js/plugins/layer/layer.min.js"></script>
        <script src="{{ASSET_URL}}system/admin/js/table/weitac.js"></script>       
        <script type="text/javascript" src="{{ASSET_URL}}system/admin/js/table/weitac.table.js"></script>
        <script type="text/javascript" src="{{ASSET_URL}}system/admin/js/table/jquery.tablesorter.js"></script>
        <script type="text/javascript" src="{{ASSET_URL}}system/admin/js/table/jquery.pagination.js"></script>   


        <script type="text/javascript">
            var menuid ='{{$menuid}}';
            var manage_operation = '<td><button class="btn btn-info btn-mini" type="button" onclick="edit({menuid})">修改</button> <button class="btn btn-danger btn-mini" type="button" onclick="del({menuid})">删除</button></td>';
            var row_template = '<tr>';
            row_template += '<td class="center"><label><input type="checkbox" class="ace" /><span class="lbl"></span></label></td>';
            row_template += '<td>{sort}</td>';
            row_template += '<td><a href="/admin/core/system/menu/index?menuid={menuid}" class="J_menuItem"   target="_self">{name}</a> </td>';
            row_template += '<td>{url}</td>';
            row_template += '<td>{status}</td>';
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
                baseUrl: '{{URL::route('admin.core.system.menu.ajaxindex')}}?orderby=sort|asc&menuid='+menuid

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
      
    </body>

</html>

<script>
        //添加新数据
        function add() {
          var menuid = $("#menuid").val();

          var index = layer.open({
                type: 2, 
                // skin:'demo-class',
                title: ['添加菜单', 'font-size:18px;background:#307ECC;color:#fff'],
                move: '.layui-layer-title',  //触发拖动的元素false 禁止拖拽，.layui-layer-title 可以拖拽
                area: ['500px', '350px'], //设置弹出框的宽高
                shade: [0.5, '#000'], //配置遮罩层颜色和透明度
                shadeClose:true, //是否允许点击遮罩层关闭弹窗 true /false
                // time:1000,  设置自动关闭窗口时间 1秒=1000；
                shift:0,  //打开效果：0-6 。0放大，1从上到下，2下到上，3左到右放大，4翻滚效果；5渐变；6抖窗口
                content: ['{{URL::route('admin.core.system.menu.add')}}?menuid='+menuid,'no'], 
                // btn: ['确定', '取消']
                // ,yes: function(index, layero){ 
                //      //  layer.alert('确定');  
                //      alert('第2次：'+parentid+'开始调用方法');
                //      // insert(parentid);
                //      $("#tijiao_id").click();

                //    // layer.close(index); //一般设定yes回调，必须进行手工关闭

                // },cancel: function(index){ 
                //     // layer.alert('取消取消取消取消');   
                // }
            });    
        }



 function tijiao(){
	  	
	  	var menuid = $("#parentid").val();
	
	  	var index = parent.layer.getFrameIndex(window.name); //获取当前窗体索引

	  	var name_v = $("#name_v").val();  //名称不能为空

	  	if(name_v ==""){
	  		// layer.alert('菜单名称不能为空！', {icon: 2});
	  		$("#show_name_msg").show();
	     	die;

	  	}
	  
	  
	  	
           var obj = layer.getChildFrame('#wt-forms');//$('#wt-forms');
           alert(obj.serialize());
             var actionUrl = "{{URL::route('admin.core.system.menu.insert')}}";
                $.ajax({
                type:'get',
                        url:actionUrl,
                        data:obj.serialize(),
                        cache:false,
                        success:function(data){
                        // 验证不通过
                        if (!data.status)
                        {
                              
                            layer.alert('添加失败', function(index){
							    //do something
							   layer.closeAll(index); //执行关闭

							});  
                        }
                        // 验证通过
                        else
                        {
                             
     		      		   //layer.alert('添加成功！', function(index){
     		      		   		//重新加载列表页
							   // parent.location.href='{{URL::route('admin.core.system.menu.index')}}?menuid='+menuid;
							    layer.closeAll(); //执行关闭
 tableApp.load();//刷新页面
							//});  
                        }
                        },
                        error:function(data){
                               layer.alert('网络错误！', {icon: 1});  //带图标
                        }
		    });

        }

         //弹出修改页面窗口
        function edit(menuid) {

          var index = layer.open({
                type: 2, 
                // skin:'demo-class',
                title: ['修改信息', 'font-size:18px;background:#307ECC;color:#fff'],  //标题部分，这这里可以设置样式
                move: '.layui-layer-title',  //触发拖动的元素false 禁止拖拽，.layui-layer-title 可以拖拽
                area: ['500px', '350px'], //设置弹出框的宽高
                shade: [0.5, '#000'], //配置遮罩层颜色和透明度
                shadeClose:true, //是否允许点击遮罩层关闭弹窗 true /false
                // time:1000,  设置自动关闭窗口时间 1秒=1000；
                shift:0,  //打开效果：0-6 。0放大，1从上到下，2下到上，3左到右放大，4翻滚效果；5渐变；6抖窗口
                content: ['{{URL::route('admin.core.system.menu.edit')}}?menuid='+menuid,'no'], 
                // btn: ['确定', '取消']
                // ,yes: function(index, layero){ 
                //      //  layer.alert('确定');  
                //      alert('第2次：'+parentid+'开始调用方法');
                //      // insert(parentid);
                //      $("#tijiao_id").click();

                //    // layer.close(index); //一般设定yes回调，必须进行手工关闭

                // },cancel: function(index){ 
                //     // layer.alert('取消取消取消取消');   
                // }
            });    
        }


        // 删除
        function del(menuid){

            //询问框
            layer.confirm('您确定要删除该信息？', {
                title:['危险操作', 'color:#fff;background:#fbb450'], //提示标题
                btn: ['确定(Y)','取消(N)'], //按钮
                skin: 'del-class',  //可自定义一个皮肤类，然后通过css来设置对应的样式
 
            }, function(){
                // layer.msg('的确很重要', {icon: 1});

                    var obj = 'menuid=' + menuid;
                    var actionUrl = "{{URL::route('admin.core.system.menu.del')}}";
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
                                    layer.confirm(data.msg, {icon: 2}, function(index){
                                        layer.close(index); //关闭
                                    });

                            }
                            // 验证通过
                            else
                            {
                                // layer.msg('删除成功', {shift: 5});   //数字可以是0--6 ，5表示渐变显示
                                //  layer.close(index); //关闭
                                //         tableApp.load();

                                   layer.confirm('删除成功！', {icon: 1}, function(index){
                                        layer.close(index); //关闭
                                        tableApp.load();
                                    });
                                    
                            }
                            },
                            error: function(data) {
                                    layer.confirm('网络通信错误！', {icon: 3}, function(index){
                                        layer.close(index); //关闭
                                    });
                            }
                    });



            }, function(){
                layer.msg('操作已取消！', {shift: 5});   //数字可以是0--6 ，5表示渐变显示
            });



        }


        // 点击进入下一层创建
        function create_child(menuid){
          
              parent.location.href='{{URL::route('admin.core.system.menu.index')}}?menuid='+menuid;
       
        }

        //返回上一级
        function return_index(){
             var return_id =$("#return_id").val();

              // alert(return_id);
             parent.location.href='{{URL::route('admin.core.system.menu.index')}}?menuid='+return_id;

        }

</script>