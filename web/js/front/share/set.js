;
var task_set_ops = {
	init:function(){
		
		this.eventBind();
 
		this.groupArr=[getNowDay(),getWeekEnd(),getMonth()[1],getQuarter()[1],getYear()[1]];
	
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
		
//		$("#task_endtime_limit").focus( function(){ 			 
////			var taskgroup = $('#task_taskgroup').val(); 
////			var minDate =  getNowDay();
////			var maxDate = that.groupArr[taskgroup-1];
////			
////			//限定可选日期.这里不知道为什，重复render 不起作用
////			  var ins22 = laydate.render({
////			    elem: '#task_endtime_limit'
////			    ,trigger:'focus'
////			    ,min:minDate
////			    ,max: maxDate
////			    ,type: 'datetime'
////			    ,ready: function(){
////			     // ins22.hint('日期可选值设定在 <br> '+minDate+'到'+ maxDate);
////			    }
////			  });
//		});
		 $("#task_set_form .save").click( function(){
			 	 
	            var btn_target = $(this);
	            if( btn_target.hasClass("disabled") ){
	                common_ops.alert("正在处理!!请不要重复提交~~");
	                return;
	            }
	         
	            var title_target = $("#task_set_form input[name=title]");
	            var title = title_target.val();

	            var task_group_target = $("#task_set_form select[name=task_group]");
	            var task_group = task_group_target.val();

	            
	           // var task_desc_target = $("#task_set_form textarea[name=task_desc]");
	           // var task_desc = $.trim(task_desc_target.val());
	            var task_desc = layedit.getContent(task_desc_target);
	            
	            var pubLevel_target = $("#task_set_form select[name=pubLevel]");
	            var pubLevel = pubLevel_target.val();

	            var data_str_target = $("#task_set_form input[name=data_str]");
	            var data_str = data_str_target.val();
	            
	            var weight_target = $("#task_set_form input[name=weight]");
	            var weight = weight_target.val();
	            
	           
	            if( title.length < 3 || title.length > 50){
	                common_ops.tip( "请输入符合规范的标题（3-50个字符）",title_target); 
	                return;
	            }

	            if( task_desc.length < 2 || task_desc.length > 300){
	                common_ops.tip( "请输入符合规范的内容（2-300个字符）~" ,task_desc_target);
	                return;
	            }            

	            if( task_group <1 || task_group > 6 ){
	                common_ops.tip( "请选择正确的组",task_group_target  );
	                return;
	            }

	            if( pubLevel < 0 || pubLevel >1 ){
	                common_ops.tip( "请选择是否公开",pubLevel_target  );
	                return;
	            }
	            if( data_str.length < 20 ){
	                common_ops.tip( "请选择正确的起止时间~~" ,data_str_target  );
	                return;
	            }
	            if( weight < 1 || weight >100 ){
	                common_ops.tip( "请设置合理的权重1-100",weight_target );
	                return;
	            }

	            btn_target.addClass("disabled");

	            var data = { 
	            	id:$('#task_set_form input[name=id]').val(),
	                title:title,
	                task_desc:task_desc,              
	                group:task_group,
	                pubLevel:pubLevel,
	                data_str:data_str,
	                weight:weight,
	                addr_method:'set'
	            };

	            $.ajax({
	                url:common_ops.buildMUrl("/task/set") ,
	                type:'POST',
	                data:data,
	                dataType:'json',
	                success:function(res){
	                    btn_target.removeClass("disabled");
	                    var callback = null;
	                  
	                    if( res.code == 200 ){
	                        callback = function(){
	                          
	                        	window.location.href = common_ops.buildMUrl("/task/index");
	                        }
	                    }	                   
	                    common_ops.alert( res.msg,callback );
	                }
	            });

	        });
	 
	}
		
}


$(document).ready(function(){
	task_set_ops.init();
});



// 获取当前时间信息
var now = new Date();
var now_year = now.getFullYear();
var now_month = now.getMonth();
var now_date = now.getDate();
var now_day = now.getDay();
// 初始化 input 的 value 值
$(".start").val(formatDate (now));
$(".end").val(formatDate (now));
//规范格式
function formatDate (date) {
  var myYear = date.getFullYear();
  var myMonth = date.getMonth() + 1;
  var myDate = date.getDate();
  if(myMonth < 10) {
    myMonth = '0' + myMonth;
  }
  if(myDate < 10) {
  myDate = '0' + myDate;
}
  return myYear + '-' + myMonth + '-' + myDate;
}

function getNowDay(){
  // 今天 
  return formatDate (now);
}

// 获取本周第一天
function getWeekStart () {
  var weekStart = new Date(now_year, now_month, now_date - now_day +1);
  return formatDate(weekStart);
}
// 获取本周最后一天
function getWeekEnd () {
var weekEnd = new Date(now_year, now_month, now_date + (7 - now_day));
return formatDate(weekEnd);
}
// 获取本月
function getMonth () {
var MonthStart = new Date(now_year, now_month, 1);
var MonthEnd = new Date((new Date(now_year, now_month + 1, 1)).getTime() - 1000 * 60 * 60* 24);
return [formatDate(MonthStart),formatDate(MonthEnd)];
}
// 获取本季
function getQuarter () {
  var QuarterStartMonth;
  if (now_month < 3) {
    QuarterStartMonth = 0;
  }
  if (now_month > 2 && now_month < 6) {
 QuarterStartMonth = 3;
}
  if (now_month > 5 && now_month < 9) {
  QuarterStartMonth = 6;
}
  if (now_month > 8 && now_month < 11) {
  QuarterStartMonth = 9;
}
  var QuarterStart = new Date(now_year, QuarterStartMonth, 1);
var QuarterEnd = new Date((new Date(now_year, QuarterStartMonth + 3, 1)).getTime() - 1000 * 60 * 60* 24);
  return [formatDate(QuarterStart),formatDate(QuarterEnd)];
}
// 获取今年
function getYear () {
var YearStart = new Date(now_year, 0, 1);
var YearEnd = new Date((new Date(now_year + 1, 1, 1)).getTime() - 1000 * 60 * 60* 24);
return [formatDate(YearStart),formatDate(YearEnd)];
}
//使用插件加载时间
layui.config({
    base: '/plugins/timePicker/js/',
});
layui.use(['timePicker'],function () {
    var timePicker = layui.timePicker;
    timePicker.render({
        elem: '#task_endtime_limit', //定义输入框input对象
        options:{      //可选参数timeStamp，format
            timeStamp:false,//true开启时间戳 开启后format就不需要配置，false关闭时间戳 //默认false
            format:'YYYY-MM-DD',//格式化时间具体可以参考moment.js官网 默认是YYYY-MM-DD HH:ss:mm
        },
    });
     
})
 