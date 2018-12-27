;
var pay_buy_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
    	//点击微信支付
        $(".do_pay").click( function() {
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                alert( "正在提交，请不要重复提交~~" );
                return ;
            }
            btn_target.addClass("disabled");
            $.ajax({
                url:common_ops.buildWebUrl("/pay/prepare"),
                type:'POST',
                data:{
                    pay_order_id:$(".hide_wrap input[name=pay_order_id]").val()
                },
                dataType:'json',
                success:function( res ){

                    if( res.code == 200 ){
                        var data = res.data;
                        var json_data = {
                            timestamp: data.timeStamp,
                            nonceStr: data.nonceStr, //支付随机字符串
                            package: data.package,// 统一支付接口返回的prepay_id值
                            signType: data.signType, //签名方式
                            paySign: data.paySign, //支付签名
                            success: function () {
                                window.location.href = common_ops.buildWebUrl("/user/index");
                            },
                            cancel: function(){
                                alert("取消了支付~~");
                                btn_target.removeClass("disabled");
                            },
                            fail: function(){
                                alert("支付失败~~");
                                btn_target.removeClass("disabled");
                            }
                        };
                        //调用微信支付的接口
                        weixin_jssdk_ops.wxPay(json_data);
                    }else{
                        btn_target.removeClass("disabled");
                        alert(res.msg);
                    }
                }
            });
        });
    }
};

$(document).ready( function(){
    pay_buy_ops.init();
});