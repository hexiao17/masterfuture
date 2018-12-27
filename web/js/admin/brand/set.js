;
//图片上传
upload={
		error:function(msg){
			common_ops.alert(msg);
		},
		success:function(image_key){
			  var html = ' <img src="' + common_ops.buildPicUrl("brand",image_key) + '"><span class="fa fa-times-circle del del_image" data="' + image_key +'"><i></i></span>';
			  //替换图片！！
			  if( $(".upload_pic_wrap .pic-each").size()> 0){
				  $(".upload_pic_wrap .pic-each").html( html );
			  }else{
				  $(".upload_pic_wrap").append('<span class="pic-each">'+html+'</span>');
			  }		
			  
			  brand_set_ops.delete_img();
		}
};
var brand_set_ops = {
	init:function(){
		 this.ue = null;
		this.eventBind();
		this.delete_img();
		  this.initEditor();
	},
	eventBind:function(){
		 var that = this;
		$(".wrap_brand_set .save").click(function(){
			var btn_target = $(this);
			if(btn_target.hasClass("disabled")){
				common_ops.alert("正在处理，请不要重复提交~~");
				return;
			}
			
			var name_target = $(".wrap_brand_set input[name=name]");
			var name = name_target.val();
			
			var image_key = $(".wrap_brand_set .pic-each .del_image").attr("data");
			
			var mobile_target = $(".wrap_brand_set input[name=mobile]");
			var mobile = mobile_target.val();
			var address_target = $(".wrap_brand_set input[name=address]");
			var address = address_target.val();
			var description_target = $(".wrap_brand_set textarea[name=description]");
			var description = $.trim( that.ue.getContent() );
		 
			if(name.length < 1){
				common_ops.tip("请输入符合规范的品牌名称",name_target);
				return;
			}
			if($(".upload_pic_wrap .pic-each").size() < 1){
				common_ops.alert("请上传品牌图片~~");
				return;
			}
			if(mobile.length < 1){
				common_ops.tip("请输入符合规范的手机号码",mobile_target);
				return;
			}
			if(address.length < 1){
				common_ops.tip("请输入符合规范的公司地址",address_target);
				return;
			}
			if(description.length < 1){
				common_ops.tip("请输入符合规范的公司描述",description_target);
				return;
			}
		 
			btn_target.addClass("disabled");
			var data = {
					name:name,
					mobile:mobile,
					address:address,
					description:description,
					image_key:image_key
			};
			 
			$.ajax({
				
				url:common_ops.buildAdminUrl('/brand/set'),
				type:"post",
				data:data,
				dataType:'json',
				success:function(res){
					btn_target.removeClass("disabled");
					callback = null;
					if(res.code == 200){
						callback = function(){
							window.location.href = common_ops.buildAdminUrl('/brand/info');
						}
					}					
					
					common_ops.alert(res.msg,callback);
				}
				
			});
		});
		
		//无刷新上传
		$(".wrap_brand_set .upload_pic_wrap input[name=pic]").change(function(){
			$(".wrap_brand_set .upload_pic_wrap").submit();
		});
		
		
		
	},
	//点击删除动作	
	delete_img:function(){
		$(".wrap_brand_set .del_image").unbind().click(function(){
			$(this).parent().remove();
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
};
$(document).ready(function(){
	brand_set_ops.init();
});