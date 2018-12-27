;
var user_bind_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        var that = this;
        $(".front_user_reg .reg").click(function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                alert("正在处理!!请不要重复提交");
                return;
            }

            var mobile = $.trim($(".front_user_reg input[name=mobile]").val());
        
            var login_pwd = $.trim($(".front_user_reg input[name=login_pwd]").val());
            var repass = $.trim($(".front_user_reg input[name=repass]").val()); 
            var vercode = $.trim($(".front_user_reg input[name=vercode]").val());
            var captcha_code = $.trim($(".front_user_reg input[name=captcha_code]").val());

            if(!validate.checkMobilePhone(mobile)  ){
                alert("请输入符合要求的手机号码~~"+mobile);
                return ;
            }
           
            if(!validate.checkPwdStrong(login_pwd)  ){
            	alert("请输入符合要求的密码~~");
            	return ;
            }
            if( login_pwd != repass ){
            	alert("两次密码不一样~~");
            	return ;
            }

            if( vercode.length < 1){
                alert("请输入正确的图形校验码~~"+vercode);
                return;
            }

            if( captcha_code.length < 1){
                alert("请输入手机验证码~~");
                return;
            }

            btn_target.addClass("disabled");

            var data = {
                mobile:mobile,
              
                login_pwd:login_pwd,
                vercode:vercode,
                captcha_code:captcha_code,
                referer:$(".hide_wrap input[name=referer]").val()
            };

            $.ajax({
                url:common_ops.buildFrontUrl("/user/reg"),
                type:'POST',
                data:data,
                dataType:'json',
                success:function( res ){
                    btn_target.removeClass("disabled");
                    alert(res.msg);
                    if( res.code != 200 ){
                        $("#img_captcha").click();
                        return;
                    }
                    window.location.href = res.data.url ;
                }
            });

        });

        $(".front_user_reg .get_captcha").click(function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                alert("正在处理，请不要重复提交~~");
                return;
            }

            var mobile = $(".login_form_wrap input[name=mobile]").val();
            var img_captcha = $(".login_form_wrap input[name=img_captcha]").val();


            if( mobile.length < 1 ||  !/^[1-9]\d{10}$/.test( mobile ) ){
                alert("请输入符合要求的手机号码~~");
                return false;
            }

            if( img_captcha.length < 1){
                alert("请输入正确的图形校验码~~");
                return;
            }

            btn_target.addClass("disabled");

            $.ajax({
                url: common_ops.buildWwwUrl("/default/get_captcha"),
                type:'POST',
                data:{
                    'mobile':mobile,
                    'img_captcha':img_captcha,
                    'source':'wechat'
                },
                dataType:'json',
                success:function(res){
                    btn_target.removeClass("disabled");
                    //由于是验证，没有短信通道，直接告知验证码多少了
                    alert( res.msg );
                    if( res.code != 200 ){
                        $("#img_captcha").click();
                        return;
                    }
                }
            });
        });
    }
};

$(document).ready( function(){
    user_bind_ops.init();
});