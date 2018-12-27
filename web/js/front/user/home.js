;
var task_user_home = {
	init:function(){
		 
		this.eventBind();
		 
	},
	eventBind:function(){
		var that = this;
		//定义需要加载的模块
		layui.define(['layer',  'element'], function(exports){
			  var $ = layui.jquery;
			  var layer = layui.layer; 
			  var element = layui.element;
		});	  
		 
		//不知道为什么必须有个绑定的事件，不然加载异常
		$(".ops_group_group button").click(function(){	
			var btn_elem = $(this);
			var type = btn_elem.attr('value');
			var dataid = btn_elem.parent().attr('data-id');
			var data = {
			    	dataid:dataid,group:type,act:'edit_type'
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
                    	btn_elem.parents('li').remove();
                    	layer.msg('修改成功');
                    	window.location.href = common_ops.buildFrontUrl("/task/index");  
                        return;
                    }
                     
                }
            });
		}); 
		 
	 
		
		
	},
	 
};
$(document).ready(function(){
	task_user_home.init();
});

 