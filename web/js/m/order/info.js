;
//图片上传
upload={
		error:function(msg){
			common_ops.alert(msg);
		},
		success:function(image_key){
			 // var html = ' <img src="' + common_ops.buildPicUrl("equipment",image_key) + '"><span class="fa fa-times-circle del del_image" data="' + image_key +'"><i></i></span>';
			 
			  var html = '<li class="weui-uploader__file" style="background-image:url('+common_ops.buildPicUrl("equipment",image_key)+')"><span class="fa fa-times-circle del del_image" data="'+ image_key +'"><i class="weui-icon-cancel"></i></span></li> '
			  
			  //替换图片！！
			  if( $(".upload_pic_wrap .pic-each").size()> 0){
				  $(".upload_pic_wrap .pic-each").html( html );
			  }else{
				  $(".upload_pic_wrap").append('<ul class="weui-uploader__files pic-each" id="uploaderFiles">'+html+'</ul>');
			  }		
			  
			  m_order_info.delete_img();
		}
};
var m_order_info = {
	init:function(){ 
		this.eventBind(); 
	},
	eventBind:function(){
		var that = this;
		//提交
		$(".m_order_set .save").click(function(){
			var btn_target = $(this);
			if(btn_target.hasClass("disabled")){
				common_ops.alert("正在处理，请不要重复提交~~");
				return;
			}
			 
			
			var image_key = $(".m_order_set  .del_image").attr("data");
			
		 
		 
			var content_target = $(".m_order_set textarea[name=content]");
			var content = content_target.val();
			var user_list_target = $(".m_order_set input[name=user_list]");
			var user_list = user_list_target.val();
			 
			 
			 
			if(content.length < 1){
				common_ops.tip("请输入符合规范的公司描述",content_target);
				return;
			}
			if(user_list.length < 1){
				common_ops.tip("请输入维修人员",user_list_target);
				return;
			}
			btn_target.addClass("disabled");
			var data = {
					image_key:image_key, 
					content:content,
					user_list:user_list,
					id:btn_target.attr("data"),					
			};
			
			$.ajax({ 
				url:common_ops.buildMUrl('/order/info'),
				type:"post",
				data:data,
				dataType:'json', 
				success:function(res){
					btn_target.removeClass("disabled");
					 alert(res.msg);
	                    if( res.code != 200 ){
	                    	 alert(res.msg);
	                        return;
	                    }
	                    window.location.href = common_ops.buildMUrl('/order/info',{'id':res.data.id}); 
				}
				
			});
		});
		 
		
		//无刷新上传
		$(".order_file_form .weui-uploader__input-box input[name=pic]").change(function(){
			
			$(".order_file_form .upload_pic_wrap").submit();
		});
		
		 
	},
	//点击删除动作	
	delete_img:function(){
		$(".order_file_form .del_image").unbind().click(function(){
			$(this).parent().remove();
		});
	},
	 
};
$(document).ready(function(){
	m_order_info.init();
}); 

