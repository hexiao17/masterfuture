;
var plans_set_ops = {
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
        
       //tags
        $(".wrap_book_set input[name=equip_params]").tagsInput({
            width:'auto',
            height:40,
            onAddTag:function(tag){
            },
            onRemoveTag:function(tag){
            }
        });
        
        $(".wrap_book_set .save").click( function(){
            var btn_target = $(this);
            if( btn_target.hasClass("disabled") ){
                common_ops.alert("正在处理!!请不要重复提交~~");
                return;
            }
 
            var investment_plan_target = $(".wrap_book_set input[name=investment_plan]");
            var investment_plan = $.trim(investment_plan_target.val());
            var name_target = $(".wrap_book_set input[name=name]");
            var name = $.trim(name_target.val());
            var equipment_model_target = $(".wrap_book_set input[name=equipment_model]");
            var equipment_model = $.trim(equipment_model_target.val());
            var unit_target = $(".wrap_book_set input[name=unit]");
            var unit = $.trim(unit_target.val());
            var material_code_target = $(".wrap_book_set input[name=material_code]");
            var material_code = $.trim(material_code_target.val());
            var price_target = $(".wrap_book_set input[name=price]");
            var price = $.trim(price_target.val());
            var produce_company_target = $(".wrap_book_set input[name=produce_company]");
            var produce_company = $.trim(produce_company_target.val());
            var produce_date_target = $(".wrap_book_set input[name=produce_date]");
            var produce_date = $.trim(produce_date_target.val());
            var procure_company_target = $(".wrap_book_set input[name=procure_company]");
            var procure_company = $.trim(procure_company_target.val());
            var procure_tel_target = $(".wrap_book_set input[name=procure_tel]");
            var procure_tel = $.trim(procure_tel_target.val());
            var equip_params_target = $(".wrap_book_set input[name=equip_params]");
            var equip_params = $.trim(equip_params_target.val());
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
             
            		investment_plan:investment_plan,
            		name:name,              
            		equipment_model:equipment_model,
            		unit:unit,
            		material_code:material_code,
            		price:price,
            		produce_company:produce_company,
            		procure_company:procure_company,
            		procure_tel:procure_tel,
            		equip_params:equip_params,
            		beizhu:beizhu,
                id:$(".wrap_book_set input[name=id]").val(),
                 
            };

            $.ajax({
                url:common_ops.buildAdminUrl("/plans/set") ,
                type:'POST',
                data:data,
                dataType:'json',
                success:function(res){
                    btn_target.removeClass("disabled");
                    var callback = null;
                    if( res.code == 200 ){
                        callback = function(){
                            window.location.href = common_ops.buildAdminUrl("/plans/index");
                        }
                    }
                    common_ops.alert( res.msg,callback );
                }
            });

        });

    },
   
     
};

$(document).ready( function(){
	plans_set_ops.init();
} );