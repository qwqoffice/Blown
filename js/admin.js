// JavaScript Document
var setOldStyle;

//添加一级导航
function addL1(obj){
	$(obj).parent().parent().before("<tr><td></td><td></td>"
	+ "<td><input class='sequence' type='number' name='newseq[]' value='0' /></td>"
	+ "<td><input type='text' name='newname[]' /></td>"
	+ "<td><input class='link' type='text' name='newlink[]' placeholder='默认article.php?mod=main&cid={CID}' />"
	+ "<input type='hidden' name='parentcid[]' value='0' /></td></tr>");
}

//添加二级导航
function addL2(obj){
	var cid=$(obj).next("input").val();
	var $nextTR=$(obj).parent().parent().next();
	var classname=(($nextTR.find("td.lastnode").length>0 || $nextTR.find("td.node").length>0) ? "node" : "lastnode");
	$(obj).parent().parent().after("<tr><td></td><td></td>"
	+ "<td><input class='sequence' type='number' name='newseq[]' value='0' /></td>"
	+ "<td class='"+classname+"'><input class='l2' type='text' name='newname[]' /></td>"
	+ "<td><input class='link' type='text' name='newlink[]' placeholder='默认article.php?mod=class&cid={CID}' />"
	+ "<input type='hidden' name='parentcid[]' value='"+cid+"' /></td></tr>");
}

//是否有选中CheckBox
function isCheck(){
	var flag=false;
	$("input[type='checkbox'").each(function(index, element) {
        if($(element).is(":checked")){
			flag=true;
			return flag;
		}
    });
	return flag;
}

//选中所有CheckBox
function checkAll(obj){
	if($(obj).is(":checked")){
		$(obj).parent().parent().parent().find("input[type='checkbox']").prop("checked", true);
	}else{
		$(obj).parent().parent().parent().find("input[type='checkbox']").prop("checked", false);
	}
}

//获取对象URL
function getObjectURL(file) {
	var url = null ; 
	if (window.createObjectURL!=undefined) { // basic
		url = window.createObjectURL(file) ;
	} else if (window.URL!=undefined) { // mozilla(firefox)
		url = window.URL.createObjectURL(file) ;
	} else if (window.webkitURL!=undefined) { // webkit or chrome
		url = window.webkitURL.createObjectURL(file) ;
	}
	return url ;
}

//更新图片
function updateIMG(obj){
	$(obj).prev().attr("src", getObjectURL(obj.files[0]));
	$(obj).prev().prev().find("img").attr("src", getObjectURL(obj.files[0]));
}

//获取URL参数
function getUrlParam(name) {
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
	var r = window.location.search.substr(1).match(reg);  //匹配目标参数
	if (r != null) return unescape(r[2]); return null; //返回参数值
}

//MD5加密
function md5(){
	$("#password").val(hex_md5($("#password").val()));
}

//检查公告
function chkNotice(){
	if($("#noticeTitle").val()=="" || $("#noticeContent").val()==""){
		return false;
	}else{
		return true;
	}
}

//检查用户名、密码
function chkUser(){
	if(getUrlParam("opr")=="edit"){
		md5();
		return true;
	}else{
		if($("#username").val()=="" || $("#password").val()==""){
			return false;
		}else{
			md5();
			return true;
		}
	}
}

//检查用户组名称
function chkGroup(){
	if($("#groupname").val()==""){
		return false;
	}else{
		return true;
	}
}

//提示信息
function confirmMsg(msg){
	if(!isCheck()) return true;
	if(window.confirm(msg)){
		return true;
	}
	else{
		return false;
	}
}

//html字符转义
function htmlspecialchars(str){
	var s = "";  
	if (str.length == 0) return "";  
	for(var i=0; i<str.length; i++){
		switch(str.substr(i,1)){
			case "<": s += "&lt;";break;
			case ">": s += "&gt;";break;
			case "&": s += "&amp;";break;
			case " ":
			if(str.substr(i + 1, 1) == " "){
				s += " &nbsp;";
				i++;
			}else{
				s += " ";
			}
			break;
			case "\"": s += "&quot;"; break;
			case "\n": s += "<br>"; break;
			default: s += str.substr(i,1); break;
		}
	}
	return s;  
}

//RGB转16进制
function RGB2Hex(rgb){
	rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
	function hex(x) {return ("0" + parseInt(x).toString(16)).slice(-2);}
	rgb= "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
	return rgb;
}

