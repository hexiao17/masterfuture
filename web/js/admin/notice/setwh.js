;
 

var notice_set_ops = {
    init:function(){
       
        this.eventBind();
        
    },
    eventBind:function(){
        var that = this;
        
        $("#selAll").click(function() {   
        	 
			// 这个代码完美
			$(".wrap_user_list input[name='member_name[]']").prop("checked", this.checked);
		});
        
        $("#add_btn").click(function(){
        	 
        	
        });
        
        $(".wrap_book_set .save").click( function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                common_ops.alert("正在处理!!请不要重复提交~~");
                return;
            }
            var arr=[];
            
             $(".wrap_user_list input[type=checkbox]:checked").each(function(){
            	 arr.push(this.value);
             });
             var mobile_list = JSON.stringify(arr);
             
             
             var str_first_target= $(".wrap_book_set input[name=str_first]");
             var str_first = str_first_target.val();
             var str_two_target= $(".wrap_book_set input[name=str_two]");
             var str_two = str_two_target.val(); 
             var str_three_target= $(".wrap_book_set input[name=str_three]");
             var str_three = str_three_target.val(); 
             var str_four_target= $(".wrap_book_set textarea[name=str_four]");
             var str_four = str_four_target.val(); 
             
            if( mobile_list.length < 11 ){
                common_ops.alert( "必须选择一个会员~~" );
                return;
            }            

            if( str_first.length < 1  ||  str_two.length <1 || str_three.length < 1 || str_four.length  <1  ){
                common_ops.tip( "每个内容都要填",str_first_target  );
                return;
            }

            
            btn_target.addClass("disabled");

            var data = {
                 mobile_list:mobile_list,
                 str_first:str_first,
                 str_two: str_two,
                 str_three: str_three,
                 str_four: str_four,                
                id:$(".wrap_book_set input[name=id]").val()
            };

            $.ajax({
                url:common_ops.buildAdminUrl("/notice/set_wh") ,
                type:'POST',
                data:data,
                dataType:'json',
                success:function(res){
                    btn_target.removeClass("disabled");
                    var callback = null;
                    if( res.code == 200 ){
                        callback = function(){
                            window.location.href = common_ops.buildAdminUrl("/notice/index_wx");
                        }
                    }
                    common_ops.alert( res.msg,callback );
                }
            });

        });

    },
    
      
};

$(document).ready( function(){
    notice_set_ops.init();
} );