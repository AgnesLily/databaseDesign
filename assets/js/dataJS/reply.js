$(".reply-area").change(function(){
	var area = $(this).children('option:selected').val();
	if(area == '五区'){
		area = 5;
	}
	else if(area == '四区'){
		area = 4;
	}
	else if(area == '三区'){
		area = 3;
	}
	
	var _data = {
		"area":area
	};
	$.ajax({
		type:"post",
		url:"interface/reply/selectRoom.php",
		async:true,
		data:_data,
		dataType:'json',
		success:function(data) {
			$(".reply-room").empty();
			$(".reply-room").append('<option>选择教室</option>')
			for(var i = 0;i < data.length;i++){
				var newop = "<option value='"+data[i].cid+"'>"+data[i].cname+"</option>"
				$(".reply-room").append(newop);
			}
		}
	});	
});

$("#reply_btn").click(function(){
	var formdata = new FormData();
	var des = $("#simple-reply").val();
	var comment = $("#complex-reply").val();
	var pic = $("#pic-upload")[0].files[0];
	var cid = $(".reply-room").children('option:selected').attr("value");

//	var file = pic.files.size;
	console.log(pic);

	var fileName = pic.name;
	var strRegex = "(.jpg|.jpeg|.png)$"; //用于验证图片扩展名的正则表达式
	var re=new RegExp(strRegex);
	if (!(re.test(fileName.toLowerCase()))){
	    alert("您只能上传png,jpg,jpeg格式的图片,请重新选择符合格式的图片~"); 
	    return;
	}
	
	formdata.append('des',des);
	formdata.append('comment',comment);
	formdata.append('pic',pic);
	formdata.append('cid',cid);
	
	var _data = formdata;
	$.ajax({
		type:"post",
		url:"interface/reply/replyRoom.php",
		async:true,
		dataType:'json',
		contentType: false,
		processData: false,
		data:_data,
		success:function(data){
			console.log(data);
			if(data.statue == 1) {
				alert("谢谢您的反馈，管理员会尽快受理您的反馈信息！");
			}
		}
	});
});
