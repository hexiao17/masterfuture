//-use layui-分页部分
var _url = $("#_url").val(); 
var _pages = $("#_pages").val();
var pages = eval( '(' + _pages +')' );
var queryParam = eval( '(' +  $("#_queryParam").val() +')' );
//这里与示例不一样，我只加载了laypage模块
layui.use(['laypage'], function(){
	  var laypage = layui.laypage;	  
	//自定义样式
	laypage.render({
	elem: 'page_demo' 
	,count:pages['total_count']//总条数
	,groups:15//总共显示多少个页码
	,limit:pages['page_size']  //每页显示多少条
	,curr:pages['p']  //当前页码
	,theme: '#1E9FFF'
	,layout:['count', 'prev', 'page', 'next',  'skip']
	,jump:function(obj,first){ 
		 //obj包含了当前分页的所有参数，比如：
	    //console.log(obj.curr); //得到当前页，以便向服务端请求对应页的数据。
	    //console.log(obj.limit); //得到每页显示的条数
	    queryParam['p']=obj.curr;//给参数中添加当前页数
	    //首次不执行
	    if(!first){
	      var currentPage = obj.curr;//获取点击的页码      
	      window.location.href= common_ops.buildAdminUrl(_url,queryParam); 
	    }
	}
	});
});