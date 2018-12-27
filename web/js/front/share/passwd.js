;
var task_set_ops = {
	init:function(){
		this.eventBind();
	},
	eventBind:function(){ 
		var that = this;
		//按需加载模块模块
		layui.define(['layedit'], function(exports){
			  var $ = layui.jquery; 
			   layedit = layui.layedit;
			   
//			 //构建一个默认的编辑器
//			 task_desc_target = layedit.build('reply_demo1',{
//				 	//配置上传路径
//				 	uploadImage:{url:'./uploadImage',type:'post'},
//				 	height:100
//			 });
			   
		});
		
 
		 $("#task_set_form .save").click( function(){
			 	 
	            var btn_target = $(this);
	            if( btn_target.hasClass("disabled") ){
	                common_ops.alert("正在处理!!请不要重复提交~~");
	                return;
	            }
	         
	            var passwd_target = $("#task_set_form input[name=passwd]");
	            var passwd = passwd_target.val();

	            var uuid_target = $("#task_set_form input[name=uuid]");
	            var uuid = uuid_target.val();
   
	           
	            if( uuid.length < 10 ){
	            	
	                common_ops.alert( "非法访问"+uuid,passwd_target); 
	                return;
	            }

	            if( passwd.length < 1 ){
	                common_ops.alert( "不正确的密码~" ,passwd_target);
	                return;
	            }      
	            btn_target.addClass("disabled");

	            var data = { 
	            	uuid:uuid,
	                passwd:passwd,	                
	            };

	            $.ajax({
	                url:common_ops.buildFrontUrl("/share/accesspwd") ,
	                type:'POST',
	                data:data,
	                dataType:'json',
	                success:function(res){
	                    btn_target.removeClass("disabled");
	                    var callback = null;
	                    if( res.code != 200 ){
	                    	//layer.msg(res.msg);
	                    	alert(res.msg);
	                        return;
	                    }else{
	                        callback = function(){
	                          
	                        	window.location.href = common_ops.buildFrontUrl("/share/accesspwd",{uuid:uuid});
	                        }
	                    }	                   
	                    common_ops.alert( res.msg,callback );
	                }
	            });

	        });
	 
	}
		
}


$(document).ready(function(){
	task_set_ops.init();
});


