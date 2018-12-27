;
var task_user_home = {
	init:function(){
		 
		this.eventBind();
		 
	},
	eventBind:function(){
		var that = this;
		//定义需要加载的模块
//		layui.define(['layer',  'element'], function(exports){
//			  var $ = layui.jquery;
//			  var layer = layui.layer; 
//			  var element = layui.element;
//		});	  
		 
		 
		
		
	},
	 
};
$(document).ready(function(){
	task_user_home.init();
});
 
//layui.config({
//	  base: '/plugins/dtree_v2.4.5/layui_ext/dtree/' //配置 layui 第三方扩展组件存放的基础目录
//	}).extend({
//	  dtree: 'dtree' //定义该组件模块名
//	}).use(['element','layer', 'dtree'], function(){
//		var layer = layui.layer,
//		    dtree = layui.dtree,
//		    $ = layui.$;
//			
//		dtree.render({
//			  elem: "#demoTree1",  //绑定元素
//			  url: "/plugins/dtree_v2.4.5/layui_exts/orgCharts/demo/data/data.json"  //异步接口
//			});
//
//});


layui.extend({
	  dtree: '/plugins/dtree_v2.4.5/layui_ext/dtree/dtree'
	}).use(['element','layer', 'dtree'], function(){
	  var element = layui.element, layer = layui.layer, dtree = layui.dtree, $ = layui.$;
 
	  
//	  var DTree1 = dtree.render({
//		  elem: "#toolbarTree1",
//		  url: "/front/user/catejson",
//		  dot:false,
//		  toolbar:true,
//		  toolbarScroll:"#toolbarDiv", //划重点，必须配置，属性含义请参考文档
//		  toolbarLoad: "node",  // 表示工具栏加载的节点，  可选的值还有：noleaf（非最后一级）,leaf（最后一级节点）
//		  toolbarFun: {
//		    addTreeNode: function(treeNode){
//		      // 这里可以发送ajax请求，来获取参数值，最后将参数值必须符合树response中定义的参数规范
//		      $.ajax({
//		         // ajax基本参数
//		         success: function(result){
//		           var param = result.data;
//		           DTree1.changeTreeNodeAdd(param); // 配套使用,添加成功后使用
//		         },
//		         error: function(){
//		           DTree1.changeTreeNodeAdd(false); // 配套使用,失败使用
//		         }
//		      }) //示例发送ajax请求获取参数
//		    },
//		    editTreeNode: function(treeNode){
//		      DTree1.changeTreeNodeEdit(true/false); // 配套使用,同上
//		    },
//		    delTreeNode: function(treeNode){
//		      DTree1.changeTreeNodeDel(true/false); // 配套使用,同上
//		    }
//		  }
//		});

	  

	  dtree.render({
	    elem: "#toolbarTree1",
	    url: "/front/user/catejson",
	    initLevel: 1,
	    menubar:true,
	    checkbar: true,  
	    menubarFun: {
	      remove: function(checkbarNodes){ // 必须将该方法实现了，节点才会真正的从后台删除哦
	        return true;
	      }
	    }
	  });
	  dtree.on("node('toolbarTree1')", function(data){
	    layer.msg(JSON.stringify(data.param));
	  });
	  
	});