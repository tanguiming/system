<link rel="stylesheet" href="{{ASSET_URL}}admin/css/jquery-ui-1.10.3.full.min.css" />
<link href="{{ASSET_URL}}hplus/css/font-awesome.mine0a5.css?v=4.3.0" rel="stylesheet">
<link href="{{ASSET_URL}}hplus/css/animate.min.css" rel="stylesheet">

<link href="{{ASSET_URL}}hplus/css/plugins/iCheck/custom.css" rel="stylesheet">
<link href="{{ASSET_URL}}hplus/css/style.min2513.css?v=3.0.0" rel="stylesheet">
<div class="modal-content animated bounceInRight">

    <div class="modal-body">
	<form id="wt-forms">
      
        <div class="form-group"><label>名字</label> <input type="text" name='name'  placeholder="请输入您的名字" class="form-control required"></div>
        <div class="form-group"><label>名字1</label> <input id="cname" class="form-control" type="text" aria-required="true" required="" minlength="2" name="name"></div>
        <div class="form-group"><label>性别</label> <input type="radio" name ="sex" id="sex"  value="1" checked="checked"/>男&nbsp;&nbsp;&nbsp;
                        <input type="radio" name ="sex" id="sex"  value="2"/>女</div>
        <div class="form-group"><label>年龄</label> <input type="text" name='age' placeholder="请输入您的年龄" class="form-control"></div>
		
		<div>
                                    <button class="btn btn-primary" id='regsub' type="submit" onclick="window.parent.insert();">保存内容</button>
									<button class="btn btn-white" type="submit" onclick="window.parent.Closes()">取消</button>
                                </div>
    </form>
	</div>

</div>
<script src="{{ASSET_URL}}hplus/js/jquery-2.1.1.min.js"></script>
<script src="{{ASSET_URL}}hplus/js/plugins/layer/layer.min.js"></script>
