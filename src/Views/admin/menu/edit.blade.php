<link rel="stylesheet" href="{{ASSET_URL}}system/admin/css/jquery-ui-1.10.3.full.min.css" />
<link href="{{ASSET_URL}}system/hplus/css/font-awesome.mine0a5.css?v=4.3.0" rel="stylesheet">
<link href="{{ASSET_URL}}system/hplus/css/animate.min.css" rel="stylesheet">

<link href="{{ASSET_URL}}system/hplus/css/plugins/iCheck/custom.css" rel="stylesheet">
<link href="{{ASSET_URL}}system/hplus/css/style.min2513.css?v=3.0.0" rel="stylesheet">

<!-- <link href="{{ASSET_URL}}admin/css/bootstrap.min.css" rel="stylesheet" /> -->
<link rel="stylesheet" href="{{ASSET_URL}}system/admin/css/ace-fonts.css" />
<link rel="stylesheet" href="{{ASSET_URL}}system/admin/css/ace-skins.min.css" />

<style>
	.form-group{margin-bottom: 5px;}
	#tijiao_id{width: 100px;height: 30px;line-height: 30px; float:right;margin-top: 20px;padding: 0px 15px 15px 15px;}
</style>
<div >
<!-- <div class="modal-content animated bounceInRight"> -->
    <div class="modal-body">
	<form id="wt-forms"  action="javascript:">
      
       <div class="span12">
				<div class="col-md-12">
				    <div class="form-group">
				        <label class="col-sm-3 control-label">菜单名称：</label>
				        <div class="col-sm-9">
				            <input type="text" name="name" class="form-control" placeholder="请输入文本" value="{{$data['name']}}"  id="name_v"> 
							<span class="help-block m-b-none" style="color:red;display:none" id="show_name_msg"><i class="fa fa-times-circle" ></i>必填</span>	
				        </div>
				    </div>
				    <div class="form-group">
				        <label class="col-sm-3 control-label">菜单地址：</label>
				        <div class="col-sm-9">
				            <input type="text" name="url" class="form-control" placeholder="请配置路由地址" value="{{$data['url']}}">

				        </div>
				    </div>
				     <div class="form-group">
				        <label class="col-sm-3 control-label">是否显示：</label>
				        <div class="col-sm-9">
				            <label class="radio-inline">
				                <input type="radio"   @if($data['status'] == 1)checked="checked"@endif  value="1" id="optionsRadios1" name="status">显示</label>
				            <label class="radio-inline">
				                <input type="radio"   @if($data['status'] == 0)checked="checked"@endif  value="0" id="optionsRadios2" name="status">禁用</label>
				        </div>
				    </div>
				    <div class="form-group">
				        <label class="col-sm-3 control-label">排序：</label>
				        <div class="col-sm-9">
				            <input type="text" name="sort" class="form-control"  value="{{$data['sort']}}">
				        </div>
				    </div>

				     <div class="form-group">  
				        <div class="col-sm-12 col-sm-offset-3">
				           <input type="hidden" name="menuid" value="{{$data['menuid']}}" id="menuid">
				           <input type="hidden"  name="return_id" value="{{$data['parentid']}}" id="return_id">
			              <button type="submit" class="btn  btn-success" onclick="update();" id="tijiao_id" >保存信息</button>
				     </div>
				     
				</div>
		
		</div>
    </form>
	</div>

</div>
<script src="{{ASSET_URL}}system/hplus/js/jquery-2.1.1.min.js"></script>
<script src="{{ASSET_URL}}system/hplus/js/plugins/layer/layer.min.js"></script>

<script>
		
	// 修改信息
	  function update(){
	  	var return_id =$("#return_id").val();

	  	var index = parent.layer.getFrameIndex(window.name); //获取当前窗体索引
	  	
	  	var name_v = $("#name_v").val();  //名称不能为空

	  	if(name_v ==""){
	  		// layer.alert('菜单名称不能为空！', {icon: 2});
	  		$("#show_name_msg").show();
	     	die;

	  	}

           var obj = $('#wt-forms');
             var actionUrl = "{{URL::route('admin.core.system.menu.update')}}";
                $.ajax({
                type:'get',
                        url:actionUrl,
                        data:obj.serialize(),
                        cache:false,
                        success:function(data){
                        // 验证不通过
                        if (!data.status)
                        {
                              
							layer.confirm('修改失败！', {icon: 2}, function(index){
								 // 先转跳，再关闭
								 parent.location.href='{{URL::route('admin.core.system.menu.index')}}?menuid='+return_id;
                                 parent.layer.close(index); //执行关闭
                                
                                
                            }); 
                        }
                        // 验证通过
                        else
                        {
                             
     		      		    layer.confirm('修改成功！', {icon: 1}, function(index){
     		      		    	 // 先转跳，再关闭
     		      		    	 parent.location.href='{{URL::route('admin.core.system.menu.index')}}?menuid='+return_id;
                                 parent.layer.close(index); //执行关闭
                                
                                
                            });
                        }
                        },
                        error:function(data){
                               layer.alert('网络错误！', {icon: 3});  //带图标
                        }
		    });

        }

</script>



