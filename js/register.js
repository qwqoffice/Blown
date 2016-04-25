// JavaScript Document
var uname=false;
var pass=false;
var repass=false;
var code=false;
function md5(){
	$("#password").val(hex_md5($("#password").val()));
}
function check(){
	$("#username").blur();
	$("#password").blur();
	$("#repassword").blur();
	$("#code").blur();
	if(uname&&pass&&repass&&code){
		md5();
		return true;
	}else{
		return false;
	}
}
function checkMatch(){
	var repassword=$("#repassword").val();
	if(repassword==$("#password").val()){
		$("#repassword").css("border-color","#0F0");
		$("#repass-tip").html("&nbsp;");
		repass=true;
	}else{
		$("#repassword").css("border-color","#F00");
		$("#repass-tip").html("两次输入的密码不一致");
		repass=false;
	}
	if(repassword.length==0){
		$("#repassword").css("border-color","#F00");
		$("#repass-tip").html("请重复输入密码");
		repass=false;
	}
}
$(function(){
	$("#username").blur(function(){
		var username=$("#username").val();
		$.post("check.php?key=username", {value:username}, function(msg){
			if(msg==1 && username.length>=3 && username.length<=15){
				$("#username").css("border-color","#0F0");
				$("#name-tip").html("&nbsp;");
				uname=true;
			}else{
				$("#username").css("border-color","#F00");
				uname=false;
			}
			if(msg!=1) $("#name-tip").html("用户名已注册，<a href='login.php'>立即登录</a>");
			if(username.length<3 || username.length>15) $("#name-tip").html("用户名由3到15个字符组成");
		});
	});
	
	$("#password").blur(function(){
		var len=$("#password").val().length;
		if(len>=6&&len<=15){
			$("#password").css("border-color","#0F0");
			$("#pass-tip").html("&nbsp;");
			pass=true;
		}else{
			$("#password").css("border-color","#F00");
			$("#pass-tip").html("密码由6到15个字符组成");
			pass=false;
		}
		checkMatch();
	});
	
	$("#repassword").blur(function(){
		checkMatch();
	});
	
	$("#code").blur(function(){
		var code_num=$("#code").val();
		$.post("check.php?key=code", {value:code_num}, function(msg){
			if(msg==1){
				$("#code").css("border-color","#0F0");
				$("#code-tip").html("&nbsp;");
				code=true;
			}else{
				$("#code").css("border-color","#F00");
				$("#code-tip").html("验证码不正确");
				code=false;
			}
		});
	});
	
	$("#login-form input").focus(function(){
		$(this).css("border-color", "#e0e0e0");
		$(this).next("span").html("&nbsp;");
	});
})