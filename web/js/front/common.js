;

var common_ops = {
    init:function(){
        this.eventBind();
        this.setIconLight();
    },
    eventBind:function(){
    	//全局默认加载的
    	//注意：导航 依赖 element 模块，否则无法进行功能性操作 
		layui.define(['layer',  'element'], function(exports){
			  var $ = layui.jquery;
			  var layer = layui.layer; 
			  var element = layui.element;
		});	  
		 
    	
    	
    	
    },
    //设置底部按钮选中的状态
    setIconLight:function(){
        var pathname = window.location.pathname;
        var nav_name = null;

        if(  pathname.indexOf("/user/set") > -1 || pathname == "/web" || pathname == "/web/" ){
            nav_name = "nav_set";
        }

        if(  pathname.indexOf("/user/index") > -1  ){
            nav_name = "nav_index";
        }

        if(  pathname.indexOf("/user/message") > -1  ){
        	
            nav_name = "nav_message";
            
        }
        if(  pathname.indexOf("/summary/") > -1  ){
        	
            nav_name = "nav_summary";
            
        }
        if(  pathname.indexOf("/user/cate") > -1  ){
        	
            nav_name = "nav_cate";
            
        }
        if( nav_name == null ){
            return;
        }

        $(".user_left_nav ."+nav_name).addClass("layui-this");
    },
    buildFrontUrl:function( path ,params){
        var url =   "/front" + path;
        var _paramUrl = '';
        if( params ){
            _paramUrl = Object.keys(params).map(function(k) {
                return [encodeURIComponent(k), encodeURIComponent(params[k])].join("=");
            }).join('&');
            _paramUrl = "?"+_paramUrl;
        }
        return url + _paramUrl

    },
    buildWwwUrl:function( path ,params){
        var url =    path;
        var _paramUrl = '';
        if( params ){
            _paramUrl = Object.keys(params).map(function(k) {
                return [encodeURIComponent(k), encodeURIComponent(params[k])].join("=");
            }).join('&');
            _paramUrl = "?"+_paramUrl;
        }
        return url + _paramUrl

    },
    buildPicUrl:function( bucket,img_key ){
        var upload_config = eval( '(' + $(".hidden_layout_warp input[name=upload_config]").val() +')' );
        var domain = "http://" + window.location.hostname;
        return domain + upload_config[ bucket ] + "/" + img_key;
    },
    //没有登录
    notlogin:function( referer ){
        if ( ! referer) {
            //alert('授权过期,系统将引导您重新登录');
            referer = location.pathname + location.search;
        }
        window.location.href = this.buildFrontUrl("/user/login",{ referer:referer });
    },
    //使用layer封装的方法1（消息，回调函数）
    alert:function( msg ,cb ){
        layer.alert( msg,{
            yes:function( index ){
                if( typeof cb == "function" ){
                    cb();
                }
                layer.close( index );
            }
        });
    },
    //使用layer封装的方法2
    confirm:function( msg,callback ){
        callback = ( callback != undefined )?callback: { 'ok':null, 'cancel':null };
        layer.confirm( msg , {
            btn: ['确定','取消'] //按钮
        }, function( index ){
            //确定事件
            if( typeof callback.ok == "function" ){
                callback.ok();
            }
            layer.close( index );
        }, function( index ){
            //取消事件
            if( typeof callback.cancel == "function" ){
                callback.cancel();
            }
            layer.close( index );
        });
    },
    //使用layer封装的方法3（消息，目标JQuery对象）
    tip:function( msg,target ){
        layer.tips( msg, target, {
            tips: [ 3, '#e5004f']
        });
        $('html, body').animate({
            scrollTop: target.offset().top - 10
        }, 100);
    },
    
    //检查正确的日期
    checkDate:function(str){    	   
     var date = str;
     var result = date.match(/((^((1[8-9]\d{2})|([2-9]\d{3}))(-)(10|12|0?[13578])(-)(3[01]|[12][0-9]|0?[1-9])$)|(^((1[8-9]\d{2})|([2-9]\d{3}))(-)(11|0?[469])(-)(30|[12][0-9]|0?[1-9])$)|(^((1[8-9]\d{2})|([2-9]\d{3}))(-)(0?2)(-)(2[0-8]|1[0-9]|0?[1-9])$)|(^([2468][048]00)(-)(0?2)(-)(29)$)|(^([3579][26]00)(-)(0?2)(-)(29)$)|(^([1][89][0][48])(-)(0?2)(-)(29)$)|(^([2-9][0-9][0][48])(-)(0?2)(-)(29)$)|(^([1][89][2468][048])(-)(0?2)(-)(29)$)|(^([2-9][0-9][2468][048])(-)(0?2)(-)(29)$)|(^([1][89][13579][26])(-)(0?2)(-)(29)$)|(^([2-9][0-9][13579][26])(-)(0?2)(-)(29)$))/);
    	if(result!=null)
	    {
	    	//alert("请输入正确的日期格式");
	    	return true;
	    }else{
	    	return false;
	    }     
    } 
};

$(document).ready( function() {
    common_ops.init();
});


// 对Date的扩展，将 Date 转化为指定格式的String
// 月(M)、日(d)、小时(h)、分(m)、秒(s)、季度(q) 可以用 1-2 个占位符，
// 年(y)可以用 1-4 个占位符，毫秒(S)只能用 1 个占位符(是 1-3 位的数字)
// 例子：
// (new Date()).Format("yyyy-MM-dd hh:mm:ss.S") ==> 2006-07-02 08:09:04.423
// (new Date()).Format("yyyy-M-d h:m:s.S")      ==> 2006-7-2 8:9:4.18
Date.prototype.Format = function(fmt)
{ //author: meizz
    var o = {
        "M+" : this.getMonth()+1,                 //月份
        "d+" : this.getDate(),                    //日
        "h+" : this.getHours(),                   //小时
        "m+" : this.getMinutes(),                 //分
        "s+" : this.getSeconds(),                 //秒
        "q+" : Math.floor((this.getMonth()+3)/3), //季度
        "S"  : this.getMilliseconds()             //毫秒
    };
    if(/(y+)/.test(fmt))
        fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));
    for(var k in o)
        if(new RegExp("("+ k +")").test(fmt))
            fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));
    return fmt;
};