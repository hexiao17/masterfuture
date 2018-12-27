;
var inventory_set_ops = {
    init:function(){
        this.ue = null;
        this.eventBind();
        
    },
    eventBind:function(){
        var that = this;
      //按需加载模块模块
		layui.define(['form','laydate','layedit'], function(exports){
			  var $ = layui.jquery; 
			  var form = layui.form;
			  var timePicker = layui.timePicker;
			   laydate = layui.laydate; 
			   layedit = layui.layedit;
			   
			 //构建一个默认的编辑器
			 task_desc_target = layedit.build('LAY_demo1',{
				 	//配置上传路径
				 	uploadImage:{url:'./uploadImage',type:'post'}
			 });
			   
		});
        //添加计划
		$(".wrap_book_set select[name=plan]").change(function(){
			if($(".wrap_book_set select[name=plan]").val() ==-1){
				window.location.href = common_ops.buildAdminUrl("/plans/set");
			} 
		});
		//添加收货地点
		$(".wrap_book_set select[name=inventory_addr]").change(function(){
			if($(".wrap_book_set select[name=inventory_addr]").val() ==-1){
				window.location.href = common_ops.buildAdminUrl("/addr/set");
			} 
		});
		//提交
        $(".wrap_book_set .save").click( function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                common_ops.alert("正在处理!!请不要重复提交~~");
                return;
            }
 
            var plan_target = $(".wrap_book_set select[name=plan]");
            var plan = $.trim(plan_target.val());
            var updateNum_target = $(".wrap_book_set input[name=updateNum]");
            var updateNum = $.trim(updateNum_target.val());            
            var inventory_addr_target = $(".wrap_book_set select[name=inventory_addr]");
            var inventory_addr = $.trim(inventory_addr_target.val());
            
            var receiver_target = $(".wrap_book_set input[name=receiver]");
            var receiver = $.trim(receiver_target.val());            
            var receive_time_target = $(".wrap_book_set input[name=receive_time]");
            var receive_time = $.trim(receive_time_target.val());
          
            var beizhu_target = $(".wrap_book_set input[name=beizhu]");
            var beizhu = $.trim(beizhu_target.val());
             
           
//            if( title.length < 1 ){
//                common_ops.alert( "请输入符合规范的新闻名称~~" );
//                return;
//            }
//
//            if( pub_company.length < 1 ){
//                common_ops.tip( "请输入符合规范的新闻发布单位~~" ,pub_company_target );
//                return;
//            }            
//
//            if( content.length < 10 ){
//                common_ops.alert( "请输入新闻描述，并不能少于10个字符~~"  );
//                return;
//            }
//
//            if( expired_time.length < 10 ){
//                common_ops.alert( "请输入过期时间，并不能少于10个字符~~"  );
//                return;
//            }
//            if( pub_time.length < 8 ){
//                common_ops.alert( "请输入发布时间，并不能少于8个字符~~"  );
//                return;
//            }
//            if( tags.length < 1 ){
//                common_ops.alert( "请输入新闻标签，便于搜索~~" );
//                return;
//            }

            btn_target.addClass("disabled");

            var data = { 
            		plan:plan,
            		updateNum:updateNum,              
            		inventory_addr:inventory_addr,
            		receiver:receiver,
            		receive_time:receive_time, 
            		beizhu:beizhu 
            };

            $.ajax({
                url:common_ops.buildAdminUrl("/inventory/set") ,
                type:'POST',
                data:data,
                dataType:'json',
                success:function(res){
                    btn_target.removeClass("disabled");
                    var callback = null;
                    if( res.code == 200 ){
                        callback = function(){
                            window.location.href = common_ops.buildAdminUrl("/inventory/index");
                        }
                    }
                    common_ops.alert( res.msg,callback );
                }
            });

        });

    },
   
     
};

$(document).ready( function(){
	inventory_set_ops.init();
} );