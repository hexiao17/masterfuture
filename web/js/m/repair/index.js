;
var repair_index_ops = {
    init:function(){
        this.p = 1;
        this.sort_field = "default";
        this.sort = "";
        this.eventBind();
    },
    eventBind:function(){
        var that = this; 
        //搜索按钮
        $(".st_search_header .search_icon").click( function(){
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
        
    },
    search:function(){
        var params = {
            kw:$(".st_search_header input[name=kw]").val(),
            sort_field:this.sort_field,
            sort:this.sort
        };
        window.location.href = common_ops.buildMUrl("/repair/index",params);
    }
};
$(document).ready(function () {
    repair_index_ops.init();
});