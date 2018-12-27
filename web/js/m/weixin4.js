;
var weixin_jssdk_ops = {
    init:function(){
        this.initJSconfig();
    },
    initJSconfig:function(){
        var that = this;
        $.ajax({
            url:'/weixin/jssdk/index?url='+encodeURIComponent(location.href.split('#')[0]),
            type:'GET',
            dataType:'json',
            success:function( res ){
                if( res.code != 200 ){
                    return ;
                }
                var data = res.data;
                wx.config({
                    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
                    appId: data['appId'], // 必填，公众号的唯一标识
                    timestamp: data['timestamp'], // 必填，生成签名的时间戳
                    nonceStr: data['nonceStr'], // 必填，生成签名的随机串
                    signature: data['signature'],// 必填，签名，见附录1
                    jsApiList: [ 'onMenuShareTimeline','onMenuShareAppMessage' ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
                });
                //通过ready接口处理成功验证	
                // config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
                wx.ready(function(){
                    var share_info =  eval( '(' + $("#share_info").val() + ")" );
                	var shareData = {
              			  title:  share_info.title,
              			  desc: share_info.desc,//这里请特别注意是要去除html
              			  link: encodeURIComponent(  location.href.split('#')[0] ),
              			  imgUrl: share_info.img_url
              		 };                	
                    wx.onMenuShareTimeline(shareData);
                    wx.onMenuShareAppMessage(shareData);
                });
                // config信息验证失败会执行error函数，如签名过期导致验证失败，
                wx.error(function(res){
                	alert(JSON.stringify(res));
                    //alert("连接失败！");	
                });
            }
        });
    },
    wxPay:function(json_data){
        wx.ready(function(){
            wx.chooseWXPay(json_data);
        });
    },
    sharedSuccess:function(){
        $.ajax({
            url:common_ops.buildMUrl("/default/shared"),
            type:'POST',
            dataType:'json',
            data:{
                url:window.location.href
            }
        });
    }
};

$(document).ready(function(){
    weixin_jssdk_ops.init();
});
