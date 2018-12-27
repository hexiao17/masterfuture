;


var attach_set_ops = {
    init:function(){
        this.ue = null;
        this.eventBind();
        this.initEditor();
    },
    eventBind:function(){
        var that = this;       
        $(".wrap_book_set input[name=tags]").tagsInput({
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
 
            var title_target = $(".wrap_book_set input[name=title]");
            var title = title_target.val();

            var pub_company_target = $(".wrap_book_set input[name=pub_company]");
            var pub_company = pub_company_target.val();

            var content  = $.trim( that.ue.getContent() );
            var content_target = $(".wrap_book_set textarea[name=content]");
            
            var expired_time_target = $(".wrap_book_set input[name=expired_time]");
            var expired_time = expired_time_target.val();

            var pub_time_target = $(".wrap_book_set input[name=pub_time]");
            var pub_time = pub_time_target.val();
            var tags_target = $(".wrap_book_set input[name=tags]");
            var tags = $.trim( tags_target.val() );
            var file_key_target = $(".wrap_book_set input[name=file_key]");
            var file_key = $.trim( file_key_target.val() );
             
            if( title.length < 1 ){
                common_ops.alert( "请输入符合规范的新闻名称~~" );
                return;
            }

            if( pub_company.length < 1 ){
                common_ops.tip( "请输入符合规范的新闻发布单位~~" ,pub_company_target );
                return;
            }            

            if( content.length < 10 ){
                common_ops.alert( "请输入新闻描述，并不能少于10个字符~~"  );
                return;
            }

            if( expired_time.length < 10 ){
                common_ops.alert( "请输入过期时间，并不能少于10个字符~~"  );
                return;
            }
            if( pub_time.length < 10 ){
                common_ops.alert( "请输入发布时间，并不能少于10个字符~~"  );
                return;
            }
            if( tags.length < 1 ){
                common_ops.alert( "请输入新闻标签，便于搜索~~" );
                return;
            }

            btn_target.addClass("disabled");

            var data = {
             
                title:title,
                pub_company:pub_company,              
                content:content,
                expired_time:expired_time,
                pub_time:pub_time,
                tags:tags,
                file_key:file_key,
                id:$(".wrap_book_set input[name=id]").val(),
                tmpnews_id:$(".wrap_book_set input[name=tmpnews_id]").val()
            };

            $.ajax({
                url:common_ops.buildAdminUrl("/zbnews/set") ,
                type:'POST',
                data:data,
                dataType:'json',
                success:function(res){
                    btn_target.removeClass("disabled");
                    var callback = null;
                    if( res.code == 200 ){
                        callback = function(){
                            window.location.href = common_ops.buildAdminUrl("/tmpnews/zb_index");
                        }
                    }
                    common_ops.alert( res.msg,callback );
                }
            });

        });

    },
    initEditor:function(){
        var that = this;
        that.ue = UE.getEditor('editor',{
            toolbars: [
                [ 'undo', 'redo', '|',
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

$(document).ready( function(){
	attach_set_ops.init();
} );