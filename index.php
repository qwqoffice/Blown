<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>QwqOffice软件工作室</title>
<meta name="keywords" content="原创软件,软件下载,软件开发,程序设计,编程">
<meta name="description" content="以原创、创新、实用为宗旨，努力打造高品质产品">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src="http://libs.baidu.com/jquery/1.9.0/jquery.min.js"></script>
<script src="http://qzonestyle.gtimg.cn/qzone/qzact/common/share/share.js"></script>
<script src="js/script.js"></script>
<script type="text/javascript">
     setShareInfo({
         title:          'QwqOffice软件工作室',
         summary:        '以原创、创新、实用为宗旨，努力打造高品质产品。',
         pic:            '<?php echo "http://".$_SERVER["HTTP_HOST"]; ?>/images/icon.png',
         url:            '<?php echo "http://".$_SERVER["HTTP_HOST"]; ?>'
     });
</script>
</head>
<body>
<?php
	//用户主页跳转,www.xxx.com/?{UID}
	foreach($_GET as $getKey=>$getValue){
		if(is_numeric($getKey) && $getValue==""){
			header("location: home.php?mod=spc&uid={$getKey}");
			exit;
		}
	}
	
	include("include/header.php");
	echo "<div id='content'>";
	//站点公告
	$sql="select * from qo_notice where Status='Show' order by NID desc";
	$result=mysql_query($sql);
	if(mysql_num_rows($result)>0){
		echo "<div id='notice'>";
		echo "<p class='title'>公告</p><ul class='notice-list'>";
		while($notice=mysql_fetch_array($result)){
			$date=substr($notice['Time'],0,10);
			$month=substr($notice['Time'],0,7);
			$link=$notice["NoticeType"]=="String"?"home.php?mod=notice&ac=notice&date={$month}&nid={$notice['NID']}#notice{$notice['NID']}":$notice["Content"];
			echo "<li><a href='{$link}'>{$notice['Title']}";
			echo "&nbsp;&nbsp;&nbsp;<span class='notice-date'>({$date})</span></a></li>";
		}
		echo "</ul>";
		echo "<div style='clear:both;float:none'></div>";
		echo "</div>";
	}
	
	//图片轮播
	echo "<div id='img-container'>";
	//图片内容
	echo "<div>";
	echo "<a>";
	for($i=1; $i<=3; $i++){
		$img=mysql_fetch_array($result=mysql_query("select * from qo_indeximg where Sequence='{$i}'"));
		$imgFile="images-index/{$img['FileName']}";
		$imgtitle[$i]=$img["Title"];
		$imglink[$i]=$img["Link"];
		if($img["FileName"]!=""){
			echo "<img src='images-index/{$img['FileName']}' wdth='900' height='400' ".($i!=1?"style='opacity:0'":"")." />";
		}
	}
	echo "</a>";
	//echo "<img src='{$imgFile}' style='position:static' />";//用于撑开父元素高度
	echo "</div>";
	//图片按钮
	echo "<div id='prev-div' onclick='changeImg(".'"prev"'.")'>";
	echo "<label class='prev' title='上一张'></label>";
	echo "</div>";
	echo "<div id='next-div' onclick='changeImg(".'"next"'.")'>";
	echo "<label class='next' title='下一张'></label>";
	echo "</div>";
	//图片导航
	echo "<div id='img-nav-bar'>";
	for($i=1; $i<=3; $i++){
		echo "<label title='{$imgtitle[$i]}' class='img-nav ".($i==1?"cur":"")."'><input type='hidden' name='link' value='{$imglink[$i]}' /></label>";
	}
	echo "<div style='clear:both;float:none'></div></div>";
	echo "</div>";
	
	echo "<div id='forum'>";
	//热门板块
	echo "<div id='hot-forum'>";
	echo "<p class='title'>热门板块</p>";
	echo "<div id='hot-forum-div'>";
	//查询回复数和主题数总数排名前6的子版块（Parent不为0），按总数排序
	$sql="select d.CID,d.ClassName,(coalesce(ThreadCount,0)+coalesce(ReplyCount,0)) as AllCount
			from
				(select qo_class.CID,count(*) as ThreadCount
				 from qo_article,qo_class
				 where qo_class.CID=qo_article.CID
				 group by qo_class.CID) as c
			right join
				(select b.CID,ClassName,coalesce(ReplyCount,0) as ReplyCount
				 from
					(select qo_class.CID,count(*) as ReplyCount
					 from qo_reply,qo_article,qo_class
					 where qo_reply.TID=qo_article.TID and qo_class.CID=qo_article.CID and Status='通过'
					 group by qo_class.CID) as a
				 right join
				 	(select ClassName,CID
					 from qo_class
					 where Parent<>0
					 order by CID desc) as b
				 on a.CID=b.CID) as d
			on c.CID=d.CID
			order by AllCount desc
			limit 0,6";
	$result=mysql_query($sql);
	$i=1;
	while($forum=mysql_fetch_array($result)){
		$border=$i<=4 ? "border-bottom" : "";//前4个输出底部边框
		echo "<div class='hot-box {$border}'><a href='article.php?mod=class&cid={$forum['CID']}'>{$forum['ClassName']}<span class='postcount'>帖子：{$forum['AllCount']}</span></a></div>";
		$i++;
	}
	echo "<div style='clear:both;float:none'></div>";
	echo "</div>";
	echo "</div>";
	//板块
	echo "<div id='box'>";
	echo "<p class='title'>主板块</p>";
	echo "<a href='article.php?mod=main&cid=1'><img src='images/box-1.png' width='294' height='147' /></a>";
	echo "<a href='article.php?mod=main&cid=2'><img src='images/box-2.png' width='294' height='147' /></a>";
	echo "<a href='article.php?mod=main&cid=3'><img src='images/box-3.png' width='294' height='147' /></a>";
	echo "<a href='article.php?mod=view&tid=2'><img src='images/box-4.png' width='294' height='147' /></a>";
	echo "</div>";
	echo "<div style='clear:both;float:none'></div>";
	echo "</div>";
	
	//统计信息
	$today=getTotalPost(date("Y-m-d"));
	$yesterday=getTotalPost(date("Y-m-d",strtotime("-1 day")));
	$allpost=getTotalPost("All");
	$alluser=getTotalUser();
	$newuser=getLastUser();
	echo "<div id='sta'>";
	echo "<p class='title'>统计信息";
	echo "<span>今日: <em>{$today}</em></span><span>|</span>";
	echo "<span>昨日: <em>{$yesterday}</em></span><span>|</span>";
	echo "<span>帖子: <em>{$allpost}</em></span><span>|</span>";
	echo "<span>会员: <em>{$alluser}</em></span><span>|</span>";
	echo "<span>新会员: <a href='index.php?{$newuser['UID']}'>{$newuser['Username']}</a></span></p>";
	echo "</div>";
	
	//主题列表
	echo "<div id='thread-list'>";
	$sql="select * from qo_article,qo_class,qo_user where qo_article.UID=qo_user.UID and qo_article.CID=qo_class.CID order by TID desc";
	$number=mysql_num_rows(mysql_query($sql));
	$result=mysql_query($sql." limit 0,10");
	print_thread($result,false);//输出主题列表
	if($number>10) echo "<a class='readmore' href='article.php?mod=latest&page=2'>浏览更多 »</a>";
	echo "</div>";
	echo "</div>";
	
	
	include("include/footer.php");
?>

<script>window._bd_share_config={"common":{"bdSnsKey":{"tsina":"2267817543"},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"slide":{"type":"slide","bdImg":"3","bdPos":"right","bdTop":"100"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["weixin","qzone","tsina","tqq","renren"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
</body>
</html>
