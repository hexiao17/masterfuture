;
var applog_access_ops = {
    init:function(){
        this.eventBind();
    },
    eventBind:function(){ 
        $(".wrap_search .search").click( function(){
            $(".wrap_search").submit();
        });
    }
     
};

$(document).ready( function(){
	applog_access_ops.init();
});


/** 
* 鼠标移到的颜色 
*/ 
$(".table tr").mouseover(function(){ 
	$(this).find("td").addClass("mouse_color"); 
}); 

/** 
* 鼠标移出的颜色 
*/ 
$(".table tr").mouseout(function(){ 
	$(this).find("td").removeClass("mouse_color"); 
}); 

