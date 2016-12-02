<link rel="stylesheet" href="{{ASSET_URL}}admin/css/jquery-ui-1.10.3.full.min.css" />
<div class="modal-content animated bounceInRight">

    <div class="modal-body">
	<form id="wt-forms">
      
        <div class="form-group"><label>名字</label> <input type="text" name='name' placeholder="请输入您的名字" class="form-control"></div>
        <div class="form-group"><label>性别</label> <input type="radio" name ="sex" id="sex"  value="1" checked="checked"/>男&nbsp;&nbsp;&nbsp;
                        <input type="radio" name ="sex" id="sex"  value="2"/>女</div>
        <div class="form-group"><label>年龄</label> <input type="text" name='age' placeholder="请输入您的年龄" class="form-control"></div>
		
		<div>
                                    <button class="btn btn-primary" id='regsub' type="submit" onclick="insert();">保存内容</button>
									<button class="btn btn-white" type="submit">取消</button>
                                </div>
    </form>
	</div>

</div>

        <script type="text/javascript">
			
			//页面弹框
			function insert(){
				var obj = $('#wt-forms');
				alert(obj.serialize());
				var actionUrl = "{{URL::route('admin.core.system.student.insert')}}";
            $.ajax({
					type:'GET',
                    url:actionUrl,
                    data:obj.serialize(),
                    cache:false,
                    success:function(data){
                    // 验证不通过
						alert(data);
                    },
						error:function(data){

                    }
            });
			}
		
        </script>