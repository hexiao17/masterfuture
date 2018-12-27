;
var upload = {
    error:function(msg){
        $.alert(msg);
    },
    success:function(file_key,type){
        if(!file_key){
            return;
        }
        var html = '<img src="'+common_ops.buildPicUrl("book",file_key)+'"/>'
            +'<span class="fa fa-times-circle del del_image" data="'+file_key+'"></span>';

        if( $(".upload_pic_wrap .pic-each").size() > 0 ){
            $(".upload_pic_wrap .pic-each").html( html );
        }else{
            $(".upload_pic_wrap").append('<span class="pic-each">'+ html + '</span>');
        }
        book_set_ops.delete_img();
    }
};

var book_set_ops = {
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
             
             
             var zb_count_target= $(".wrap_book_set input[name=zb_count]");
             var zb_count = zb_count_target.val();
             var st_count_target= $(".wrap_book_set input[name=st_count]");
             var st_count = st_count_target.val(); 
             
            if( mobile_list.length < 11 ){
                common_ops.alert( "必须选择一个会员~~" );
                return;
            }            

            if( zb_count < 1 &&  st_count <1 ){
                common_ops.tip( "至少得更新一条吧~~",zb_count_target  );
                return;
            }

            
            btn_target.addClass("disabled");

            var data = {
                 mobile_list:mobile_list,
                 st_count:st_count,
                 zb_count:zb_count,
                channel:$(".wrap_book_set input[name=channel]").val(),
                id:$(".wrap_book_set input[name=id]").val()
            };

            $.ajax({
                url:common_ops.buildAdminUrl("/notice/set_wx") ,
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
    book_set_ops.init();
} );