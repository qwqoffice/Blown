// JavaScript Document
$(document).ready(function(e) {
//头像上传插件
swfobject.addDomLoadEvent(function () {
	var swf = new fullAvatarEditor("ae/fullAvatarEditor.swf", "ae/expressInstall.swf", "avatarEditor", {
		id : 'swf',
		upload_url : 'avatar.php?upload',	//上传接口
		method : 'post',	//提交方式
		quality : 90, //头像质量
		avatar_sizes : "140*140|64*64|32*32", //头像大小
		avatar_sizes_desc : "140*140像素|64*64像素|32*32像素", //头像大小提示文本
		avatar_box_border_width : 0,  //头像边框
		avatar_field_names : "big|middle|small" //表单域
	}, function (msg) {
		switch(msg.code){
			case 5 : 
				if(msg.type==0){
					scrollTo(0,0);
					location.reload();
				}
			break;
		}
	});
});

	//用户组列表改变事件
	$("select.grplist").change(function(e) {
	    var gid=$(this).children("option:selected").val();
		location.href="home.php?mod=pref&ac=usergrp&gid=" + gid;
	});
	
	//年份列表改变事件
	$("#year-select").change(function(e) {
        var year=$(this).children("option:selected").val();
		location.href="home.php?mod=notice&ac=notice&date=" + year;
    });
	
	//年份列表改变事件
	$("#month-select").change(function(e) {
		var year=$("#year-select").children("option:selected").val();
        var month=$(this).children("option:selected").val();
		location.href="home.php?mod=notice&ac=notice&date=" + year + "-" + month;
    });
	
	$(".notice-detail li p").click(function(e) {
		var $div=$(this).next("div");
		$(this).find("img").toggleClass("rotate");
		if($div.css("height")=="0px"){
			curHeight = $div.height(),
			autoHeight = $div.css('height', 'auto').height();
			$div.height(curHeight).stop().animate({height:autoHeight},300,"swing");
		}else{
			$div.stop().animate({height:0},300,"swing");
		}
    });
});

function md5(){
	$("#oldpwd").val(hex_md5($("#oldpwd").val()));
	$("#newpwd").val(hex_md5($("#newpwd").val()));
}

//检查密码
function chkPass(){
	if($("#newpwd").val()!=$("#repwd").val()){
		alert("两次输入密码不一致！");
		return false;
	}else if($("#oldpwd").val()==""){
		alert("请输入原密码！");
		return false;
	}else if($("#newpwd").val()==""){
		alert("请输入新密码！");
		return false;
	}else{
		md5();
		return true;
	}
}