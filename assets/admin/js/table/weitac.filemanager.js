/**
 * file manager application
 * @needs weitac.js & weitac.dialog.js
 */
(function(ct,$){
var re_pre_upurl = new RegExp('^'+UPLOAD_URL);
$.extend(ct,{
	fileManager:function(callback_ok, ext, multi)
	{
		var url = ['?app=system&controller=attachment&action=index&select=1'];
		multi || (url.push('&single=1'));
		ext || (ext = 'jpg,jpeg,png,gif');
		url.push('&ext_limit='+ext);
		var d = ct.iframe(url.join(''),820, 465, null, {
			ok : function(res){
				if (multi)
				{
					for(var i=0,l=res.length;i<l;i++){
						res[i].src && (res[i].src = res[i].src.replace(re_pre_upurl,''));
					}
				}
				else
				{
					res.src && (res.src = res.src.replace(re_pre_upurl,''));
				}
				(ct.func(callback_ok) || function(){})(res);
				d.dialog('close');
			}
		});
		return d;
	},
	fileManager1:function(callback_ok, ext, multi)
	{
		var url = ['?app=system&controller=attachment&action=index&select=1'];
		multi || (url.push('&single=1'));
		ext || (ext = 'swf,flv,avi,wmv,rm,rmvb,mp4,3gp');
		url.push('&ext_limit='+ext);
		var d = ct.iframe(url.join(''),820, 465, null, {
			ok : function(res){
				if (multi)
				{
					for(var i=0,l=res.length;i<l;i++){
						res[i].src && (res[i].src = res[i].src.replace(re_pre_upurl,''));
					}
				}
				else
				{
					res.src && (res.src = res.src.replace(re_pre_upurl,''));
				}
				(ct.func(callback_ok) || function(){})(res);
				d.dialog('close');
			}
		});
		return d;
	},
	editImage:function(src, callback_ok)
	{
		if (!src) return;
		var d = ct.iframe('?app=system&controller=attachment&action=edit_image&fileurl='+src,
	    450, 450, null, {
			ok:function(vars){
				var new_image = vars.orig_img.replace(re_pre_upurl,'');
				(ct.func(callback_ok) || function(){})(new_image);
				d.dialog('close');
			}
		});
		return d;
	}
});
$.fn.imageInput = function(){
	this.each(function(){
		var input = $(this);
		var upbtn = $(input.attr('upbtn')),
			filebtn = $(input.attr('filebtn')),
			editbtn = $(input.attr('editbtn'));
		input.floatImg({url:UPLOAD_URL,width:200});
		upbtn.imgUploader(function(imgurl){
			input.val(imgurl);
			editbtn.show();
		});
		editbtn.click(function(){
			ct.editImage(input.val(),function(newImg){
				input.val(newImg.replace(''+UPLOAD_URL, ''));
			});
		});
		filebtn.click(function(){
			ct.fileManager(function(at){
				var file = at.src;
				input.val(file.replace(''+UPLOAD_URL, ''));
				editbtn.show();
			});
		});
	});
	return this;
};
$.fn.photoInput = function(){
	var input = this;
	var upbtn = $(input.attr('upbtn')),
		editbtn = $(input.attr('editbtn')),
		preview = $(input.attr('preview'));
	upbtn.imgUploader(function(imgurl){
		input.val(imgurl.replace(/^avatar\//,''));
		preview.attr('src',UPLOAD_URL+imgurl);
		editbtn.show();
	}, '?app=system&controller=upload&action=photo', 'images/upload.gif');
	editbtn.click(function(){
		ct.editImage('avatar/'+input.val(), function(newImg){
			input.val(newImg.replace(/^avatar\//,''));
			preview.attr('src',UPLOAD_URL+newImg+'?'+Math.random());
		});
	});
	return this;
};
})(weitac,jQuery);