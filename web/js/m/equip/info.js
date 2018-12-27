;
var m_equip_info = {
	init:function(){ 
		this.eventBind(); 
	},
	eventBind:function(){
		var that = this;
	 
		 
		//操作按钮 
		 $(document).on("click", "#show-actions", function() {
			 var id = $(this).attr('data');	
		        $.actions({
		          title: "选择操作",
		          onClose: function() {
		            console.log("close");
		          },
		          actions: [
		            {
		              text: "故障维修",
		              className: "color-primary",
		              onClick: function() {
		            	  //ajax操作 
		                //$.alert("发布成功"+id);
		                
		              //后台提交
		            	  window.location.href = common_ops.buildMUrl("/order/set",{'eid':id,'fid':1});  
		            	 
		                
		              }
		            },
		            {
		              text: "设备回收",
		              className: "color-warning",
		              onClick: function() {
		                //$.alert("你选择了“编辑”");
		            	//后台提交
		            	  window.location.href = common_ops.buildMUrl("/order/set",{'eid':id,'fid':2});  
		              }
		            },
		            {
		              text: "设备报废",
		              className: 'color-danger',
		              onClick: function() {
		               // $.alert("你选择了“删除”");
		            	//后台提交
		            	  window.location.href = common_ops.buildMUrl("/order/set",{'eid':id,'fid':3});  
		              }
		            }
		          ]
		        });
		      });
		 
		 //详细信息。m-equip-toclass
		//点击添加任务按钮，ajax添加任务。
			$("#m-equip-toclass").click(function(){	
				var id = $(this).attr('data');	
				window.location.href = common_ops.buildMUrl("/class/info",{'id':id}); 
			});
		 
	},
	 
};
$(document).ready(function(){
	m_equip_info.init();
}); 

