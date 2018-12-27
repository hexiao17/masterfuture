;
var web_user_index = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){
    	//do_invitate
        $(".fastway_list li .do_invitate").click(function () {            
            var toUrl=common_ops.buildWebUrl("/user/invitate");            
            $.ajax({
                url:toUrl,
                type:'POST',
                data:{ 
                    act:'do'
                },
                dataType:'json',
                success:function( res ){
                	//已经创建的不弹出
                     if(res.code!= 2000){
                    	 common_ops.alert(res.msg);                    	 
                     }                   
                     if( res.code != 200 && res.code != 2000 ){                        
                         return;
                     }
                     window.location.href = res.data.url ;
                }
            });
        });
    }
};
$(document).ready( function(){
	web_user_index.init();
} );
