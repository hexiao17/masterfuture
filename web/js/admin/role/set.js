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

            var role_name_target = $(".wrap_member_set input[name=name]");
            var role_name = role_name_target.val();
            var role_level_target = $(".wrap_member_set input[name=pos]");
            var role_level = role_level_target.val();
            
            var valid_days_target=  $(".wrap_member_set input[name=valid_days]");
            var valid_days = valid_days_target.val();
           
            var cate_target=  $(".wrap_member_set select[name=cate]");
            var cate = cate_target.val();
            
            if(valid_days < 1 || valid_days >3650){
            	
            	 common_ops.tip( "请输入符合规范的有效期[大于1并且小于3650]~~" ,valid_days_target );
                 return;
            }
            
            if( role_name.length < 1 ){
                common_ops.tip( "请输入符合规范的角色名~~" ,role_name_target );
                return;
            }

            if( role_level < 1 ){
                common_ops.tip("请输入符合规范的角色等级~~",role_level_target);
                return;
            }
            if(cate < 1){
            	common_ops.tip("请选择合适的角色分类~~",cate_target);
                return;
            }
           
            
            btn_target.addClass("disabled");

            var data = {
                name:role_name,
                pos:role_level,             
                valid_days:valid_days,
                cate:cate,
                id:$(".wrap_member_set input[name=id]").val()
            };

            $.ajax({
                url:common_ops.buildAdminUrl("/role/set") ,
                type:'POST',
                data:data,
                dataType:'json',
                success:function(res){
                    btn_target.removeClass("disabled");
                    var callback = null;
                    if( res.code == 200 ){
                        callback = function(){
                            window.location.href = common_ops.buildAdminUrl("/role/index");
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