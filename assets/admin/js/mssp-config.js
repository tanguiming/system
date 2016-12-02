
/**
 * 播放器嵌入函数 v1.2
 * @wrapperId 播放器容器Id
 * @config 播放器基本配置
 * @custConfig 播放器自定义配置，该配置会覆盖config中的同名配置.除标准配置，扩展配置项有：
 *     mediaUrl 媒体路径
 *     splashUrl* 首帧地址
 *     splashScale 首帧大小
 *     playerUrl 播放器路径
 *     ipadSwitch* iOS支持
 *     hdSwitch*  是否提供高标清切换
 *     switchLight* 开关灯回调函数
 *
 *     目前支持的标准配置：clip
 *     带*为可选配置项；
 *
 * 实例1：mssp_config('player', 
 *                   config, 
 *                   {mediaUrl: '', 
 *                    playerUrl: '', 
 *                    ipadSwitch: true, 
 *                    hdSwitch: false, 
 *                    clip: {onFinish: function() {	playComplete(); }}
 *                   });
 */
 
function mssp_config(wrapperId, config, custConfig) {
    var pluginUrl = '';
    if(custConfig.playerUrl) pluginUrl = custConfig.playerUrl + '/swf/';
    if(custConfig.pluginUrl) pluginUrl = custConfig.pluginUrl; //向后兼容性，最早使用pluginUrl这个名称
    
    var mediaUrl = custConfig.mediaUrl;
    var uiLang = 'CN';
    
    if(config.language) uiLang = config.language;
    
    var pluginFiles = {rtmp: "mssp.rtmp-3.2.10.swf",
                       pseudo: "mssp.pseudostreaming-3.2.9.swf",
                       player: "mssp.commercial-3.2.16-dev.swf",
                       ova: "ova-1.1.1.swf"
                      };
    
    var options = {
        plugins: {
            viral: {
                 top: "50%",
                 width: "100%",
                 height: "100%",
                 canvas: {
                     backgroundColor: 'rgba(0, 0, 0, 0.6)',
                     backgroundGradient: [0, 0, 0],
                     border: '1px solid #cccccc'
                 },
                 email: false,
                 embed: false,
                 share: false,
                 related: false,
                 language: uiLang
                 
             },
            cnshare: {
                 language: uiLang,
                 videoPreview: {
                     width: 160,
                     height: 90,
                     delay: 1000
                 }
             }
        },
        clip: {
		    url: mediaUrl,
            provider: 'httpstreaming', 
            urlResolvers: ['f4m'],
            scaling: 'fit', 
            autoPlay: true, 
            autoBuffering: true, 
            bufferLength: 3
        },
        play: {
            replayLabel: ''
        }
    };
    
    if(custConfig.socialShare == undefined || custConfig.socialShare) {
        if(uiLang == 'CN') {
            options.plugins.viral.embed = {
                            labels: {
                                tabTitle: '嵌入',
                                title: '复制如下代码至页面中',
                                options: '自定义大小和颜色',
                                backgroundColor: '背景颜色',
                                buttonColor: '按钮颜色',
                                size: '大小',
                                copy: '复制',
                                copied: '已复制到剪贴板',
                                selectColor: '选择颜色',
                                colorWhite:'白色',colorRed:'红色',colorBlack:'黑色',colorBlue:'蓝色',colorYellow:'黄色',
                                colorGreen:'绿色',colorTrt:'透明',colorBlueTrt:'蓝色透明',colorYellowTrt:'黄色透明',colorGreenTrt:'绿色透明'
                            }
            };
            
            options.plugins.viral.share = {
                            labels: {
                                tabTitle: '分享',
                                title: ''
                            }
            };
            
        } else {
            options.plugins.viral.embed = {};
            
            options.plugins.viral.share = {
                            labels: {
                                title: ''
                            }
            };
        }
    }


    
    if(custConfig.related) {
        options.plugins.viral.related = {
        };
        
        options.plugins.viral.related.items = custConfig.related;
        
        if(custConfig.relatedConfig) {
            $.extend(true, options.plugins.viral.related, custConfig.relatedConfig);
        }
    }
    
    if(custConfig.clip) {
        if(!custConfig.clip.captionUrl && custConfig.clip.captionUrl2) {
            custConfig.clip.captionUrl = custConfig.clip.captionUrl2;
            custConfig.clip.captionUrl2 = '';
        }
        
        $.extend(true, options.clip, custConfig.clip);
    }

    if(custConfig.switchLight) {
        options.plugins.cnshare.onLightSwitch = function(lightOn) {
                             custConfig.switchLight(lightOn);
                         };
                         
    }
    
    //调试插件的加载
    //options.plugins.cnshare = false;
    //options.plugins.viral = false;
                         
    if(custConfig.hdSwitch) {
        options.clip.urlResolvers = ['f4m', 'bitrateselect'];
        
        options.plugins.bitrateselect = {
                hdButton: {
                    place: 'dock',
                    splash: false
                },
                language: uiLang
            };
            
    } else {
        options.plugins.bitrateselect = {
                hdButton: false,
                language: uiLang
            };
    }
    
    if(custConfig.ipadSwitch) {
        options.clip.ipadUrl = mediaUrl.replace("/manifest.f4m", "/playlist.m3u8");
    }
    
    if(!config.plugins) config.plugins = {};
    
    if(custConfig.clip.captionUrl || custConfig.clip.captionUrl2) {
        config.plugins.captions = {captionTarget: 'content', language: uiLang};
        config.plugins.dock = {zIndex: 10};
        config.plugins.content = {
                         url: 'org.flowplayer.content.Content',
                         zIndex: 9,
                         bottom: 25,
                         height:40,
                         backgroundColor: 'transparent',
                         backgroundGradient: 'none',
                         border: 0,
                         textDecoration: 'outline',
                         style: {
                             body: {
                                 fontSize: 18,
                                 fontFamily: 'Arial',
                                 textAlign: 'center',
                                 color: '#ffffff'
                             }
                         }
                     };
    } else {
        config.plugins.captions = false;
    }
    
    if(!config.plugins.content) {
        config.plugins.content = {display:'none'}; //隐藏默认content
    }
    
    if(config.plugins.ova) config.plugins.ova.url = pluginUrl + pluginFiles.ova;
    if(config.plugins.rtmp) config.plugins.rtmp.url = pluginUrl + pluginFiles.rtmp;
    if(config.plugins.pseudo) config.plugins.pseudo.url = pluginUrl + pluginFiles.pseudo;
    
    if(config.custom && config.custom.sponsor) {
        config.plugins.sponsor = {url: 'org.flowplayer.content.Content',
		                          width:64, 
		                          height:26, 
		                          bottom:30, 
		                          right: 10,
						          backgroundGradient:'none',
						          border:0,
						          borderRadius:0,
						          padding: 5,
						          body: {fontSize:10},
						          html: config.custom.sponsor
		                         };
    }
    
    if(config.custom && config.custom.pauseAd) {
        pauseAd = config.custom.pauseAd.content;
        
        config.plugins.pauseAd = {
                        url: 'org.flowplayer.content.Content',
                        width: config.custom.pauseAd.width,
                        height: config.custom.pauseAd.height,
                        top: '50%',
                        borderRadius: 0,
                        padding: 0,
                        opacity: 1,
                        display: "none"
                    };
                    
        var media =  mediaUrl.replace("/manifest.f4m", "");
        if(!config.clip) {
            config.clip = {};
        }
        
        config.clip.onPause = function(clip) {
                         if(clip.completeUrl.indexOf(media) >= 0) {
                             setPauseAdVisible(true);
                         }
                     };
        
        config.clip.onResume = function(clip) {
                         if(clip.completeUrl.indexOf(media) >= 0) {
                             setPauseAdVisible(false);                             
                         }
                     };
    
    }

    config.custom = {};
    $.extend(true, config, options);
    
    if(custConfig.splashUrl) {
        config.playlist = [];
        if(custConfig.splashScale == undefined) custConfig.splashScale = 'orig';
        config.playlist.push({'url': custConfig.splashUrl, 'scaling': custConfig.splashScale});
        if(config.clip.url)
            config.playlist.push(config.clip);

        config.clip = {
            //provider: 'httpstreaming', 
            //urlResolvers: ['f4m'],
            //scaling: 'fit', 
            //autoPlay: true, 
            //autoBuffering: true, 
            //bufferLength: 3        
        };
    }
    
    if(custConfig.dvr) {
		
		var newWrapperId = wrapperId + '-sub';
		var tW = $('#' + wrapperId).width();
		var tH = $('#' + wrapperId).height();
		var dvrW = 334;
		var playerW = tW - dvrW;
		
		var htmlPlayerWrapper = '<div id="' + newWrapperId + '" style="float:left; width:' + playerW + 'px; height:' + tH + 'px;"></div>';
		var htmlPanelWrapper = '<div id="mssp_epg_wrapper" style="float:left; width:' + dvrW + 'px; height:' + tH + 'px;"></div>';
		
		if(custConfig.dvr.position && custConfig.dvr.position == 'right') {
		    $('#' + wrapperId).html(htmlPlayerWrapper + htmlPanelWrapper + '<div class="clear"></div>');
		} else {
		    $('#' + wrapperId).html(htmlPanelWrapper + htmlPlayerWrapper + '<div class="clear"></div>');
		}
		
		wrapperId = newWrapperId;
	}
    
    var player;
    if(custConfig.ipadSwitch) {
        player = flowplayer(wrapperId, {src: pluginUrl + pluginFiles.player, wmode: 'opaque'}, config).ipad();
    } else {
        player = flowplayer(wrapperId, {src: pluginUrl + pluginFiles.player, wmode: 'opaque'}, config);
    }
    
	if(custConfig.dvr) {	
        //alert('dvr');
		var epgPanel = new EpgPanel('#mssp_epg_wrapper', 
		                            player,
		                            custConfig.playerUrl,
		                            custConfig.dvr.apiUrlChannels, 
		                            custConfig.dvr.apiUrlDates, 
		                            custConfig.dvr.apiUrlPrograms);
		epgPanel.buildUI();
    }
    
}


