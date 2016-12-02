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
				            <input type="text" name="name" class="form-control" placeholder="请输入文本"  id="name_v"> 
 							<span class="help-block m-b-none" style="color:red;display:none" id="show_name_msg"><i class="fa fa-times-circle" ></i>必填</span>
				        </div>
				    </div>
				    <div class="form-group">
				        <label class="col-sm-3 control-label">菜单地址：</label>
				        <div class="col-sm-9">
				            <input type="text" name="url" class="form-control" placeholder="请配置路由地址"  id="url_v">

				        </div>
				    </div>
				     <div class="form-group">
				        <label class="col-sm-3 control-label">是否显示：</label>
				        <div class="col-sm-9">
				            <label class="radio-inline">
				                <input type="radio" checked="" value="1" id="optionsRadios1" name="status">显示</label>
				            <label class="radio-inline">
				                <input type="radio" value="0" id="optionsRadios2" name="status">禁用</label>
				        </div>
				    </div>
				    <div class="form-group">
				        <label class="col-sm-3 control-label">排序：</label>
				        <div class="col-sm-9">
				            <input type="text" name="sort" class="form-control"  value="10">
				        </div>
				    </div>

				     <div class="form-group">  
				        <div class="col-sm-12 col-sm-offset-3">
				           <input type="hidden" name="parentid" value="{{$menuid}}" id="parentid">
			              <button type="submit" class="btn  btn-success" onclick="window.parent.tijiao();" id="tijiao_id" >确认</button>
				        </div>
				     </div>
				     
				</div>
		
		</div>
    </form>
	</div>

</div>
<script src="{{ASSET_URL}}system/hplus/js/jquery-2.1.1.min.js"></script>
<script src="{{ASSET_URL}}system/hplus/js/plugins/layer/layer.min.js"></script>

<script>
	 
</script>



