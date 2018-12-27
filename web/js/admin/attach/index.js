;
var attach_index_ops = {
		init:function(){
			this.eventBind();
		},
		eventBind:function(){
			var that = this;
			//search 
			$(".search").click(function(){
				$(".wrap_search").submit();
			});
			//删除操作
			$(".remove").click(function(){			 
				that.ops("remove",$(this).attr("data"));
			});
			 $(".recover").click( function(){
		            that.ops( "recover",$(this).attr("data") )
		        });

		},
		//ops
		ops:function(act,uid){
			callback ={
				"ok":function(){
					$.ajax({
						url:common_ops.buildAdminUrl("/attach/ops"),
						type:'POST',
						data:{
							act:act,
							id:uid
						},
						dataType:'json',
						success:function(res){
							callback =null;
							if(res.code == 200){
								callback= function(){
									window.location.href=window.location.href;
								}								
							}
							//使用封装的alert
							common_ops.alert(res.msg,callback);
						}
					});
				},
				"cancel":function(){
					//取消就什么都不做
				}
			}
			common_ops.confirm((act=="remove")?"你确定删除吗？":"你确定恢复吗？",callback);
			
			
		}
};

$(document).ready(function(){
	attach_index_ops.init();
});