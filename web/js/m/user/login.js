;
user_login_ops={
		init:function(){
			this.eventBind();
		},
		eventBind:function(){
			var that = this;
			//点击登录事件
			$(".m-user-login-btn .weui-btn").click(function(){
				var btn_target =$(this);
//				if(btn_target.hasClass("disabled")){
//					alert("正在处理！！请不要重复提交");
//					return;
//				}
				
				var mobile = $(".m-user-login-form input[name=mobile]").val();
				var img_captcha = $(".m-user-login-form input[name=img_captcha]").val();
				var login_pwd =  $(".m-user-login-form input[name=login_pwd]").val();
				
				if( mobile.length < 1 ||  !/^[1-9]\d{10}$/.test( mobile ) ){
	                alert("请输入符合要求的手机号码~~");
	                return false;
	            }

	            if( login_pwd.length < 3){
	                alert("请输入正确的密码~~");
	                return false;
	            }
	            if( img_captcha.length < 1){
	                alert("请输入正确的图形校验码~~");
	                return false;
	            }

	            //暂时禁用	
	          //  btn_target.addClass("disabled");
				
	            var data = {
	            		mobile:mobile,
	            		img_captcha:img_captcha,
	            		login_pwd:login_pwd,
	            		referer:$(".hide_wrap input[name=referer]").val()
	            };
	            
	            $.ajax({
	            	url:common_ops.buildMUrl("/user/login"),
	            	type:'POST',
	            	data:data,
	            	dataType:'json',
	            	success:function(res){
	            		btn_target.removeClass("disabled");
	            		alert(res.msg);
	            		if(res.code != 200){
	            			$("#img_captcha").click();
	            		}
	            		window.location.href = res.data.url;
	            	}
	            	
	            }); 
				
			});
				
			
			
		}	
		 
};
	
$(document).ready(function(){
	user_login_ops.init();
});