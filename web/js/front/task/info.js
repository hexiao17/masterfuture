;
var task_info_ops = {
	init:function(){
		this.eventBind();
	},
	eventBind:function(){
		
		//按需加载模块模块
		layui.define(['layedit'], function(exports){
			  var $ = layui.jquery; 
			   layedit = layui.layedit;
 
			   
		}); 
		//点击快速编辑按钮
		$(".task_body_btn").click(function(){
			var btn_elem = $(this);
			var stat= btn_elem.attr('stat');
			
			if(stat==0){
				var task_body =  $(".task_body_ajax").html();
				 $(".task_body_ajax").html( "<textarea id='LAY_demo1'>"+task_body+"</textarea>"); 
					 //构建一个默认的编辑器
					 task_desc_target = layedit.build('LAY_demo1',{
						 	//配置上传路径
						 	uploadImage:{url:'./uploadImage',type:'post'}
			     }); 
					 btn_elem.attr('stat',1);
			}else{
				var desc = layedit.getContent(task_desc_target);
				//后台提交
			    $.ajax({
	                url:common_ops.buildFrontUrl( "/task/ajaxbody" ),
	                type:'post',
	                dataType:'json',
	                data:{id:btn_elem.attr('data'),desc:desc},
	                success:function( res ){
	                     
	                    if( res.code != 200 ){
	                    	layer.msg('修改失败');
	                        return;
	                    }else{ 
	                    	layer.msg('修改成功');
	                    	//window.location.href = common_ops.buildMUrl("/task/index"); 
	                        return;
	                    }
	                     
	                }
	            });			
			    $(".task_body_ajax").html(desc);
				btn_elem.attr('stat',0);
			}			
		});
		
		
		//删除
		$("#del_task").click(function(){		
			var btn_elem = $(this) ;			
			var dataid =btn_elem.parent().attr('data-id');
			var data = {
			    	dataid:dataid, act:'task_del'
			    };
			//后台提交
		    $.ajax({
                url:common_ops.buildFrontUrl( "/task/ops" ),
                type:'post',
                dataType:'json',
                data:data,
                success:function( res ){
                     
                    if( res.code != 200 ){
                    	layer.msg('修改失败');
                        return;
                    }else{
                    	//layer.msg('演示完毕！您的口令：'+ title +'<br>您最后写下了：'+content+'<br>任务类型:'+res.data['title']);
                    	 
                    	btn_elem.parents('li').remove();
                    	layer.msg('修改成功');
                    	window.location.href = common_ops.buildFrontUrl("/task/index"); 
                        return;
                    }
                     
                }
            });
		});
		
		//查看访问密码
		$('#getAccessPwd').click(function(){
			var data = {
					id:$(this).attr('data')
			};
			$.ajax({
				url:common_ops.buildFrontUrl('/share/getpwd'),
				type:'post',
				data:data,
				dataType:'json',
				success:function(res){ 
		          common_ops.alert( res.msg  );  
				}				
			});		
		});
		
		
		//一键分享
		$('#task_do_share').click(function(){
			var that = this;
			var type = 0;//0为默认，无密码;1为有密码
			var passwd = "";//密码			
			var act  = $(that).attr('act');
			
			if(act =='del'){
				var data={
						act:act,
						id:$(that).attr('data'),
						type:type,
						passwd:passwd
					};
				return	shareOne(data); 
			} 
			//弹窗部分，选择
			//询问框 
			layer.confirm('如何分享你的内容呢？', {
			  btn: ['无密码','设置密码'] //按钮
			}, function(){
				//无密码 
				var data={
					act:act,
					id:$(that).attr('data'),
					type:type,
					passwd:passwd
				};
				shareOne(data);
			}, function(){
			  //有密码
			   type  =1;			   
				layer.prompt({title: '输入访问口令，并确认', formType: 1}, function(pass, index){
				  layer.close(index);
				  layer.msg('请牢记你的访问口令:'+ pass );	 
					var data={
						act:act,
						id:$(that).attr('data'),
						type:type,
						passwd:pass
					};
					shareOne(data);
				}); 
			}); 
			
		}); 
	},
	
};

$(document).ready(function(){
	task_info_ops.init();
});

function shareOne(data){
	$.ajax({
		url:common_ops.buildFrontUrl('/share/one'),
		type:'post',
		data:data,
		dataType:'json',
		success:function(res){
			if(res.code==302){
				common_ops.notlogin();
				return;
			} 
		 var callback = null;
              
         if( res.code == 200 ){
               callback = function(){
                      
                window.location.href = common_ops.buildFrontUrl("/task/info",{id:data.id});
               }
          }	                   
          common_ops.alert( res.msg,callback );  
		}				
	});		
}