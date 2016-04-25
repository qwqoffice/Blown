// JavaScript Document
var t;
var t1;
var num=1;
var maxImg=0;
function stopChange(){
	clearInterval(t);
}

function startChange(){
	clearInterval(t);
	t=setInterval("changeImg('next')", 8000);
}
function stopChangeNotice(){
	clearInterval(t1);
}
function startChangeNotice(){
	clearInterval(t1);
	t1=setInterval("changeNotice()", 6000);
}

//渐变切换图片
function changeImg(param){
	var type=typeof param;
	if(type=="string"){
		if(param=="next"){
			num=(num>=maxImg ? 1 : ++num);
		}else if(param=="prev"){
			num=(num<=1 ? maxImg : --num);
		}
	}else if(type=="number"){
		num=param;
	}
	
	//渐变
	$("#img-container a img").not(":eq("+(num-1)+")").stop().animate({opacity:0},"0.2s","linear");
	$("#img-container a img").eq(num-1).stop().animate({opacity:1},"0.2s","linear");
	//改变导航条高亮位置
	$("#img-nav-bar label").not(":eq("+(num-1)+")").removeClass("cur");
	$("#img-nav-bar label").eq(num-1).addClass("cur");
	//改变Title、Link
	$("#img-container a").attr("title",$("#img-nav-bar label").eq(num-1).attr("title"))
	.attr("href",$("#img-nav-bar input").eq(num-1).attr("value"));
}

//切换公告
function changeNotice(){
	var noticeCount=$("#notice .notice-list li").length;
	if(noticeCount==1) return;
	$("#notice .notice-list").animate({marginTop:-20},300,"swing",function(){
		$("#notice .notice-list li:first").appendTo("#notice .notice-list");
		$("#notice .notice-list").css("margin-top","0px");
	});
}

$(document).ready(function(){
	maxImg=$("#img-container a img").length;
	startChange();
	startChangeNotice();
	//a标签初始值
	$("#img-container a").attr("title",$("#img-nav-bar label").eq(0).attr("title"))
	.attr("href",$("#img-nav-bar input").eq(0).attr("value"));
	
	//回顶按钮动画
	$(window).scroll(function(){
		var btn=$("#to_top");
		var scrollTop=$(document).scrollTop();
		if(scrollTop<=$(document.body).outerHeight(true)*0.3){
			btn.css("right","-40px");
		}else{
			btn.css("right","30px");
		}
	});
	
	//鼠标经过图片停止轮换，移开继续
	$("#img-container").mouseenter(function(){
		stopChange();
	});
	$("#img-container").mouseleave(function(){
		startChange();
	});
	
	//鼠标经过公告停止轮换，移开继续
	$("#notice").mouseenter(function(){
		stopChangeNotice();
	});
	$("#notice").mouseleave(function(){
		startChangeNotice();
	});
	
	//导航栏动画
	$("#navi li").hover(function(){
		var el = $(this).find("#outer"),
		curHeight = el.height(),
		autoHeight = el.css('height', 'auto').height();
		if($(this).find("#outer").length>0) $(this).addClass("navi-shadow");
		$(this).find("#outer").addClass("navi-shadow");
		el.height(curHeight).stop().animate({height: autoHeight}, 300, "swing");
		//$(this).find("#outer").animate({height:auto}, 300);
	}, function(){
		$(this).find("#outer").stop().animate({height:"0px"}, 200, "swing", function(){
			$(this).parent().removeClass("navi-shadow");
			$(this).removeClass("navi-shadow");
		});
	});
	
	//图片导航经过，切换图片
	$("#img-nav-bar label").hover(function(e) {
        var index=$(this).index();
		changeImg(index+1);
    });
});