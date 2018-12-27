;
var book_index_ops = {
	init : function() {
		this.eventBind();
	},
	eventBind : function() {
		var that = this;
		$(".remove").click(function() {
			that.ops("remove", $(this).attr("data"))
		});

		$(".recover").click(function() {
			that.ops("recover", $(this).attr("data"))
		});

		$(".wrap_search .search").click(function() {
			$(".wrap_search").submit();
		});

		$("#selAll").click(function() {
 
			// 这个代码完美
			$("input[name='checkbox']").prop("checked", this.checked);

		});
		
		
		/* 批量删除 */
		$("#del_btn").click(
						function() {
							// 判断是否至少选择一项
							var checkedNum = $("input[name='checkbox']:checked").length;
							if (checkedNum == 0) {
								alert("请选择至少一项！");
								return;
							}
							// 批量选择
							if (confirm("确定要删除所选项目？")) {
								var checkedList = new Array();
								$("input[name='checkbox']:checked").each(function() {
													checkedList.push($(this).val());
												});
								 
								$.ajax({
											type : "POST",
											url :  common_ops.buildAdminUrl("/tmpnews/st_delmulti"),
											data : {
												'delitems' : checkedList.toString()
											},
											dataType : 'json',
											success : function(res) {
												var callback = null;
												if (res.code == 200) {
													callback = function() {
														window.location.href = window.location.href;
													}
												}
												common_ops.alert(res.msg, callback);
											}
										});
							}
						});

	},
	ops : function(act, id) {
		var callback = {
			'ok' : function() {
				$.ajax({
					url : common_ops.buildAdminUrl("/tmpnews/st_ops"),
					type : 'POST',
					data : {
						act : act,
						id : id
					},
					dataType : 'json',
					success : function(res) {
						var callback = null;
						if (res.code == 200) {
							callback = function() {
								window.location.href = window.location.href;
							}
						}
						common_ops.alert(res.msg, callback);
					}
				});
			},
			'cancel' : null
		};
		common_ops.confirm((act == "remove") ? "确定删除？" : "确定恢复？", callback);
	}
};

$(document).ready(function() {
	book_index_ops.init();
});
/**
 * 鼠标移到的颜色
 */
$(".table tr").mouseover(function() {
	$(this).find("td").addClass("mouse_color");
});

/**
 * 鼠标移出的颜色
 */
$(".table tr").mouseout(function() {
	$(this).find("td").removeClass("mouse_color");
});
 