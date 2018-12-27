;
var user_fav_list = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $(".fav_list li .del_fav").click(function () {
            $(this).parent().remove();
            
            var fav_type = $(this).attr("xtype");
            var toUrl;
            if(fav_type == 'st'){
            	toUrl = common_ops.buildWebUrl("/stnews/fav");
            }else{
            	toUrl = common_ops.buildWebUrl("/zbnews/fav");
            }
            
            $.ajax({
                url:toUrl,
                type:'POST',
                data:{
                    id:$(this).attr("data"),
                    act:'del'
                },
                dataType:'json',
                success:function( res ){
                }
            });
        });
    }
};
$(document).ready( function(){
    user_fav_list.init();
} );
