var dateSelect;
var time_start;
var time_end;
//验证选取的日期信息
$(".area_select").change(function(){
		
	dateSelect = $("#dateselect").val();
	time_start = $("#time_start").val();
	time_end = $("#time_end").val(); 
	
	var adate = dateSelect.split("-");
	var anodate = new Date();
	var a = anodate.getFullYear() - parseInt(adate[0]);//年份
	var b = anodate.getMonth()+1 - parseInt(adate[1]);//月份
	var c = anodate.getDate() - parseInt(adate[2]);//几号
	
	if(a !== 0) {
		alert("请选择正确的日期！您只能选择本年度、本月份接下来的日期！");
		$("#dateselect").val('');
		return;
	}
	else if(b !== 0) {
		alert("请选择正确的日期！您只能选择本年度、本月份接下来的日期！");
		$("#dateselect").val('');
		return;
	}
//	else if(c >= 0) {
//		alert("请选择正确的日期！您只能选择本年度、本月份接下来的日期！");
//		$("#dateselect").val('');
//		return;
//	}
	
	var start_time = parseInt(time_start.substring(0,2));
	var end_time = parseInt(time_end.substring(0,2));
	
	if(start_time >= end_time) {
		alert("请选择正确的时刻！");
		$("#time_start").val('');
		$("#time_end").val(''); 
		return;
	}
	
	checkRoom();
	//先发个请求请求当前所选日期，时段空闲的教室
	function checkRoom() {
		var room = $(".area_select").children('option:selected').val();
		var _data = {
			"date":dateSelect,
			"start_time":start_time,
			"end_time":end_time,
			"room":room
		};
		$.ajax({
			type:"post",
			url:"interface/apply/checkRoom.php",
			async:true,
			dataType:'json',
			data:_data,
			success:function(data) {
				console.log(data);
				$(".room_select").empty();
				for(var i = 0 ;i < data.length;i++){
					var newop = "<option value='"+data[i].cname+"'>"+data[i].cname+"</option>"
					$(".room_select").append(newop);
				}				
			}
		});
	}	
});


$("#apply_btn").click(function(){
	console.log("jinrubtn");
	var area = $(".area_select").children('option:selected').val();	
	var room = $(".room_select").children('option:selected').val();
	console.log(room);
	var comment = $("#Comments").val();
	var number = $("#number").val();
	
	var _data = {
		"date":dateSelect,
		"start_time":time_start,
		"end_time":time_end,
		"area":area,
		"room":room,
		"comment":comment,
		"number":number
	};
	$.ajax({
		type:"post",
		url:"interface/apply/applyRoom.php",
		async:true,
		data:_data,
		dataType:'json',
		sunccess:function(data) {
			if(data.statue == 1){
				alert("申请成功，请等待管理员回复！");
			}
		}
	});
	
});
