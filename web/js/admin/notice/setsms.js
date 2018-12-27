;
var sms_set_ops = {
    init:function(){
       
        this.eventBind();
        
    },
    eventBind:function(){
        var that = this;
        
        $("#selAll").click(function() {   
        	 
			// 这个代码完美
			$(".wrap_user_list input[name='member_name[]']").prop("checked", this.checked);
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
             var add_mobile_target= $(".wrap_book_set textarea[name=add_mobile]");
             var add_mobile = add_mobile_target.val();
             
             var template_id_target= $(".wrap_book_set select[name=template_id]");
             var template_id = template_id_target.val();
             
             var paramstr_target= $(".wrap_book_set textarea[name=paramstr]");
             var paramstr = paramstr_target.val(); 
              
            btn_target.addClass("disabled");

            var data = {
            	 add_mobile:add_mobile,
                 mobile_list:mobile_list,
                 template_id:template_id,
                 paramstr:paramstr,
            };

            $.ajax({
                url:common_ops.buildAdminUrl("/notice/set_sms") ,
                type:'POST',
                data:data,
                dataType:'json',
                success:function(res){
                    btn_target.removeClass("disabled");
                    var callback = null;
                    if( res.code == 200 ){
                        callback = function(){
                            window.location.href = common_ops.buildAdminUrl("/notice/index_sms");
                        }
                    }
                    common_ops.alert( res.msg,callback );
                }
            });

        });

    },
    
      
};

$(document).ready( function(){
    sms_set_ops.init();
} );