;
var front_summary_index = {
	init:function(){
		 
		this.eventBind();
		 
	},
	eventBind:function(){
		var that = this;
		//定义需要加载的模块
		layui.define(['form','laydate' ], function(exports){
			  var $ = layui.jquery; 
			  var form = layui.form;
			  var laydate = layui.laydate;
			//日期范围
			  laydate.render({
			    elem: '#test6'
			    ,range: true
			  });
		});
		 
		 
		//不知道为什么必须有个绑定的事件，不然加载异常
		$(".summary_index_from .save").click(function(){	
			var btn_elem = $(this);
			
			var dateStr = $(".summary_index_from input[name=summary_str]").val();		 
			var data = {
			    	dateStr:dateStr
			    };
			//后台提交
		    $.ajax({
                url:common_ops.buildFrontUrl( "/summary/set" ),
                type:'post',
                dataType:'json',
                data:data,
                success:function( res ){
                     
                    if( res.code != 200 ){
                    	layer.msg(res.msg);
                        return;
                    }else{                	 
                    	
                    	layer.msg('生产成功');
                    	window.location.href = common_ops.buildFrontUrl("/summary/index");  
                        return;
                    }
                     
                }
            });
		}); 
		 
	 
		
		
	},
	 
};
$(document).ready(function(){
	front_summary_index.init();
});

 