function setPauseAdVisible(isVisible) {
    
    var plugin = flowplayer("player").getPlugin("pauseAd");
    if(isVisible) {
        plugin.setHtml(pauseAd);
        plugin.show();
    } else {
        plugin.hide();
    }
    
}

/**
 * 如果是直播时移播放器：
 *    新建EpgPanel对象，实现节目单呈现、更新、回看等功能。
 *
 * 本功能依赖于如下数据接口：
 *   频道列表接口urlC
 *       [{id: '', title: '', stream:'', logo:''}, ...]
 *   日期列表接口urlD?channel=...
 *       ['2012-02-02', '2012-02-03', ...]
 *   节目单列表接口urlP?channel=...&date=...
 *       [{title: '', start: '', end: ''}, ...]
 *   服务器时间查询接口urlT
 *       {time: ''}
 */
function EpgPanel(epgWrapper, fPlayer, playerUrl, urlC, urlD, urlP, urlT) {
    this.eWrapper = epgWrapper;
    this.player = fPlayer;
    this.pUrl = playerUrl;
    
    /**
     * 数据API入口地址
     *   频道: 直接使用该地址，无需附加参数；
     *   日期: 在该地址后附加频道参数，?channel=...；
     *   节目: 在该地址后附加频道和日期参数，?channel=...&date=...；
     */
    this.apiUrlChannels = urlC;
    this.apiUrlDates = urlD;
    this.apiUrlPrograms = urlP;
    this.apiUrlTime = urlT;
    
    /**
     * 频道列表，每个元素为一个频道对象。
     *     [{id: '', title: '', stream:''}, ]
     */
    this.channels = [];
    this.curChannel = -1;
    this.stream = '';
    
    /**
     * 日期列表，每个元素为一个日期字符串。
     *     ['2012-02-02', '2012-02-03', ...]
     */
    this.dates = [];
    this.uiDate = -1;
    this.playDate = -1;
    
    /**
     * 每个日期的节目列表，二维数据，每个元素为一个节目对象。
     *     [[{id: '', title: '', start: '', end: ''}, {}, ...], ...]
     */
    this.programs = [];
    this.curProgram = -1;
    this.liveProgram = {date: -1, program: -1};
    
    this.serverTime = {sTime: -1, lTime: -1};
    this.isLiveTrackActive = false;
    this.liveTrackTimeout = -1;
    
    var self = this;
    var weekdays = ['星期天', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'];
    
    /**
     * 构建UI
     */
    this.buildUI = function() {
        var str = '<div id="mssp_epg_channel_wrapper">'
                + '    <div id="mssp_epg_prev_channel"><img src="' + this.pUrl + '/image/epg_prev_channel.png" /></div>'
                + '    <div id="mssp_epg_channel_list"></div>'
                + '    <div id="mssp_epg_next_channel"><img src="' + this.pUrl + '/image/epg_next_channel.png" /></div>'
                + '    <div class="clear"></div>'
                + '</div>'
                + '<div id="mssp_epg_content_wrapper">'
                + '    <div id="mssp_epg_day_wrapper">'
                + '        <div id="mssp_epg_prev_day"><img src="' + this.pUrl + '/image/epg_prev_day.png" /></div>'
                + '        <div id="mssp_epg_days"></div>'
                + '        <div id="mssp_epg_next_day"><img src="' + this.pUrl + '/image/epg_next_day.png" /></div>'
                + '    </div>'
                + '    <div id="mssp_epg_content">'
                + '        <div id="mssp_epg_channel_info">'
                + '            <div id="mssp_epg_channel_logo"></div>'
                + '            <div id="mssp_epg_channel_detail">'
                + '                <div id="mssp_epg_channel_date"></div>'
                + '                <div id="mssp_epg_channel_live_info"></div>'
                + '            </div>'
                + '            <div class="clear"></div>'
                + '        </div>'
                + '        <div style="margin: 6px 0px;"><img src="' + this.pUrl + '/image/epg_underline.png" style="width:261px; height:1px;" /></div>'
                + '        <div id="mssp_epg_programs"></div>'
                + '        <div id="mssp_epg_search">'
                + '            <input type="text" name="" /><img src="' + this.pUrl + '/image/epg_search.png" style="width:30px; height: 26px; vertical-align: bottom;" />'
                + '        </div>'
                + '    </div>'
                + '    <div class="clear"></div>'
                + '</div>';
               
        $(this.eWrapper).html(str);
        
        this.updateChannelList();
    };
    
    /**
     * 更新频道列表
     *  Ajax获取频道列表，更新channles属性。
     */
    this.updateChannelList = function() {
        $.ajax({
            dataType: "jsonp",
            context: this,
            url: this.apiUrlChannels,
            success: function(data) {
                this.channels = data;
                
                var items = [];
                $.each(data, function(key, val) {
                    items.push('<li id="epg-channel-' + key + '"><span>' + val.title + '</span></li>');
                });
                
                $('<ul/>', {
                    html: items.join('')
                }).appendTo('#mssp_epg_channel_list');
                
                $('#mssp_epg_channel_list').mCustomScrollbar({
                    horizontalScroll:true
                });
                
                $('#mssp_epg_channel_list li').click(function(obj) {
                    var id = $(this).attr('id').substr(12);
                    self.switchToChannel(parseInt(id));
                });
                
                if(this.channels.length > 0) {
                    this.switchToChannel(0);
                }
            }
        });
    };
    
    /**
     * 切换频道
     */
    this.switchToChannel = function(ch) {
        if(ch == this.curChannel || ch >= this.channels.length) {
            return;
        }
        var prevCh = this.curChannel;
        this.curChannel = ch;
        
        //清空日期
        $('#mssp_epg_days').html('');
        this.dates = [];
        this.uiDate = -1;
        this.playDate = -1;
        
        //清空当前频道信息
        if(prevCh >= 0) {
            $('#epg-channel-' + prevCh).removeClass('current');
        }
        $('#mssp_epg_channel_logo').html('');
        $('#mssp_epg_channel_date').html('');
        $('#mssp_epg_channel_live_info').html('');
        this.stream = '';
        
        //清空节目
        $('#mssp_epg_programs').html('');
        this.programs = [];
        this.curProgram = -1;
        this.liveProgram = {date: -1, program: -1};
        
        //取消定时更新
        if(this.liveTrackTimeout > 0) {
            clearTimeout(this.liveTrackTimeout);
            this.liveTrackTimeout = -1;
            this.isLiveTrackActive = false;
        }
        
        //频道高亮，设置Logo等信息
        $('#epg-channel-' + this.curChannel).addClass('current');
        $('#mssp_epg_channel_logo').html('<img src="'+this.channels[this.curChannel].logo+'" style="width:70px; height:50px;" />');
        
        //更新日期列表
        this.buildDateList();
    };
    
    /**
     * 更新日期列表
     */
    this.buildDateList = function() {
        $.ajax({
            dataType: "jsonp",
            context: this,
            url: this.apiUrlDates,
            data: {channel: this.channels[this.curChannel].id},
            success: function(data) {
                this.dates = data;
                
                var items = [];
                $.each(data, function(key, val) {
                    var d = new Date(parseInt(val.substr(0, 4), 10), parseInt(val.substr(5, 2), 10)-1, parseInt(val.substr(8, 2), 10));
                    items.push('<li id="epg-date-' + key + '"><span title="' + val + '">' + weekdays[d.getDay()] + '</span></li>');
                });
                
                $('<ul/>', {
                    html: items.join('')
                }).appendTo('#mssp_epg_days');
                
                $('#mssp_epg_days li').click(function(obj) {
                    var id = $(this).attr('id').substr(9);
                    self.switchToDate(parseInt(id));
                });
                
                if(this.dates.length > 0) {
                    this.switchToDate(this.dates.length - 1);
                }
            }
        });
        
    };          
    
    /**
     * 切换日期
     */
    this.switchToDate = function(d) {
        if(d == this.uiDate || d >= this.dates.length) {
            return;
        }
        var prevD = this.uiDate;
        this.uiDate = d;
        
        //清空当前日期信息
        if(prevD >= 0) {
            $('#epg-date-' + prevD).removeClass('current');
        }
        
        //高亮切换后的日期
        $('#epg-date-' + this.uiDate).addClass('current');
        
        $('#mssp_epg_programs').html('');
        this.updateProgramList();
    };
    
    /**
     * 更新节目列表(第一次更新节目单、后续点击更新)
     *   有当天节目单：显示节目列表；
     *   无当天节目单：发起Ajax请求，成功后更新服务器时间，显示节目列表；
     */
    this.updateProgramList = function() {
        if(this.programs[this.uiDate] == undefined) {
            $.ajax({
                dataType: "jsonp",
                context: this,
                url: this.apiUrlPrograms,
                data: {date: this.dates[this.uiDate], channel: this.channels[this.curChannel].id},
                success: function(data) {
                    this.programs[this.uiDate] = data.data;
                    this.serverTime.sTime = data.time;
                    this.serverTime.lTime = new Date().getTime();
                    
                    this.renderProgramList();
                }
            });
        } else {
            this.renderProgramList();
        }
        
    };
    
    /**
     * 计算服务器时间
     */
    this.getServerTime = function() {
        if(this.serverTime.sTime > 0) {
            return this.serverTime.sTime + (new Date().getTime() - this.serverTime.lTime) / 1000;
        } else {
            return 0;
        }
    }
    
    /**
     * 显示节目列表     
     */
    this.renderProgramList = function() {
        var items = [];
        var time = this.getServerTime();
        $.each(this.programs[this.uiDate], function(key, val) {
            /*
             如果没有设置live
                 获取live
                 设置live点定时更新
            */
            if(self.liveProgram.date == -1 && val.start <= time && time < val.end) {
                self.liveProgram.date = self.uiDate;
                self.liveProgram.program = key;
                self.setLiveTrack();
                
                var dVal = self.dates[self.liveProgram.date];
                var d = new Date(parseInt(dVal.substr(0, 4), 10), parseInt(dVal.substr(5, 2), 10)-1, parseInt(dVal.substr(8, 2), 10));
                $('#mssp_epg_channel_date').html(dVal.substr(0, 4) + '年'
                                               + dVal.substr(5, 2) + '月'
                                               + dVal.substr(8, 2) + '日 ' + weekdays[d.getDay()]);
                
            }
            
            var d = new Date(val.start * 1000);
            var t = (d.getHours() < 10 ? '0' + d.getHours() : d.getHours()) + ':' + (d.getMinutes() < 10 ? '0' + d.getMinutes() : d.getMinutes());
            var n = t + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + val.title;
            
            //设置可播放性
            //对于界面中的每个，如果开始时间小于服务器时间，设为可播放
            if(val.start <= time) {
                items.push('<li id="epg-program-' + key + '" class="active"><span>' + n + '</span></li>');
            } else {
                items.push('<li id="epg-program-' + key + '"><span>' + n + '</span></li>');
            }
            
        });
        
        $('<ul/>', {
            html: items.join('')
        }).appendTo('#mssp_epg_programs');
        
        $('#mssp_epg_programs').mCustomScrollbar();
        
        $('#mssp_epg_programs li.active').click(function(obj) {
            var id = $(this).attr('id').substr(12);
            self.playProgram(self.uiDate, parseInt(id));
        });
        
        //如果没有播放条目
        //  播放live
        if(this.curProgram == -1 && this.liveProgram.program >= 0) {
            this.playProgram(this.uiDate, this.liveProgram.program);
        } else {
            this.markPlaying();
        }
        
        this.markLive();
        
    }
    
    /**
     * 设置live点定时更新
     *   如果已设置，执行更新逻辑
     *       更新live点
     *           计算新live点
     *               更新正在播出：如果playDate = liveProgram.date && curProgram = old live，curProgram切换至新live
     *               调整可播放性：如果uiDate = liveProgram.date，将liveProgram.program对应的节目设为可播放
     *           markPlaying
     *           markLive
     *   设置下次定时更新(下一条目的开始时间)
     */
    this.setLiveTrack = function() {
        if(self.isLiveTrackActive) {
            self.isLiveTrackActive = false;
            
            if(self.liveProgram.program < self.programs[self.liveProgram.date].length - 1) {
                if(self.playDate == self.liveProgram.date && self.curProgram == self.liveProgram.program)
                    self.curProgram++;
                    
                self.liveProgram.program++;
                if(self.uiDate == self.liveProgram.date) {
                    $('#epg-program-' + self.liveProgram.program).addClass('active');
                    $('#epg-program-' + self.liveProgram.program).click(function(obj) {
                        var id = $(this).attr('id').substr(12);
                        self.playProgram(self.uiDate, parseInt(id));
                    });
                }
                
                self.markPlaying();
                self.markLive();
            }

        }
        
        if(self.liveProgram.program < self.programs[self.liveProgram.date].length - 1) {
            var t = self.programs[self.liveProgram.date][self.liveProgram.program + 1].start - self.getServerTime();
            this.liveTrackTimeout = setTimeout(self.setLiveTrack, t*1000);
            
            self.isLiveTrackActive = true;
        }
        
    }
    
    /**
     * 标记live点
     *   如果uiDate = liveProgram.date，高亮显示live点；
     */
    this.markLive = function() {
        if(this.liveProgram.program == -1)
            return;
        
        var p = this.programs[this.liveProgram.date][this.liveProgram.program];
        var d = new Date(p.start * 1000);
        var t = (d.getHours() < 10 ? '0' + d.getHours() : d.getHours()) + ':' + (d.getMinutes() < 10 ? '0' + d.getMinutes() : d.getMinutes());
        $('#mssp_epg_channel_live_info').html('正在直播：' + t + ' ' + p.title);
        
        if(this.uiDate != this.liveProgram.date)
            return;
        
        $('#mssp_epg_programs li.live').removeClass('live');
        $('#epg-program-' + this.liveProgram.program).addClass('live');
    }
    
    /**
     * 设置正在播出
     *   如果playDate == uiDate，高亮显示当前播放条目；
     */
    this.markPlaying = function() {
        if(this.uiDate != this.playDate || this.curProgram == -1)
            return;
        
        $('#mssp_epg_programs li.current').removeClass('current');
        $('#epg-program-' + this.curProgram).addClass('current');
    };
    
    /**
     * 播放节目(播放直播段时，从live开始)
     *  调用播放器
     *  更新界面: 更新[当前播出条目]
     */
    this.playProgram = function(d, p) {
        this.playDate = d;
        this.curProgram = p;
        
        //调用播放器
        if(this.stream == '') {
            var a = this.channels[this.curChannel].stream.split('/');
            this.stream = a[a.length - 2];
            //console.log(this.stream);
        }
        
        var pd = this.dates[this.playDate];
        var dvrUrl = this.channels[this.curChannel].stream.replace("/"+this.stream+"/", "/"+this.stream+"." + pd.replace(/-/g, "") + ".0/");
            
        var url;
		
		var start = Date.parse(new Date)-100;
		var end = start+600;
        if(this.playDate == this.liveProgram.date && this.curProgram == this.liveProgram.program) {
            url = dvrUrl + "?DVR&start=" + (this.programs[this.playDate][this.curProgram].start - 300) + '000';
        } else {
            url = dvrUrl + "?DVR&start=" + this.programs[this.playDate][this.curProgram].start + '000' + "&end=" + this.programs[this.playDate][this.curProgram].end + '000'
        }
        this.player.play(url);
        
        
        this.markPlaying();
    };
    
    /**
     * 播放下一个节目，通常在播放完成事件中调用
     *  播放直播段时，无论是live还是回看中，由于没有结束点，都不触发[播放完成]事件。这样也有利于直播的连续观看。
     *  播放录制段时，触发[播放完成]事件， 跳到下一段播放，如果是当天最后一个节目，提示当日节目已经完成。
     */
    this.playNext = function() {
        if(this.curProgram < this.programs[this.playDate].length - 1)
            this.playProgram(this.playDate, this.curProgram + 1);
    };
    
}

