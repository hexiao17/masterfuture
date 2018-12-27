;

var member_set_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){

        $(".wrap_member_set .save").click( function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                common_ops.alert("正在处理!!请不要重复提交~~");
                return;
            }

            var nickname_target = $(".wrap_member_set input[name=nickname]");
            var nickname = nickname_target.val();
            var mobile_target = $(".wrap_member_set input[name=mobile]");
            var mobile = mobile_target.val();
          
            var expired_time_target = $(".wrap_member_set input[name=expired_time]");
            var expired_time = expired_time_target.val();
            var beizhu_target = $(".wrap_member_set input[name=beizhu]");
            var beizhu = beizhu_target.val();
            
           
            var valid_date =common_ops.checkDate(expired_time);
            if(!valid_date){
            	common_ops.tip( "请输入正确的过期日期~~" ,expired_time_target );
                return;
            }            
            
            if( nickname.length < 1 ){
                common_ops.tip( "请输入符合规范的姓名~~" ,nickname_target );
                return;
            }

            if( mobile.length < 1 ){
                common_ops.tip("请输入符合规范的手机号码~~",mobile_target);
                return;
            }
            if( beizhu.length < 1 ){
                common_ops.tip("请输入备注信息，便于审计~~",beizhu_target);
                return;
            }
            
            
            btn_target.addClass("disabled");

            var data = {
                nickname:nickname,
                mobile:mobile,
                id:$(".wrap_member_set input[name=id]").val(),               
                expired_time:expired_time,
                beizhu:beizhu
            };

            $.ajax({
                url:common_ops.buildAdminUrl("/member/set") ,
                type:'POST',
                data:data,
                dataType:'json',
                success:function(res){
                    btn_target.removeClass("disabled");
                    var callback = null;
                    if( res.code == 200 ){
                        callback = function(){
                            window.location.href = common_ops.buildAdminUrl("/member/index");
                        }
                    }
                    common_ops.alert( res.msg,callback );
                }
            });
        });
    }
};

$(document).ready( function(){
    member_set_ops.init();
});