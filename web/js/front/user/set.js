;
var task_user_set = {
	init:function(){
		 
		this.eventBind();
		 
	},
	eventBind:function(){
		var that = this;
		//定义需要加载的模块
		layui.define(['form','layer',  'element'], function(exports){
			  var $ = layui.jquery;
			  var form = layui.form;
			  var layer = layui.layer; 
			  var element = layui.element;
		});	  
		
		//修改我的资料 
		$(".front_user_set_ops button").click(function(){	
			var btn_elem = $(this);
			
			var email_target = $(".front_user_set_ops input[name=email]");
			var email = email_target.val();
			var nickname_target = $(".front_user_set_ops input[name=nickname]");
			var nickname = nickname_target.val();
			 
			var personal_target = $(".front_user_set_ops textarea[name=personal]");
			var personal = personal_target.val(); 
			//取得radio
		    var radio=document.getElementsByName("sex");
            var radioselectvalue=null;   //  selectvalue为radio中选中的值
           for(i=0;i<radio.length;i++){
                  if(radio[i].checked==true) {
                	  radioselectvalue=radio[i].value;
                      break;
                 }
          }			
			//js校验
           if(!validate.checkEmail(email)){
               common_ops.tip( "请输入正确的邮箱",email_target); 
               return;
           } 
           if(!validate.chkContentLen(nickname,20,5)){
               common_ops.tip( "请输入符合长度的昵称（5-20个字符）~" ,nickname_target);
               return;
           }   
          
           //
			var data = {
			    	email:email,nickname:nickname,sex:radioselectvalue,personal:personal,method:'edit_user'
			    };
			//后台提交
		    $.ajax({
                url:common_ops.buildFrontUrl( "/user/set" ),
                type:'post',
                dataType:'json',
                data:data,
                success:function( res ){
                     
                    if( res.code != 200 ){
                    	layer.msg(res.msg);
                        return;
                    }else{                    	 
                    	btn_elem.parents('li').remove();
                    	layer.msg('修改成功');
                    	window.location.href = common_ops.buildFrontUrl("/user/set");  
                        return;
                    }
                     
                }
            });
		}); 
		
		//修改我的密码 
		$(".front_user_set_pass button").click(function(){	
			var btn_elem = $(this);
			
			var nowpass_target = $(".front_user_set_pass input[name=nowpass]");
			var nowpass = nowpass_target.val();
			var pass_target = $(".front_user_set_pass input[name=pass]");
			var pass = pass_target.val();
			 
			var repass_target = $(".front_user_set_pass input[name=repass]");
			var repass = repass_target.val(); 
		 
			//js校验
			if(!validate.checkPwdStrong(pass)){
	               common_ops.tip( "密码必须为字符和数字的组合~" ,pass_target);
	               return;
	         } 
           
           //
			var data = {
					nowpass:nowpass,pass:pass,repass:repass,method:'edit_pass'
			    };
		
			//后台提交
		    $.ajax({
                url:common_ops.buildFrontUrl( "/user/set" ),
                type:'post',
                dataType:'json',
                data:data,
                success:function( res ){
                     
                    if( res.code != 200 ){
                    	layer.msg(res.msg);
                        return;
                    }else{                    	 
                    	btn_elem.parents('li').remove();
                    	layer.msg('修改成功');
                    	window.location.href = common_ops.buildFrontUrl("/user/set");  
                        return;
                    }
                     
                }
            });
		}); 
		
		  
	},
	 
};
$(document).ready(function(){
	task_user_set.init();
});
layui.config({
    base: '/plugins/cropper/' //layui自定义layui组件目录
}).use(['form','croppers'], function () {
    var $ = layui.jquery
        ,form = layui.form
        ,croppers = layui.croppers
        ,layer= layui.layer;

    //创建一个头像上传组件
    croppers.render({
        elem: '#editimg'
        ,saveW:150     //保存宽度
        ,saveH:150
        ,mark:1/1    //选取比例
        ,area:'900px'  //弹窗宽度
        ,url: "/admin/upload/pic"  //图片上传接口返回和（layui 的upload 模块）返回的JOSN一样
        ,done: function(url){ //上传完毕回调
            $("#inputimgurl").val(url);
            $("#srcimgurl").attr('src',url);
        }
    });

});
 
 