;
var task_user_index = {
	init:function(){
		 
		this.eventBind();
		 
	},
	eventBind:function(){
		 
		 
		//不知道为什么必须有个绑定的事件，不然加载异常
		$(".user_fav_unfav").click(function(){	
			var btn_elem = $(this);
			 
			var dataid = btn_elem.parent().attr('data');
			var data = {
			    	favid:dataid,act:'unfav'
			    };
			//后台提交
		    $.ajax({
                url:common_ops.buildFrontUrl( "/fav/ops" ),
                type:'post',
                dataType:'json',
                data:data,
                success:function( res ){
                     
                    if( res.code != 200 ){
                    	layer.msg(res.msg);
                        return;
                    }else{                    	 
                    	btn_elem.parents('li').remove();
                    	layer.msg('删除成功');
                    	//window.location.href = common_ops.buildFrontUrl("/task/index");  
                        return;
                    }
                     
                }
            });
		});  
	},
	 
};
$(document).ready(function(){
	task_user_index.init();
});

 