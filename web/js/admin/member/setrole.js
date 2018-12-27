;
var account_setrole_ops = {
		init:function(){
			this.eventBind();
		},
		eventBind:function(){
			$(".save").click(function(){
				//处理重复点击
				var btn_target = $(this);
				if(btn_target.hasClass("disabled")){
					common_ops.alert("正在处理，请不要重复点击~~");
					return false;
				}			
			
				 //将选中的角色id传递到后端
	            var role_ids = [];
	            $(".wrap_account_set input[name='role_ids[]']").each( function(){
	                if( $(this).prop("checked") ){
	                    role_ids.push( $(this).val() );
	                }
	            });
	           
				btn_target.addClass("disabled");
				var data = {
						role_ids:role_ids,
						id:$(".wrap_account_set input[name=id]").val()
				};
				
				$.ajax({
						url:common_ops.buildAdminUrl('/member/setrole'),
						type:'POST',
						data:data,
						dataType:'json',
						success:function(res){
							btn_target.removeClass("disabled");
							callback = null;
							if(res.code==200){
								callback = function(){
									window.location.href= common_ops.buildAdminUrl('/member/index');
								}
							}
							common_ops.alert(res.msg,callback);
						}
				});
				
				
			});
			
		}
}
$(document).ready(function(){
	account_setrole_ops.init();
});