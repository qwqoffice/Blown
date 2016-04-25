// JavaScript Document
var content=false;
var code=false;
function chkArticle(){
	$("#code").blur();
	if(content&&code){
		return true;
	}else{
		return false;
	}
}
function reply_thread(obj){
	$("#reply-type").val("thread");
	$("#reply-id").val($(obj).parent().next("#tid").val());
	$("#reply-tip").html("回复主题 " + $(obj).parent().parent().find("h3 a").html());
	$("#reply-content").focus();
}
function reply_reply(obj){
	$("#reply-type").val("reply");
	$("#reply-id").val($(obj).parent().next("#rid").val());
	$("#reply-tip").html("回复用户 " + $(obj).parent().parent().prev().find(".username").html());
	$("#reply-content").focus();
}
$(function(){
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
	
	$("#reply #reply-content").blur(function(){
		if($(this).val()==""){
			$(this).css("border-color","#F00");
			$("#content-tip").html("请输入留言内容");
			content=false;
		}else if($.trim($(this).val()).length<6){
			$(this).css("border-color","#F00");
			$("#content-tip").html("留言内容必须大于6个字符");
			content=false;
		}else{
			$(this).css("border-color","#0F0");
			$("#content-tip").html("&nbsp;");
			content=true;
		}
	});
	
	$("#reply #code").focus(function(){
		$(this).css("border-color", "#999");
		$(this).next().next("span").html("&nbsp;");
	});
	
	$("#reply textarea").focus(function(){
		$(this).css("border-color", "#999");
		$(this).next("span").html("&nbsp;");
	});
})