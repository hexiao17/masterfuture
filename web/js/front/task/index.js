;
var task_index_ops = {
	init:function(){
		this.p = 1;
		
		this.eventBind();
		this.setTabIconHighLight();
	},
	eventBind:function(){
		var that = this;
		//定义需要加载的模块
		layui.define(['layer',  'element'], function(exports){
			  var $ = layui.jquery;
			  var layer = layui.layer; 
			  var element = layui.element;
		});	  
		//点击搜索框
		
		
		
		//点击自定义计数器，计数增加 ，ajax添加任务。
		$(".btn_user_counter").click(function(){	
			var that =  $(this);
			var data_id =that.attr('data_id');			 
			layer.prompt({title: '请记录详细内容', formType: 2}, function(content, index){					  
					  if(content.length < 2){
						  layer.msg("内容不能少于2个字符");
						  return;
					  }
					  layer.close(index);					  
					//配置一个透明的询问框
					  var statu=0;
					  layer.open({
						  type:1,
						  content:'完成了？', 
						  btn: ['完成', '没完成'] //可以无限个按钮						   
						 
					    ,yes:function(index, layero){
						  statu = 1;
						  layer.close(index);
						}
					    ,btn2: function(index){
							 
					    }
						,cancel: function(){ 
							    //右上角关闭回调							    
							    //return false 开启该代码可禁止点击该按钮关闭
						},end:function(){
							//不管什么情况都要处理
							var data = {
							    	content:content,data_id:data_id,statu:statu
							    };
							    //后台提交
							    $.ajax({
				                    url:common_ops.buildFrontUrl( "/usercounter/ajaxadd" ),
				                    type:'post',
				                    dataType:'json',
				                    data:data,
				                    success:function( res ){
				                         
				                        if( res.code != 200 ){
				                        	layer.msg('计数失败');
				                            return;
				                        }else{
				                        	 layer.msg('计数成功'); 
				                        	 var parentNode = that.parents('span'); 
				                        	 parentNode.html('<a class="btn_user_counter"  title="'+res.data.name+'"  data_id="'+res.data.id+'" >'+res.data.num+'<i class="layui-icon" style="font-size: 30px; color: #1E9FFF;">'+res.data.node_icon+'</i></a>');
				                        	 //为什么二次点击就失效了呢 ？？？
				                        }
				                         
				                    }
				                });
						}
						}); 
			});
		});
		//点击添加计数器按钮，ajax添加任务。
		$("#add_counter_index button").click(function(){		
			var type = $(this).attr('value');			 
			layer.prompt({
						title: '请按格式输入内容',
						formType: 2,
						 value: '名称|单位|符号(最好用首字母如WX)',
						}, function(content, index){
					   var arr = content.split("|");
					   if(arr.length!=3){
						   layer.msg("请按格式输入，名称|单位|符号");
							  return;
					   }
					  if(arr[0].length < 3){
						  layer.msg("名称不能少于3个字符");
						  return;
					  }
					  if(arr[1].length > 4){
						  layer.msg("单位不能大于4个字符");
						  return;
					  }
					  if(arr[2].length > 20){
						  layer.msg("符号不能大于20个字符");
						  return;
					  }
					  layer.close(index);			  
					   
						    var data = {
						    	name:arr[0],unit:arr[1],node_icon:arr[2],add_method:'ajax'
						    };
						    //后台提交
						    $.ajax({
			                    url:common_ops.buildFrontUrl( "/usercounter/set" ),
			                    type:'post',
			                    dataType:'json',
			                    data:data,
			                    success:function( res ){
			                         
			                        if( res.code != 200 ){
			                        	layer.msg('添加失败');
			                            return;
			                        }else{
			                        	//layer.msg('演示完毕！您的口令：'+ title +'<br>您最后写下了：'+content+'<br>任务类型:'+res.data['title']);
			                        	layer.msg('添加成功');
			                        	var html ='<a class="btn_user_counter"  title="'+res.data.name+'"  data_id="'+res.data.id+'" >'+res.data.num+'<i class="layui-icon" style="font-size: 30px; color: #1E9FFF;">'+res.data.node_icon+'</i></a>';
			                        	$('.counter_parent span').append(html);
			                        	//动态增加内容行
			                        	//window.location.href = common_ops.buildFrontUrl("/task/index"); 
			                        }
			                         
			                    }
			                });
				  
			});
		});
		
		//点击添加任务按钮，ajax添加任务。
		$("#add_task_index button").click(function(){		
			var type = $(this).attr('value');			 
			layer.prompt({title: '请输入任务标题', formType: 0}, function(title, index){					  
					  if(title.length < 3){
						  layer.msg("标题不能少于3个字符");
						  return;
					  }
					  layer.close(index);					  
					  layer.prompt({title: '请输入简单描述', formType: 2}, function(content, index){
						  if(content.length < 3){
							  layer.msg("描述不能少于3个字符");
							  return;
						  }
						  layer.close(index);
						    var data = {
						    	title:title,task_desc:content,task_group:type,addr_method:'index'
						    };
						    //后台提交
						    $.ajax({
			                    url:common_ops.buildFrontUrl( "/task/set" ),
			                    type:'post',
			                    dataType:'json',
			                    data:data,
			                    success:function( res ){
			                         
			                        if( res.code != 200 ){
			                        	layer.msg('添加失败');
			                            return;
			                        }else{
			                        	//layer.msg('演示完毕！您的口令：'+ title +'<br>您最后写下了：'+content+'<br>任务类型:'+res.data['title']);
			                        	layer.msg('任务添加成功');
			                        	
			                        	//动态增加内容行
			                        	window.location.href = common_ops.buildFrontUrl("/task/index"); 
			                        }
			                         
			                    }
			                });
					     
					  }); 
			});
		});
		//点击修改任务分组，ajax修改。
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
		//修改任务状态
		$(".ops_group_statu i").click(function(){		
			var btn_elem = $(this) ;
			var statu = btn_elem.attr('value');
			var dataid =btn_elem.parent().attr('data-id');
			var data = {
			    	dataid:dataid,statu:statu,act:'task_finish'
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
	 
		
		
	},
	//tab 高亮
	setTabIconHighLight:function(){
		var group_id =  $(".tab_select_group").attr("selectid");
		$(".group_"+group_id).addClass("layui-this"); 
	},
	search:function(){
		
	}
};
$(document).ready(function(){
	task_index_ops.init();
});


/** 
* 鼠标移到的颜色 
*/ 
$(".fly-list li").mouseover(function(){ 
	$(this).addClass("mouse_color"); 
	$(this).find(".ops_group_group").removeClass('disabled');
	$(this).find(".ops_group_statu").removeClass('disabled');
	
}); 

/** 
* 鼠标移出的颜色 
*/ 
$(".fly-list li").mouseout(function(){ 
	$(this).removeClass("mouse_color"); 
	$(this).find(".ops_group_group").addClass('disabled');
	$(this).find(".ops_group_statu").addClass('disabled');
}); 
