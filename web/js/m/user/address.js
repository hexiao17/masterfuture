;

var user_address_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
        $(".del").click(function () {
            $(this).parent().parent().remove();

            $.ajax({
                url:common_ops.buildWebUrl("/user/address_ops"),
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

        $(".set_default").click(function () {
            $.ajax({
                url:common_ops.buildWebUrl("/user/address_ops"),
                type:'POST',
                data:{
                    id:$(this).attr("data"),
                    act:'set_default'
                },
                dataType:'json',
                success:function( res ){
                    alert( res.msg );
                    if( res.code == 200 ){
                        window.location.href = common_ops.buildWebUrl("/product/index");
                    }
                }
            });
        });
    }
};



$(document).ready( function(){
    user_address_ops.init();
});