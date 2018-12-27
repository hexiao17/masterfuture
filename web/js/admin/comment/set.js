;
 
var comment_set_ops = {
    init:function(){
     
        this.eventBind();
     
    },
    eventBind:function(){
        var that = this;
  
        $(".wrap_book_set select[name=cat_id]").select2({
            language: "zh-CN",
            width:'100%'
        });

        $(".wrap_book_set .save").click( function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                common_ops.alert("正在处理!!请不要重复提交~~");
                return;
            }

            var book_target = $(".wrap_book_set select[name=book]");
            var book = book_target.val();

            var score_target = $(".wrap_book_set input[name=score]");
            var score = score_target.val(); 
           
            var content_target = $(".wrap_book_set textarea[name=content]");
            var content = content_target.val();
            
            if( parseInt( book) < 1 ){
                common_ops.tip( "请选择产品~~" ,book_target );
                return;
            }         
            if( parseInt( score ) < 1 || parseInt( score ) > 10 ){
                common_ops.tip( "请输入正确的评分~~" ,score_target );
                return;
            } 
            
            if( content.length < 5 ){
                common_ops.alert( "请输入产品描述，并不能少于5个字符~~"   );
                return;
            } 
            btn_target.addClass("disabled");

            var data = {
                book_id:book,
                score:score,                
                content:content, 
                id:$(".wrap_book_set input[name=id]").val()
            };

            $.ajax({
                url:common_ops.buildAdminUrl("/comment/set") ,
                type:'POST',
                data:data,
                dataType:'json',
                success:function(res){
                    btn_target.removeClass("disabled");
                    var callback = null;
                    if( res.code == 200 ){
                        callback = function(){
                            window.location.href = common_ops.buildAdminUrl("/comment/index");
                        }
                    }
                    common_ops.alert( res.msg,callback );
                }
            });

        });

    }
     
}
$(document).ready( function(){
    comment_set_ops.init();
} );