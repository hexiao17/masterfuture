;
var product_info_ops = {
    init:function(){
        this.eventBind();
        this.updateViewCount();
    },
    eventBind:function(){
    	//点击收藏
        $(".fav").click( function(){

            if( $(this).hasClass("has_faved") ){
                return false;
            }

            $.ajax({
                url:common_ops.buildWebUrl("/stnews/fav"),
                type:'POST',
                data:{
                    id:$(this).attr("data"),
                    act:'set'
                },
                dataType:'json',
                success:function( res ){
                    if( res.code == -302 ){
                        common_ops.notlogin( );
                        return;
                    }
                    alert( res.msg );
                }
            });
        });

    },
    //更新查看
    updateViewCount:function(){
        $.ajax({
            url:common_ops.buildWebUrl("/stnews/ops"),
            type:'POST',
            data:{
                act:'view_count',
                book_id:$(".pro_fixed input[name=id]").val()
            },
            dataType:'json',
            success:function( res ){
            	 
            }
        });
    }
};

$(document).ready( function(){
    product_info_ops.init();
});