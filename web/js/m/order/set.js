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
			  
			  m_order_set.delete_img();
		}
};
var m_order_set = {
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
			
			var mobile_target = $(".m_order_set input[name=mobile]");
			var mobile = mobile_target.val();
			var book_time_target = $(".m_order_set input[name=book_time]");
			var book_time = book_time_target.val();
			var content_target = $(".m_order_set textarea[name=content]");
			var content = content_target.val();
			var leader_target = $(".m_order_set input[name=leader]");
			var leader = leader_target.val();
			 
			 
			if(mobile.length < 1){
				common_ops.tip("请输入符合规范的手机号码",mobile_target);
				return;
			}
			if(book_time.length < 1){
				common_ops.tip("请输入符合规范的公司地址",book_time_target);
				return;
			}
			if(content.length < 1){
				common_ops.tip("请输入符合规范的公司描述",content_target);
				return;
			}
			if(leader.length < 1){
				common_ops.tip("请输入部门审批人",leader_target);
				return;
			}
			btn_target.addClass("disabled");
			var data = {
					image_key:image_key,
					mobile:mobile,
					book_time:book_time,
					content:content,
					leader:leader,
					id:btn_target.attr("data"),
					eid:btn_target.attr("edata"),
					fid:btn_target.attr("fdata")
			};
			
			$.ajax({ 
				url:common_ops.buildMUrl('/order/set'),
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
		
		//时间选择器		
		 $("#time3").datetimePicker({
		        times: function () {
		          return [
		            {
		              values: ['上午', '下午']
		            }
		          ];
		        },
		        value: '2018-12-12 上午',
		        onChange: function (picker, values, displayValues) {
		          console.log(values);
		        }
		      });
		 
		 //详细信息。m-equip-toclass
		//点击添加任务按钮，ajax添加任务。
			$("#m-equip-toclass").click(function(){	
				var id = $(this).attr('data');	
				window.location.href = common_ops.buildMUrl("/class/info",{'id':id}); 
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
	m_order_set.init();
}); 

