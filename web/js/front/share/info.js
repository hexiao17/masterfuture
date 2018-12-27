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
			   
//			 //构建一个默认的编辑器
//			 task_desc_target = layedit.build('reply_demo1',{
//				 	//配置上传路径
//				 	uploadImage:{url:'./uploadImage',type:'post'},
//				 	height:100
//			 });
			   
		});
		//收藏
		$('.share_fav_btn').click(function(){
			var that = this;
			$.ajax({
				url:common_ops.buildFrontUrl('/fav/ops'),
				type:'post',
				data:{
					dataid:$(that).attr('data'),
					act:'fav'
				},
				dataType:'json',
				success:function(res){
					if(res.code==302){
						common_ops.notlogin();
						return;
					} 
					if(res.code ==-1){
						common_ops.tip(res.msg,that);
						return;
					}
					if(res.code== 200){
						//common_ops.tip(res.msg,that);
						$(that).empty().append('<i class="iconfont icon-zan"></i><em>'+res.data.num+'</em>');
					}
					 
					 
				}				
			});		
		});
		
		//点赞
		$('.jieda-zan').click(function(){
			var that = this;
			$.ajax({
				url:common_ops.buildFrontUrl('/sharereply/ops'),
				type:'post',
				data:{
					id:$(that).attr('data'),
					act:'set_zan'
				},
				dataType:'json',
				success:function(res){
					if(res.code==302){
						common_ops.notlogin();
						return;
					} 
					// alert(res.msg); 
					 $(that).empty().append('<i class="iconfont icon-zan"></i><em>'+res.data.num+'</em>');
					 
				}				
			});		
		});
		
		//回复 填充
		$('.jieda-reply .reply').click(function(){
			
			var that = this;
			var nickname = $(that).attr('nickname');
			var aite = '@'+ nickname.replace(/\s/g,'');
			var floor = $(that).attr('floor');
			
			var reply = $("#reply_content");
			reply.focus();
			var val = reply.val();
		 
			if(val.indexOf(aite)!== -1)return;
			reply.val('回复#'+floor+'楼('+aite +')  '+ val);	
			//alert(reply.val());
			//layedit.sync(task_desc_target);
		});
		//采纳
		$('.jieda-accept').click(function(){
			var that = this;
			var id = $(that).attr('data')
			$.ajax({
				url:common_ops.buildFrontUrl('/sharereply/ops'),
				type:'post',
				data:{
					id:$(that).attr('data'),
					act:'isAccept'
				},
				dataType:'json',
				success:function(res){
					if(res.code==302){
						common_ops.notlogin();
						return;
					} 
					// alert(res.msg); 
					$('#detail_about_'+id).append('<i class="iconfont icon-caina" title="最佳答案"></i>');
					 
				}				
			});		
		});
		//回复post
		$('#reply_submit').click(function(){
			var that = this;
			var id = $('#share_id').val();
			var content = $('#reply_content').val();
			
			$.ajax({
				url:common_ops.buildFrontUrl('/sharereply/set'),
				type:'post',
				data:{
					id:id,
					content:content
				},
				dataType:'json',
				success:function( res ){
                    
                    if( res.code != 200 ){
                    	//layer.msg(res.msg);
                    	alert(res.msg);
                        return;
                    }else{
                    	callback=function(){
                    		window.location.href = common_ops.buildFrontUrl("/share/info",{uuid:res.data.id});
                    	} 
                    }
                    common_ops.alert( res.msg,callback );
                }		
			});	 
			
		});
		
	}
};

$(document).ready(function(){
	task_info_ops.init();
});