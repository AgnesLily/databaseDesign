function toggle() {
	$(".login").hide();
	$(".reg").show();
}
function loginIn(){
	console.log("请求");
	var _data = {
		"account":$("#account").val(),
		"password":$("#password").val()
	};
	$.ajax({
		type:"post",
		url:"interface/account/login.php",
		async:true,
		data:_data,
		dataType:'json',
		success:function(data){
			console.log(data);
			if(data.statue == 1){
				console.log(data);
				alert("登录成功!");
				window.location = "home.html";
			}
			else if(data.statue == -1) {
				alert("账号或密码错误！");
			}
			else if(data.statue == -1) {
				alert("登录失败！");
			}
		}
	});
}

function Register() {
	var _data = {
		"account":$("#reg_account").val(),
		"password":$("#reg_password").val()
	};
	
	$.ajax({
		type:"post",
		url:"interface/account/register.php",
		async:true,
		data:_data,
		dataType:'json',
		success:function(data) {
			if(data.statue == 1){
				console.log(data);
				alert("注册成功!请登录");
				$(".reg").hide();
				$(".login").show();
			}
			else if(data.statue == -1) {
				alert("该用户已存在！");
			}
			else if(data.statue == -2) {
				alert("数据库操作错误！");
			}
			else if(data.statue == -3) {
				alert("注册失败！");
			}
		}
	});
}
