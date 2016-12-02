/**
 * weitac basework
 *
 */
Array.prototype.indexOf || (Array.prototype.indexOf = function(item,i){
	// for ie lt 7
	i || (i = 0);
	var length = this.length;
	if(i < 0){
		i = length + i;
	}
	for(; i < length; i++){
		if(this[i] === item) return i;
	}
	return -1;
});
(function($){
var userAgent = navigator.userAgent.toLowerCase(),
	_ieversion = parseInt((/.+msie[\/: ]([\d.]+)/.exec(userAgent) || {1:0})[1]),
	IE = _ieversion && !/opera/.test(userAgent),
	_mode = (IE && _ieversion > 7) ? document.documentMode : 0,
	IE6 = IE && (_ieversion < 7 || _mode == 5),
	IE7 = IE && (_ieversion == 7 || _mode == 7),
	IE8 = _mode == 8,
	doc = $(),
	listenning = 1,
	_loadingBox = null,
	_tips = null,
	httpRegex = /^http[s]?\:\/\//i,
	UPLOAD_OPTIONS = {
		uploader : 'uploadify/uploadify.swf',
		method : 'POST',
		queueID : 'fileQueue%%%',
		width : 100,
		height : 22,
		auto : true,
		multi : 1,
		wmode : 'transparent',
		hideButton : true
	};
function createTips(className, html) {
	var t;
	if (_tips) {
		t = _tips[0];
		var timer = _tips.data('timer');
		_tips.stop();
		timer && (clearTimeout(timer), clearInterval(timer));
	} else {
		t = document.createElement('div');
		_tips = $(t).appendTo(document.body);
	}
	t.className = className;
	t.style.cssText = 'position:fixed;visibility:hidden;z-index:10000;';
	_tips.html(html);
	return _tips;
}
var bubble = function(){
	this.bubble = $('\
		<div class="bubble">\
			<div class="corner tl"></div>\
			<div class="corner tr"></div>\
			<div class="corner bl"></div>\
			<div class="corner br"></div>\
			<div class="top"></div>\
			<div class="cnt"></div>\
			<div class="bot"></div>\
			<div class="point"></div>\
		</div>\
	').appendTo(document.body);
	this.pointer = this.bubble.find('.point');
	this.cnt = this.bubble.find('.cnt');
};
bubble.prototype = {
	pointTo:function(o){
		var x, y;
		if (o.nodeType == 1 ? (o = $(o)) : o.jquery) {
			var offset = o.offset();
			x = offset.left + parseInt(o[0].offsetWidth / 2);
			y = offset.top + parseInt(o[0].offsetHeight / 2);
		} else if (o.originalEvent) {
			x = o.pageX;
			y = o.pageY;
		} else {
			return;
		}

		var ww = weitac.innerWidth(), wh = weitac.innerHeight(), 
			sL = doc.scrollLeft(), sT = doc.scrollTop(),
			$b = this.bubble, b = $b[0], bw, bh,
			pclass, bTop, bLeft;
		b.style.cssText = '';
		bw = b.offsetWidth;
		bh = b.offsetHeight;
		if (!bw|| !bh) {
			b.style.display = 'block';
			bw = b.offsetWidth;
			bh = b.offsetHeight;
		}
		b.style.width = bw+'px';
		if ((wh / 2) > (y - sT)) {
			bTop = y + parseInt(this.pointer.height()) + 13;
			pclass = 'S';
		} else {
			bTop = y - bh - parseInt(this.pointer.height()) - 2;
			pclass = 'N';
		}
		if ((ww / 2) > (x - sL)) {
			bLeft = x - 13;
			pclass += 'W';
		} else {
			bLeft = x - bw + 10;
			pclass += 'E';
		}
		this.pointer[0].className = 'point '+pclass;
		$b.css({left:bLeft, top:bTop});
		return this;
	},
	setYellow:function(flag){
		this.bubble[flag ? 'addClass' : 'removeClass']('yellow');
		return this;
	},
	html:function(html){
		this.cnt.html(html);
		return this;
	},
	get:function(){
		return this.bubble;
	}
};
var uploadBox = function(options) {
	var box = $('\
	<div class="uploadBox">\
		<div class="percent"></div>\
		<div class="bar">\
			<div class="proccess"></div>\
		</div>\
		<div class="status"></div>\
	</div>');
	var divs = box.find('div');
	var percent = divs.filter('.percent');
	var proccess = divs.filter('.proccess');
	var status = divs.filter('.status');
	var complete = 0;
	var started = 0;
	box.dialog({
		autoOpen:false,
		width  : options.width || 350,
		height : options.height || 150,
		modal  : true,
		resizable:false,
		title  : options.title || '文件上传',
		buttons:{
			'终止':function(){
				box.dialog('close');
			}
		},
		beforeclose:function(){
			if (complete) return true;
			if (window.confirm('未处理所有上传，确定要终止吗？'))
	    	{
	    		typeof options.destroy == 'function' && options.destroy();
	    	}
		},
		close:function(){
			started = 0;
			complete = 0;
			options.onclose && options.onclose();
		}
	});
	this.update = function(percentage, html) {
		this.setPercentage(percentage);
		this.setStatus(html);
	};
	this.setStatus = function(html) {
		status.html(html);
	};
	this.setPercentage = function(percentage) {
		percentage = percentage + '%';
		percent.html(percentage);
		proccess.width(percentage);
	};
	this.complete = function(html, delay) {
		complete = 1;
		started = 0;
		this.setPercentage(100);
		html && this.setStatus(html);
		var ival = setTimeout(function(){
			box.dialog('isOpen') && box.dialog('close');
		}, delay||3000);
		box.dialog('option','buttons',{
			'关闭':function(){
				ival && clearTimeout(ival);
				box.dialog('close');
			}
		});
	};
	this.start = function() {
		if (started) return;
		started = 1;
		complete = 0;
		box.dialog('option','buttons',{
			'终止':function(){
				box.dialog('close');
			}
		}).dialog('open');
		this.setPercentage(0);
		this.setStatus('');
	};
};

var weitac = {
	IE6 : IE6,
	IE7 : IE7,
	IE8 : IE8,
    // TODO: remove
	substr:function(str, len) {
		var l = 0;
		for (var i=0; i<str.length; i++) {
			l += str.charCodeAt(i) > 255 ? 2 : 1;
			if (l > len) {
				break;
			}
		}
		if (l <= len) {
			return str;
		}
		len = len - 3;
		while (i--) {
			l -= str.charCodeAt(i) > 255 ? 2 : 1;
			if (l <= len) {
				break;
			}
		}
		return str.substr(0,i+1) + '...';
	},
	pos:function (pos, width, height) {
		pos || (pos = 'right');
    	var doc = $(document),
    		sL = doc.scrollLeft(), sT = doc.scrollTop(),
    		iH = weitac.innerHeight(), iW = weitac.innerWidth();
    	var style = {}, offset;
    	if (pos == 'top') {
    		style.top = 2;
    		style.left = (iW-width)/2;
    	} else if (pos == 'right') {
    		style.top = 2;
    		style.right = 2;
    	} else if (pos == 'center') {
    		style.top = (iH-height) * .382;
    		style.left = (iW-width)/2;
    	} else if (pos.nodeType == 1 ? (pos = $(pos)) : pos.jquery ) {
    		offset = pos.offset();
    		offset.left = offset.left - sL;
    		offset.top = offset.top - sT;
    		if (offset.left + width > iW) {
    			style.left = offset.left - width + pos.outerWidth();
    		} else {
    			style.left = offset.left;
    		}
    		var ph = pos.outerHeight();
    		if (offset.top + height + ph > iH) {
    			style.top = offset.top - height;
    		} else {
    			style.top = offset.top + pos.outerHeight();
    		}
    	} else if (pos.originalEvent) {
    		offset = {
    			left : pos.pageX - sL,
    			top  : pos.pageY - sT
    		};
    		if (offset.left + width > iW) {
    			style.left = offset.left - width;
    		} else {
    			style.left = offset.left;
    		}
    		if (offset.top + height > iH) {
    			style.top = offset.top - height;
    		} else {
    			style.top = offset.top;
    		}
    	}
    	return style;
	},
	/**
	 * page total width，include scroll width
	 */
	pageWidth:function(){
		return $.boxModel ? Math.max(
			document.documentElement.scrollWidth,
			document.documentElement.clientWidth,
			document.documentElement.offsetWidth
		) : Math.max(
			document.body.scrollWidth,
			document.body.offsetWidth
		);
	},
	pageHeight:function(){
		return $.boxModel ? Math.max(
			document.documentElement.scrollHeight,
			document.documentElement.clientHeight,
			document.documentElement.offsetHeight
		) : Math.max(
			document.body.scrollHeight,
			document.body.offsetHeight
		);
	},
	innerWidth:function(){
		return document.compatMode == "CSS1Compat" ? document.documentElement.clientWidth : document.body.clientWidth;
	},
	innerHeight:function(){
		return document.compatMode == "CSS1Compat" ? document.documentElement.clientHeight : document.body.clientHeight;
	},
	/**
	 * get correct reference of function
	 */
	func:function(ns, context) {
        if (typeof ns == 'function') {
            return ns;
        }
        if (typeof ns == 'string') {
            ns = ns.split('.');
            var o = (context || window)[ns[0]], w = null;
            if (!o) return null;
            for (var i=1,l;l=ns[i++];) {
                if (!o[l]) {
                    return null;
                }
                w = o;
                o = o[l];
            }
            return o && (function(){
                return o.apply(w, arguments);
            });
        }
        return null;
    },
    
    
    /**
     * listen
     */
	listenAjax:function() {
		$().ajaxStart(function(){
			listenning && weitac.startLoading();
			listenning = 1;
		}).ajaxStop(function(){
			weitac.endLoading();
		}).ajaxError(function(){
			weitac.endLoading();
		});
	},
    stopListenOnce:function() {
        listenning = 0;
    },
    startLoading:function(pos, msg, width) {
    	if (_loadingBox) return _loadingBox;
    	msg || (msg = '载入中……');
    	_loadingBox = $('<div class="loading" style="position:fixed;visibility:hidden"><sub></sub> '+msg+'</div>')
    		.appendTo(document.body);
    	if (!isNaN(width = parseFloat(width)) && width)
    	{
    		_loadingBox.css('width', width);
    	}
    	var style = weitac.pos(pos, _loadingBox.outerWidth(true), _loadingBox.outerHeight(true));
    	style.visibility = 'visible';
    	_loadingBox.css(style);
    	return _loadingBox;
    },
    endLoading:function() {
    	_loadingBox && _loadingBox.remove();
    	_loadingBox = null;
    },
    
    uploadBox:uploadBox,
    
    floatBox:function(html, pos, afterHtml) {
    	$('div.floatbox').remove();
    	var div = $('<div class="floatbox" style="position:fixed;visibility:hidden"></div>')
    		.appendTo(document.body);
    	var img = $('<img src="images/close.gif" />').css({
    		position:'absolute',
    		top:1,
    		right:2,
    		cursor:'pointer'
    	}).click(function(){
    		div.remove();
    	});
    	
    	div.html(img).append(html);
		typeof afterHtml == 'function' && afterHtml(div);
    	var doc = $(document);
    	var style = weitac.pos(pos, div.outerWidth(true), div.outerHeight(true));
    	style.visibility = 'visible';
    	div.css(style);
    	return div;
    },
    alert:function(msg, type) {
    	return this.tips(msg, type, 'center', 0);
    },
    tips:function(msg, type, pos, delay) {
    	(!type || type == 'ok') && (type = 'success');
    	var tips = createTips('ct_tips '+type, '<sub></sub> '+msg), ival,
    	a = $('<a style="margin-left:10px;color:#000080;text-decoration:underline;" href="close">知道了</a>').click(function(e){
    		e.stopPropagation();
    		e.preventDefault();
    		tips.fadeOut('fast');
    		ival && clearTimeout(ival);
    		ival = null;
    	}).appendTo(tips);
    	pos || (pos = 'center');
    	var style = weitac.pos(pos, tips.outerWidth(true), tips.outerHeight(true));
    	style.visibility = 'visible';
    	tips.css(style);
    	delay === undefined && (delay = 1);
    	delay && (ival = setTimeout(function(){
    		tips.fadeOut('fast');
    	}, delay * 1000), tips.data('timer', ival));
		return tips;
    },
	timer:function(msg, sec, type, callback, pos) {
		type || (type = 'success');
		msg = msg.replace('%s','<b class="timer">'+sec+'</b>');
		var tips = createTips('ct_tips '+type, '<sub></sub> '+msg),
			timer = tips.find('b.timer'),
			clause = tips.find('.clause');
    	pos || (pos = 'center');
    	var style = weitac.pos(pos, tips.outerWidth(true), tips.outerHeight(true));
    	style.visibility = 'visible';
    	tips.css(style);
		var iv = setInterval(function(){
			timer.text(--sec);
			sec < 1 && last();
		}, 1000);
		tips.data('timer', iv);
		var last = function(){
			iv && clearInterval(iv);
			iv = null;
			tips.hide();
			callback();
			return false;
		};
		clause.click(last);
		return tips;
	},
	ok:function(msg, pos, delay) {
        return this.tips(msg, 'success', pos, delay);
    },
    error:function(msg, pos, delay) {
        return this.tips(msg, 'error', pos, delay);
    },
    warn:function(msg, pos, delay) {
    	return this.tips(msg, 'warning', pos, delay);
    },
    msg:function(msg) {
    	return this.alert(msg, 'warning');
    },
	confirm:function(msg, ok, cancel, pos) {
		var tips = createTips('ct_tips confirm', '<sub></sub> '+msg+'<br/>');
		$('<button type="button" class="button_style_1">确定</button>').click(function(){
    		ok && ok(tips);
    		tips.hide();
    	}).appendTo(tips);
    	cancelBtn = $('<button type="button" class="button_style_1">取消</button>').click(function(){
    		cancel && cancel();
    		tips.hide();
    	}).appendTo(tips);
    	pos || (pos = 'center');
    	var style = weitac.pos(pos, tips.outerWidth(true), tips.outerHeight(true));
    	style.visibility = 'visible';
    	tips.css(style);
    	return tips;
	},
    getCookie:function(name) {
    	var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    },
    setCookie:function(name, value, options) {
    	 options = options || {};

        if (value === null) {
            value = '';
            options = $.extend({}, options);
            options.expires = -1;
        }
        if (!options.expires) {
        	options.expires = 1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString();
        }
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    },
    
    
    // TODO: remove
	pieHtml:function (url, width, height, title) {
		var swf_url = 'images/pie.swf?piedata='+encodeURIComponent(url);
		var code = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="'+width+'" height="'+height+'" title="'+title+'">';
			code += '<param name="movie" value="'+swf_url+'" />';
			code += '<param name="quality" value="high" />';
			code += '<param name="wmode" value="transparent" />';
			code += '<embed src="'+swf_url+'" quality="high" wmode="transparent" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="'+width+'" height="'+height+'"></embed>';
			code += '</object>';
		return code;
	}
};
	
weitac.assoc = {
    refresh:function() {
        if (top != self) {
        	top.superAssoc.refresh()
        }
    },
    open:function(url, target, path) {
    	if (top != self) {
        	top.superAssoc.open(url,target,path);
    	}
    },
    get:function(target) {
    	if (top != self) {
    		return top.superAssoc.get(target);
    	} else {
    		return null;
    	}
    },
    close:function(target) {
    	if (top != self) {
    		top.superAssoc.close(target);
    	}
	},
	opener:function() {
		if (top != self) {
    		return __ASSOC_TABID__ && top.superAssoc.get(__ASSOC_TABID__);
    	} else {
    		return null;
    	}
	},
    call:function(method) {
    	if (top != self) {
    		var args = Array.prototype.slice.call(arguments,1);
    		return top.superAssoc[method].apply(null,args);
    	}
    }
};
	
window.ct = window.weitac = weitac;
    
$.fn.extend({
	ajaxSubmit:function(options) {
	    if (!this.length) {
	        return this;
	    }
	    if (typeof options == 'function')
	        options = { success: options };
	
	    var url = $.trim(this.attr('action'));
	    if (url) {
		    url = (/^([^#]+)/.exec(url)||{})[1];
	   	}
	   	url = url || window.location.href || '';
	
	    options = $.extend({
	        url:  url,
	        type: this.attr('method') || 'GET'
	    }, options || {});
	
	    // provide opportunity to alter form data before it is serialized
	    if (options.beforeSerialize && options.beforeSerialize(this, options) === false) {
	        return this;
	    }
	
	    var a = this.serializeArray();
	    if (options.data) {
	        options.extraData = options.data;
	        for (var n in options.data) {
	          if(options.data[n] instanceof Array) {
	            for (var k in options.data[n])
	              a.push( { name: n, value: options.data[n][k] } );
	          }
	          else
	             a.push( { name: n, value: options.data[n] } );
	        }
	    }
	    
	    // give pre-submit callback an opportunity to abort the submit
	    if (options.beforeSubmit && options.beforeSubmit(a, this, options) === false) {
	        return this;
	    }
	
	    options.data = a;
		
		$.ajax(options);
	
		this.trigger('form-submit-notify', [this, options]);
	
		return this;
	},
    ajaxForm : function(jsonok, infoHandler, beforeSubmit) {
    	var form = this,
		url = this.attr('action'),
		type = this.attr('method') || 'POST',
		jsonok = weitac.func(jsonok) || function(json){
			json.state
		    	? weitac.ok('保存成功')
		    	: weitac.error(json.error)
		},
		beforeSubmit = weitac.func(beforeSubmit) || function(){},
    	submitHandler = function(){
    		if (form.data('lock')) return;
    		if (beforeSubmit(form) === false) {
    			return;
    		}
    		var buttons = form.find('*')
    			.filter(':button,:submit,:reset')
    			.attr('disabled','disabled'),
    		complete = function(){
    			form.data('lock', false);
    			buttons.attr('disabled','').removeAttr('disabled');
    		};
    	    form.data('lock', true);
    		$.ajax({
	    		dataType:'json',
	    		url:url,
	    		type:type,
	    		data:form.serialize(),
	    		success:jsonok,
	    		complete:complete,
	    		error:function(){
	    			weitac.error('请求异常');
	    		}
	    	});
    	};
    	// CTRL + ENTER|S quick submit
    	$().bind('keydown.ajaxForm',function(e){
    		if (e.ctrlKey && (e.keyCode == 13 || e.keyCode == 83))
    		{
    			e.stopPropagation();
    			e.preventDefault();
    			form.submit();
    		}
    	});
        if (this.attr('name')) {
            this.validate({
                submitHandler:submitHandler,
                infoHandler:infoHandler
            });
        } else {
			this.submit(function(e){
				e.stopPropagation();
				e.preventDefault();
				submitHandler();
			});
        }
        return this;
    },
    doc : function() {
        return this.map(function(i, elem) {
            return jQuery.nodeName(elem, "iframe")
              ? (elem.contentDocument || elem.contentWindow.document)
              : elem.ownerDocument
                 ? elem.ownerDocument
                 : $.nodeName(elem, "#document")
                    ? elem
                    : ("scrollTo" in elem && elem.document)
                       ? elem.document : null;
        });
    },
    win : function() {
        return this.map(function(i, elem) {
            return jQuery.nodeName(elem, "iframe")
              ? elem.contentWindow
              : elem.ownerDocument
                 ? (elem.ownerDocument.defaultView || elem.ownerDocument.parentWindow)
                 : $.nodeName(elem, "#document")
                    ? (elem.defaultView || elem.parentWindow)
                    : ("scrollTo" in elem && elem.document)
                       ? elem : null;
        });
    },
    // TODO: rewrite
    floatImg : function(options) {
		var opts = $.extend({
			url:'',
			width : null,
			height : null
		}, options||{});
		var hiddenObject = $(document.createElement('div'));
		$.extend(hiddenObject[0].style, {
			position   : 'absolute',
			overflow   : 'hidden',
			display    : 'none',
			padding    : '4px',
			background : '#ccc',
			border     : '1px solid #fff',
			width      : opts.width,
			height     : opts.height,
			zIndex     : 8888
		});
		$(document.body).append(hiddenObject);

		this.bind('mouseover',function(e){
			var data = this.value || this.getAttribute('thumb');
			if (!data) return;
			var left = e.pageX + 10;
			var top = e.pageY + 10;
			var imgsrc = httpRegex.test(data) ? data : (opts.url+data);
			imgsrc = imgsrc.replace(/\?[0-9\.]*$/,'') + '?' + Math.random(9);
			var html = ['<img src="'+imgsrc+'"'];
			opts.width && html.push(' width="'+opts.width+'"');
			opts.height && html.push(' height="'+opts.height+'"');
			html.push(' />');
	        hiddenObject.html(html.join('')).css({
				'top':top,
				'left':left,
				'display':'block'
			});
		}).bind('mousemove',function(e){
			var left = e.pageX+10;
			var top  = e.pageY+10;
			hiddenObject.css({
				top:top,
				left:left
			});
		}).bind('mouseout',function(){
			hiddenObject.hide();
		});
		return this;
	},
	attrTips : function(attr, theme) {
		var b, $b,
		ihide = function(){
			var delay = $b.data('delay');
			delay && clearTimeout(delay);
			$b.data('delay', null);
			$b.stop(1).css({opacity:'',display:'none'});
		};
		if (bubble.inst) {
			b = bubble.inst;
			$b = b.get();
		} else {
			b = new bubble();
			bubble.inst = b;
			$b = b.get();
		}
		var pos = null;
		this.bind('mouseover', function(e){
			pos = e;
			var t = this,
				c = this.getAttribute(attr),
				delay = $b.data('delay');
			delay && clearTimeout(delay);
			if (!c) return;
			delay = setTimeout(function(){
				$b.data('point', t);
				b.setYellow(theme != 'tips_green');
				b.html(c);
				b.pointTo(pos);
				$b.fadeIn('normal');
			}, 200);
			$b.data('delay', delay);
		}).bind('mouseout', ihide).bind('mousemove',function(e){
			pos = e;
			if ($b.data('point') != this) return;
			b.pointTo(e);
		});
		doc.bind('mousedown.bubble', ihide);
 	},
    // will remove
 	getTags:function(btn, valInput){
 		var frm = this;
 		$(btn).click(function(){
	    	$.post('?app=system&controller=tag&action=get_tags', frm.serialize(),
    		function(json){
    			if (json.state) {
    				$(valInput).val(json.data);
    			}
    		}, 'json');
		});
 	},
 	
 	
 	uploader:function(options) {
 		return this.each(function(){
 			var t = this, $t = $(t),
 			o = $.extend({}, UPLOAD_OPTIONS, {
	 			width:t.offsetWidth,
	 			height:t.offsetHeight,
	 			script:$t.attr('script'),
	 			multi:$t.attr('multi'),
	 			fileDesc:$t.attr('fileDesc'),
	 			fileExt:$t.attr('fileExt'),
	 			sizeLimit:$t.attr('sizeLimit'),
	 			fileDataName:$t.attr('fileDataName'),
	 			onSelect:function(e, id , file){
	 				$t.triggerHandler('select.uploadify', [id, file]);
	 				return false;
	 			},
	 			onProgress:function(e, id, file, data){
	 				$t.triggerHandler('progress.uploadify',[id, file, data]);
	 				return false;
	 			},
	 			onComplete:function(e, id, file, response, data){
	 				$t.triggerHandler('complete.uploadify', [id, file, response, data]);
	 				return false;
	 			},
	 			onAllComplete:function(e, data){
	 				$t.triggerHandler('allcomplete.uploadify', [data]);
	 				return false;
	 			},
	 			onError:function(e, id, file, error){
	 				$t.triggerHandler('error.uploadify', [id, file, error]);
	 				return false;
	 			}
	 		}, options||{}),
 			swf = $(document.createElement('div')).appendTo(t);
 			o.script = encodeURIComponent(o.script);
 			swf[0].id = 'uploadify-'+parseInt(Math.random()*100);
	 		swf.uploadify(o);
	 		$('#'+swf[0].id+'Uploader').appendTo(swf);
	 		$t.css('position','relative');
	 		swf[0].style.cssText = 'position:absolute;display:block;z-index:1;top:0;left:0;width:'+o.width+'px;height:'+o.height+'px;overflow:hidden';
 		});
 	},
    // will remove
	/**
	 * @needs jquery.uploadify.js
	 */
	imgUploader : function(callback, url, btnimg) {
		var authCookie = weitac.getCookie(COOKIE_PRE+'auth');
		this.uploadify({
			'uploader'       : 'uploadify/uploadify.swf',
			'script'         : encodeURIComponent((url || '?app=system&controller=upload&action=thumb')+'&auth='+authCookie),
			'method'		 : 'POST',
			'fileDesc'		 : '注意:您只能上传gif、jpeg、jpg、png格式的文件!',
			'fileExt'		 : '*.jpg;*.jpeg;*.gif;*.png;',
			'cancelImg'      : 'images/cancel.png',
			'queueID'        : 'fileQueue',
			'buttonImg'	 	 : (btnimg || 'images/upst.gif'),
			'width'			 : '80',
			'height'		 : '22',
			'auto'           : true,
			'multi'          : false,
			 onComplete:function(event, queueId, fileObj, response, data)
			 {
			 	if(response!=0)
			 	{
			 		callback && callback(response);
				}
		    	else
		    	{
			 		weitac.tips('对不起！您上传文件过大而失败!', 'error');
			 	}
			 },
			 onError:function(event, queueId, fileObj,errorObj)
			 {
			 	weitac.tips(errorObj.type,'error');
			 }
		});
		return this;
	},
    // will remove
    insertSection : function(textValue, sel, offset, length){
	    var o = this[0];
		o.focus();
		var selection = document.selection;
		if (offset == undefined) {
			offset = 0;
		}
		if (selection && selection.createRange) {
			if (!sel) {
				sel = selection.createRange();
			}
			sel.text = textValue;
			var l = textValue.replace(/\r\n/g, '\n').length;
			sel.moveStart('character', offset-l);
			if (length != undefined) {
				sel.moveEnd('character', length-(l-offset));
			}
			sel.select();
		}
		else {
			var st = o.scrollTop, sl = o.scrollLeft;
			if (length == undefined) {
				length = textValue.replace(/\r\n/g, '\n').length - offset;
			}
			if (typeof o.selectionStart != 'undefined') {
				var opn = o.selectionStart + 0;
				o.value = o.value.substring(0, o.selectionStart)+textValue+o.value.substr(o.selectionEnd);
				o.selectionStart = opn + offset;
				o.selectionEnd = o.selectionStart + length;
			} else {
				o.value += textValue;
				o.focus();
				o.selectionStart = offset;
				o.selectionEnd = o.selectionStart + length;
			}
			o.scrollTop = st;
			o.scrollLeft = sl;
		}
		return this;
    },
    // will remove
    selection : function() {
    	var o = this[0];
    	o.focus();
    	return o.selectionStart !== undefined
    		? o.value.substring(o.selectionStart, o.selectionEnd)
    		: document.selection && document.selection.createRange
    		   ? document.selection.createRange().text
    		   : window.getSelection
    		     ? (window.getSelection() + '')
    		     : '';
    },
	maxLength : function() {
		this.each(function(){
			var maxLength = this.maxLength;
			var s = $('<strong class="c_green" style="margin-left:5px">0</strong>')
				.insertAfter(this);
			$.event.add(this, 'keyup', function(){
				$.textLength(this, s, maxLength);
			});
		}).keyup();
		return this;
	},
	// support mousewheel event
	mousewheel: function(fn) {
		return fn ? this.bind("mousewheel", fn) : this.trigger("mousewheel");
	},
	unmousewheel: function(fn) {
		return this.unbind("mousewheel", fn);
	}
});
	$.textLength = function(el, strong, maxLength) {
		if (maxLength) {
			var l = el.value.length;
			strong.html(l);
			l > maxLength && strong.addClass('c_red');
		} else {
			strong.html(el.value.length);
		}
		if (el.tagName == 'TEXTAREA' && el.scrollHeight > 70) {
			el.style.height = el.scrollHeight + 'px';
		}
	};

	var types = ['DOMMouseScroll', 'mousewheel'];
	$.event.special.mousewheel = {
		setup: function() {
			if ( this.addEventListener )
				for ( var i=types.length; i; )
					this.addEventListener( types[--i], handler, false );
			else
				this.onmousewheel = handler;
		},

		teardown: function() {
			if ( this.removeEventListener )
				for ( var i=types.length; i; )
					this.removeEventListener( types[--i], handler, false );
			else
				this.onmousewheel = null;
		}
	};
	function handler(event) {
		var args = [].slice.call( arguments, 1 ), delta = 0, returnValue = true;

		event = $.event.fix(event || window.event);
		event.type = "mousewheel";

		if ( event.wheelDelta ) delta = event.wheelDelta/120;
		if ( event.detail     ) delta = -event.detail/3;

		// Add events and delta to the front of the arguments
		args.unshift(event, delta);

		return $.event.handle.apply(this, args);
	}
	// TODO: remove
	window.template_select = function(inputid) {
		var path = $('#' + inputid).val();
		var d = ct.iframe('?app=system&controller=template&action=selector&path=' + path,600,420,
		function(iframe){
			var doc = iframe.doc()[0];
			var wH = iframe.css('overflow','hidden').innerHeight();
			var h = wH - (doc.getElementById('nav_area').offsetHeight + doc.getElementById('btn_area').offsetHeight);
			$(doc.getElementById('selector_area')).height(h);
		},{
			ok:function(val){
				$('#'+inputid).val(val);
				d.dialog('close');
			}
		});
	};
	// TODO: remove
	window.url = {
		member: function (userid) {
			parent.superAssoc.open('?app=member&controller=index&action=profile&userid='+userid, 'newtab');
		},

		ip: function (ip) {
			parent.superAssoc.open('?app=system&controller=ip&action=show&ip='+ip, 'newtab');
		}
	};
	$.ajaxSetup({
		beforeSend:function(xhr){
			xhr.setRequestHeader("If-Modified-Since","0");
			xhr.setRequestHeader("Cache-Control","no-cache");
		}
	});
})(jQuery);