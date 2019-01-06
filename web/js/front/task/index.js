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
