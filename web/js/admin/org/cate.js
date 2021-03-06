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
		 
		 
		
		
	},
	 
};
$(document).ready(function(){
	task_user_home.init();
});
layui.config({
	base: '/plugins/dtree_v2.4.5/layui_exts/' //配置 layui 第三方扩展组件存放的基础目录
}).extend({
	orgCharts: 'orgCharts/orgCharts'
}).use(['orgCharts', 'jquery'], function() {
	var orgCharts = new layui.orgCharts;
	var $ = layui.$;
	//初始化组件  
	orgCharts.init({
		id: "org_charts", //必填
		theme: '', //可选
		menu: ['edit', 'add', 'delete', 'cut', 'copy', 'absorbed'], //右键菜单项
		success: function() { //可选
			//console.log("初始化完成")
		},
		error: function(e) { //可选
			//console.log(e);
		},
		onClick: function(el, data) { //点击方法  el被点击的元素  data对应传入数据
			//console.log(data.id);
			alert('点击了' + data.name);
		},
		onAdd: function(data, tab) { //添加回调 data为点击的数据  tab为标记点,用于插入新数据
			var myData = new Object();
			myData.name = prompt("输入name", "新节点");
			myData.child = [];
			if(myData.name != null) {
				orgCharts.addNodes(myData, tab);
			}
		},
		onEdit: function(data) { //编辑回调 data为点击的数据  tab为标记点,用于插入新数据
			data.html = prompt("输入name", data.html);
			if(data.name != "") {
				orgCharts.draw(); //重新绘制
			}
		}
	});

	//加载方式1   
	/*
		orgCharts.drawByUrl({
		url: 'data/data.json', //必选  返回格式参考 data/data.json
		success: function() { //可选
			//console.log("绘制化完成");
		},
		error: function(e) { //可选
			//console.log('绘制失败');
		}
	});
	*/

	//加载方式2 

	$.ajax({      
		type: "get",
		url: "/plugins/dtree_v2.4.5/layui_exts/orgCharts/demo/data/data.json",
		dataType: "text",
		success: function(data) {
			var JSONData = JSON.parse(data);
			orgCharts.drawByData({
				data: JSONData.data, //必填json数据  格式请参照  data/data.json  中的data
				success: function() { //可选
					//console.log("绘制化完成");
				},
				error: function(e) { //可选
					//console.log('绘制失败');
				}
			});
		},
		error: function(msg) {}    
	});
	/*
	 * 设置主题  主题类型normal ,red ,green ,black ,gray
	 * 可自定义样式文件
	 * 类名格式如 
	 * node-my 节点样式
	 * vertical-line-my 竖线样式
	 * transverse-line-my 横线样式
	 * 详细参考my.style
	 * 该方法
	 */
	//Org.setTheme('gray');
	window.changeTheme = function(theme) {
		orgCharts.setTheme(theme);
	}
});