$(document).ready(function(e) {
	var $textBox;
	createFullInput("#noticeTitle");
	var $htmlContent=$("#htmlContent");
	var $span=$("#htmlContent span");
	var $textarea=$("textarea[name='title']");
	
	
	//应用旧样式
	if($("#oldspan").length>0){
		var styles=["bolder","italic","underline"];
		$.each(styles,function(n,v){
			if($("#oldspan span").hasClass(v)){
				$textBox.addClass(v);
				$(".fontstyle[name='"+v+"']").addClass("styleActive");
			}
		});
		if($("#oldspan span").css("color")!="rgb(0, 0, 0)"){
			$textBox.css("color",$("#oldspan span").css("color"));
			$("#color").addClass("styleActive");
		}
		$textarea.val($("#oldspan").html());
		$htmlContent.html($textarea.val());
		$span=$("#htmlContent span");
	}

	
	//构造
	function createFullInput(box){
		$textBox=$(box);
		$textBox.after(" <span name='color' id='color' class='fontstyle' title='颜色'></span> "+
		"<span name='bolder' class='fontstyle' title='粗体'></span> "+
		"<span name='italic' class='fontstyle' title='斜体'></span> "+
		"<span name='underline' class='fontstyle' title='下划线'></span> "+
		"<div id='htmlContent' style='display:none'><span></span></div>"+
		"<textarea name='title' style='display:none'></textarea>");
	}
	
	//同步
	function sync(){
		$span.html(htmlspecialchars($textBox.val()));
		$textarea.val($htmlContent.html());
	}
	
	//文本框输入时同步
	$textBox.bind("input propertychange", function(){
		sync();
	});
	
	//样式按钮事件
    $("span.fontstyle").not("span#color").click(function(e) {
		var className=$(this).attr("name");
		$textBox.toggleClass(className);
		$span.toggleClass(className);
		$(this).toggleClass("styleActive");
		sync();
		return false;
    });
	
	//颜色选择器
	KindEditor.ready(function(K) {
		var colorpicker;
		K('#color').bind('click', function(e) {
			e.stopPropagation();
			if (colorpicker) {
				colorpicker.remove();
				colorpicker = null;
				return;
			}
			var colorpickerPos = K('#color').pos();
			colorpicker = K.colorpicker({
				x : colorpickerPos.x,
				y : colorpickerPos.y + K('#color').height() + 3,
				z : 19811214,
				selectedColor : RGB2Hex($textBox.css("color")),
				noColor : '无颜色',
				click : function(color) {
					$textBox.css("color",color);
					$span.css("color",color);
					if(color==""){
						$("#color").removeClass("styleActive");
					}else{
						$("#color").addClass("styleActive");
					}
					sync();
					colorpicker.remove();
					colorpicker = null;
				}
			});
		});
		K(document).click(function() {
			if (colorpicker) {
				colorpicker.remove();
				colorpicker = null;
			}
		});
	});
	
	//鼠标经过显示板块ICON
	xOffset = 15;
	yOffset = -45;
	$("input.icon-file").hover(function(e){
		var img=$(this).prev().attr("src");
		if(img==null) return;
		$("body").append("<div id='img-preview'><img src='" + img + "' width='50' height='50' style='border-radius:50%;border:1px solid #c7c7c7' /></div>");
		$("#img-preview")
		.css("top",(e.pageY + yOffset) + "px")
		.css("left",(e.pageX + xOffset) + "px")
		.css({"display":"none","position":"absolute"})
		.fadeIn("fast");
	},
	function(e){
		$("#img-preview").remove();
	});
	
//KE初始化
KindEditor.ready(function(K) {
	var editor = K.create('textarea[name="content"]', {
		cssPath : 'ke4/plugins/code/prettify.css',
		cssData: 'body {font-family: Microsoft YaHei,Tahoma,Helvetica,"SimSun",sans-serif; font-size: 14px}',
		uploadJson : 'ke4/upload_json.php',
		fileManagerJson : 'ke4/file_manager_json.php',
		allowFileManager : true,
		width : '900px',
		minHeight : 300,
		resizeType : 1,
		afterBlur : function(){this.sync();},
		afterChange : function() {this.sync();},
		afterCreate : function() {
			var self = this;
			self.sync();
			K.ctrl(document, 13, function() {
				self.sync();
				K('form[name="textarea"]')[0].submit();
			});
			K.ctrl(self.edit.doc, 13, function() {
				self.sync();
				K('form[name="textarea"]')[0].submit();
			});
		}
	});
	prettyPrint();
});

});