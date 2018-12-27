;
var book_index_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
    	//按需加载模块模块
		layui.define(['form','laydate','layedit'], function(exports){
			  var $ = layui.jquery; 
			  
			 
		});
    	
        var that = this;
        $(".remove").click( function(){
            that.ops( "remove",$(this).attr("data") )
        });

        $(".recover").click( function(){
            that.ops( "recover",$(this).attr("data") )
        });

        $(".wrap_search .search").click( function(){
            $(".wrap_search").submit();
        });
    },
    ops:function( act,id ){
        var callback = {
            'ok':function(){
                $.ajax({
                    url:common_ops.buildAdminUrl("/plans/ops"),
                    type:'POST',
                    data:{
                        act:act,
                        id:id
                    },
                    dataType:'json',
                    success:function( res ){
                        var callback = null;
                        if( res.code == 200 ){
                            callback = function(){
                                window.location.href = window.location.href;
                            }
                        }
                        common_ops.alert( res.msg,callback );
                    }
                });
            },
            'cancel':null
        };
        common_ops.confirm( ( act=="remove" )?"确定删除？":"确定恢复？",callback );
    }
};

$(document).ready( function(){
    book_index_ops.init();
});

/** 
* 鼠标移到的颜色 
*/ 
$(".table tr").mouseover(function(){ 
	$(this).find("td").addClass("mouse_color"); 
}); 

/** 
* 鼠标移出的颜色 
*/ 
$(".table tr").mouseout(function(){ 
	$(this).find("td").removeClass("mouse_color"); 
}); 