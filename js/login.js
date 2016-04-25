// JavaScript Document
var uname=false;
var pass=false;
var code=false;
var matchpass=false;
$.ajaxSetup({async:false});
function md5(){
	$("#password").val(hex_md5($("#password").val()));
}
function getmd5(){
	return hex_md5($("#password").val());
}
function check(){
	if(uname&&pass&&code&&matchpass){
		md5();
		return true;
	}else{
		return false;
	}
}
function checkpass(){
	$("#username").blur();
	$("#password").blur();
	$("#code").blur();
	var username=$("#username").val();
	var password=getmd5($("#password").val());
	var code_num=$("#code").val();
	$.post("check.php?key=password", {value1:username,value2:password,value3:code_num}, function(msg){
		if(msg==1){
			$("#username").css("border-color","#0F0");
			$("#name-tip").html("&nbsp;");
			matchpass=true;
		}else if(msg==0){
			$("#username").css("border-color","#F00");
			$("#name-tip").html("用户名或密码错误");
			matchpass=false;
		}else{
			$("#username").css("border-color","#0F0");
			$("#name-tip").html("&nbsp;");
		}
	});
}
$(function(){
	$("#username").blur(function(){
		if($("#username").val().length>0){
			$("#username").css("border-color","#0F0");
			$("#name-tip").html("&nbsp;");
			uname=true;
		}else{
			$("#username").css("border-color","#F00");
			$("#name-tip").html("请输入用户名");
			uname=false;
		}
	});
	
	$("#password").blur(function(){
		if($("#password").val().length>0){
			$("#password").css("border-color","#0F0");
			$("#pass-tip").html("&nbsp;");
			pass=true;
		}else{
			$("#password").css("border-color","#F00");
			$("#pass-tip").html("请输入密码");
			pass=false;
		}
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
		$(this).next().next("span").html("&nbsp;");
	});
})