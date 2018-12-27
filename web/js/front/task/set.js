;
var task_set_ops = {
	init:function(){
		this.ue = null;
		this.eventBind(); 
		this.initEditor();
	},
	eventBind:function(){ 
		var that = this;
		//按需加载模块模块
		layui.define(['form','laydate' ], function(exports){
			  var $ = layui.jquery; 
			  var form = layui.form;
  
		});
		
 
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
	            
	            var task_desc_target = $("#task_set_form textarea[name=task_desc]"); 
	            var task_desc = $.trim( that.ue.getContent() )
	            

	            var data_str_target = $("#task_set_form input[name=data_str]");
	            var data_str = data_str_target.val();
	            
	            var weight_target = $("#task_set_form input[name=weight]");
	            var weight = weight_target.val();
	            var cate_target = $("#task_set_form select[name=task_cate]");
	            var cate = cate_target.val();
	            
	            if(!validate.chkContentLen(title,50,3)){
	                common_ops.tip( "请输入符合规范的标题（3-50个字符）",title_target); 
	                return;
	            } 
	            if( !validate.chkInt(task_group) || !validate.checkRange(task_group,6,1) ){
	                common_ops.tip( "请选择正确的组",task_group_target  );
	                return;
	            }
	            if(!validate.chkInt(cate)){
	            	common_ops.tip( "请选择正确的分类~~" ,cate_target  );
	                return;
	            }
	            if( !validate.checkRangeDate(data_str," ") ){
	                common_ops.tip( "请选择正确的起止时间~~" ,data_str_target  );
	                return;
	            }
	            if(!validate.chkContentLen(task_desc,300,2)){
	                common_ops.tip( "请输入符合规范的内容（2-300个字符）~" ,that.ue	);
	                return;
	            }    
	           
	            if( !validate.chkInt(weight) || !validate.checkRange(weight,100,1) ){
	                common_ops.tip( "请设置合理的权重1-100"+weight,weight_target );
	                return;
	            }

	            btn_target.addClass("disabled");

	            var data = { 
	            	id:$('#task_set_form input[name=id]').val(),
	                title:title,
	                task_desc:task_desc,              
	                task_group:task_group,	               
	                data_str:data_str,
	                weight:weight,
	                addr_method:'set',
	                cate:cate,
	            };
	           
	            $.ajax({
	                url:common_ops.buildFrontUrl("/task/set") ,
	                type:'POST',
	                data:data,
	                dataType:'json',
	                success:function(res){
	                    btn_target.removeClass("disabled");
	                    alert(res.msg);
	                    if( res.code != 200 ){
	                    	 //alert(res.msg);
	                        return;
	                    }
	                    
	                    window.location.href = common_ops.buildFrontUrl('/task/info',{'id':res.data.id}); 
	                    
	                }
	            });

	        });
	 
	},
	initEditor:function(){
        var that = this;
        that.ue = UE.getEditor('editor',{
            toolbars: [
                [ 'source','undo', 'redo', '|',
                    'bold', 'italic', 'underline', 'strikethrough', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall',  '|','rowspacingtop', 'rowspacingbottom', 'lineheight'],
                [ 'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
                    'directionalityltr', 'directionalityrtl', 'indent', '|',
                    'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
                    'link', 'unlink'],
                [ 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                    'horizontal', 'spechars','|','inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols' ]

            ],
            enableAutoSave:true,
            saveInterval:60000,
            elementPathEnabled:false,
            zIndex:4
        });
        that.ue.addListener('beforeInsertImage', function (t,arg){
            console.log( t,arg );
            //alert('这是图片地址：'+arg[0].src);
            // that.ue.execCommand('insertimage', {
            //     src: arg[0].src,
            //     _src: arg[0].src,
            //     width: '250'
            // });
            return false;
        });
    },
	 
		
}


$(document).ready(function(){
	task_set_ops.init();
});
 
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
 