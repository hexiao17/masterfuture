;
var product_index_ops = {
    init:function(){
        this.p = 1;
        this.sort_field = "default";
        this.sort = "";
        this.eventBind();
    },
    eventBind:function(){
        var that = this;
        //搜索按钮
        $(".search_header .search_icon").click( function(){
            that.search();
        });
        //点击排序
        $(".sort_box .sort_list li a").click( function(){
            that.sort_field = $(this).attr("data");
            if( $(this).find("i").hasClass("high_icon")  ){
                that.sort = "asc"
            }else{
                that.sort = "desc"
            }
            that.search();
        });
        //上拉刷新
        process = true;
        $( window ).scroll( function() {
            if( ( ( $(window).height() + $(window).scrollTop() ) > $(document).height() - 20 ) && process ){
                process = false;
                that.p += 1;
                var data = {
                    kw:$(".search_header input[name=kw]").val(),
                    sort_field:this.sort_field,
                    sort:this.sort,
                    p:that.p
                };

                $.ajax({
                    url:common_ops.buildWebUrl( "/zbnews/search" ),
                    type:'GET',
                    dataType:'json',
                    data:data,
                    success:function( res ){
                        process = true;
                        if( res.code != 200 ){
                            return;
                        }
                        var html = "";
                        for( idx in res.data.data ){
                            var info = res.data.data[ idx ];
                            html +='<li><a href="'+common_ops.buildWebUrl( "/zbnews/info",{ id:info['id'] } ) +'"><span class="pro_name">'+info["title"] +'</span><b><label><i class="fa fa-location-arrow" aria-hidden="true">  '+info["pub_company"]+'</i></label> <i class="fa fa-history" aria-hidden="true"> '+info["pub_time"]+'</i> </b></a></li>';

                        }
                        	
                        $(".probox ul.prolist").append( html );
                        if( !res.data.has_next ){                        	 
                        	$("#but_txt")[0].innerHTML="老铁,你已经到底了~"
                            process = false;
                            
                        }
                    }
                });
            }
        });
    },
    search:function(){
        var params = {
            kw:$(".search_header input[name=kw]").val(),
            sort_field:this.sort_field,
            sort:this.sort
        };
        window.location.href = common_ops.buildWebUrl("/zbnews/index",params);
    }
};
$(document).ready(function () {
    product_index_ops.init();
});