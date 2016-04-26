<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="原创软件,软件下载,软件开发,程序设计,编程">
<meta name="description" content="以原创、创新、实用为宗旨，努力打造高品质产品">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="ke4/plugins/code/prettify.css" />
<script charset="utf-8" src="ke4/plugins/code/prettify.js"></script>
<script src="http://libs.baidu.com/jquery/1.9.0/jquery.min.js"></script>
<script src="http://qzonestyle.gtimg.cn/qzone/qzact/common/share/share.js"></script>
<script src="zclip/jquery.zclip.min.js"></script>
<script src="js/article.js"></script>
<script src="js/script.js"></script>
</head>

<body>
<?php
	include("include/header.php");
	
	//findPost处理
	if(isset($_GET["findpost"])){
		if(isset($_GET["rid"])){
			$rid=(int)$_GET["rid"];
		}else{
			header("location: index.php");
			exit;
		}
		$article=findPost($rid);
		if(empty($article)){
			header("location: index.php");
			exit;
		}
		$tid=$article["TID"];
		$page=$article["Page"];
		//页面跳转
		header("location: article.php?mod=view&tid={$tid}&page={$page}#rid{$rid}");
		exit;
	}
	
	if(isset($_GET["mod"])){
		$mod=$_GET["mod"];
	}else if(isset($_GET["mode"])){
		$mod=$_GET["mode"];
	}else{
		header("location: index.php");
		exit;
	}
	//页码
	if(isset($_GET["page"])){
		$page=(int)$_GET["page"];
	}else{
		$page="1";
	}
	$HideCodeStr=chkAuth("NoValidateCode")?"display:none":"";
	$PageSize=10;//每页行数
	$PageCount=6;//最大显示分页数
	$start=($page-1)*$PageSize;
	
	//主题列表
	if($mod=="main" || $mod=="class" || $mod=="search" || $mod=="latest"){
		if($mod=="class" && isset($_GET["cid"])){
			$cid=(int)$_GET["cid"];
		}else if($mod=="main" && isset($_GET["cid"])){
			$cid=(int)$_GET["cid"];
		}
		else if($mod=="search"){
			//检查权限
			if(!chkAuth("Search")){
				header("location: message.php?msg=auth0");
				exit;
			}
		}else if($mod=="latest"){
			
		}
		else{
			header("location: index.php");
			exit;
		}
		//当前位置
		echo "<div id='location'>";
		echo "<a href='index.php' class='nvhm'>&nbsp;</a>";
		echo "<span>&nbsp;>&nbsp;</span>";
		if($mod=="class" || $mod=="main"){
			if($mod=="main"){
				$sql="select * from qo_class where CID={$cid} and Parent=0";
			}else if($mod=="class"){
				$sql="select * from qo_class where CID={$cid}";
			}
			
			if(mysql_num_rows(mysql_query($sql))<1){
				header("location: index.php");
				exit;
			}
			$l2=mysql_fetch_array(mysql_query($sql));
			if($mod=="class"){
				$l1=mysql_fetch_array(mysql_query("select * from qo_class where CID={$l2['Parent']}"));
				echo "<a href='article.php?mod=main&cid={$l1['CID']}'>{$l1['ClassName']}</a>";
				echo "<span>&nbsp;>&nbsp;</span>";
				echo "<a href='article.php?mod={$mod}&cid={$cid}'>{$l2['ClassName']}</a>";
				$globaltitle=$l2["ClassName"]."-".$l1["ClassName"];
			}else{
				echo "<a href='article.php?mod={$mod}&cid={$cid}'>{$l2['ClassName']}</a>";
				$globaltitle=$l2["ClassName"];
			}
		}else if($mod=="search"){
			echo "<span class='nolink'>搜索结果</span>";
			$globaltitle="搜索结果";
		}else if($mod=="latest"){
			echo "<span class='nolink'>最新</span>";
			$globaltitle="最新";
		}
		echo "</div>";
		
		echo "<div id='content' class='article-content'>";
		if($mod=="class"){
			$sql="select * from qo_article,qo_class,qo_user where qo_article.CID={$cid} and qo_article.UID=qo_user.UID and qo_article.CID=qo_class.CID order by TID desc";
		}else if($mod=="latest"){
			$sql="select * from qo_article,qo_class,qo_user where qo_article.UID=qo_user.UID and qo_article.CID=qo_class.CID order by TID desc";
		}else if($mod=="search"){
			$kwd=mb_substr(addslashes(str_replace(" ","%",$_GET["kwd"])),0,10,"utf-8");
			$sql="select * from qo_article,qo_class,qo_user where qo_article.UID=qo_user.UID and qo_article.CID=qo_class.CID and (Title like '%{$kwd}%' or ClassName like '%{$kwd}%') order by TID desc";
		}else if($mod=="main"){
			$sql="select * from qo_class where Parent={$cid} order by Sequence";
		}
		
		echo "<div id='thread-list'>";
		$number=mysql_num_rows(mysql_query($sql));
		$result=mysql_query($sql." limit {$start},{$PageSize}");
		print_thread($result,false);//输出主题列表
		print_page($number,$PageSize,$page,$PageCount,false);
		echo "</div>";
		echo "</div>";
	}
	//主题内容
	else if($mod=="view"){
		if(isset($_GET["tid"])){
			$tid=(int)$_GET["tid"];
		}else{
			exit;
		}
		//当前位置
		$sql="select * from qo_article,qo_user,qo_group where TID={$tid} and qo_article.UID=qo_user.UID and qo_user.GID=qo_group.GID";
		if(mysql_num_rows(mysql_query($sql))<1){
			header("location: index.php");
			exit;
		}
		//浏览+1
		$result=mysql_fetch_array(mysql_query("select ClickCount from qo_article where TID='{$tid}'"));
		$ClickCount=$result["ClickCount"]+1;
		mysql_query("update qo_article set ClickCount={$ClickCount} where TID={$tid}");
		
		$article=mysql_fetch_array(mysql_query($sql));
		$reply_count=mysql_num_rows(mysql_query("select * from qo_reply where TID={$tid} and Status='通过'"));
		$cid=$article["CID"];
		$l2=mysql_fetch_array(mysql_query("select * from qo_class where CID={$cid}"));
		$l1=mysql_fetch_array(mysql_query("select * from qo_class where CID={$l2['Parent']}"));
		$sharetitle=$article["Title"];
		$globaltitle=$article["Title"]."-".$l2["ClassName"];
		echo "<div id='location'>";
		echo "<a href='index.php' class='nvhm'>&nbsp;</a>";
		echo "<span>&nbsp;>&nbsp;</span>";
		echo "<a href='article.php?mod=main&cid={$l1['CID']}'>{$l1['ClassName']}</a>";
		echo "<span>&nbsp;>&nbsp;</span>";
		echo "<a href='article.php?mod=class&cid={$cid}'>{$l2['ClassName']}</a>";
		echo "<span>&nbsp;>&nbsp;</span>";
		echo "<a href='article.php?mod=view&tid={$tid}'>{$article['Title']}</a>";
		echo "</div>";
		echo "<div id='content' class='article-content'>";
		echo "<div id='post-list'>";
		//主题内容只在第一页显示
		if($page==1){
			echo "<div class='user-info'>";
			echo "<div style='float:left'>";
			echo "<a href='index.php?{$article['UID']}' style='margin:0px'><img class='avatar-small' src='avatar.php?uid={$article['UID']}&size=small' /></a>";
			echo "<span class='vertical-middle'></span>";
			echo "<a href='index.php?{$article['UID']}' class='username'>{$article['Username']}</a>";
			echo "<span>|</span>";
			echo "<span><a class='grp' href='home.php?mod=pref&ac=usergrp&gid={$article['GID']}'>{$article['GroupName']}</a></span>";
			echo "<span>|</span>";
			$time=getTime($article["Time"]);
			echo "<span>发表于 {$time}</span></div>";
			
			echo "<div class='float-right'>";
			echo "<span>浏览：{$article['ClickCount']}</span>";
			echo "<span>|</span>";
			echo "<span>回复：{$reply_count}</span></div>";
			echo "</div>";
			echo "<div class='thread-content'>";
			echo "<h3>";
			echo "<a href='article.php?mod=view&tid={$tid}'>[{$_LANG[$article['ArticleType']]}]&nbsp;&nbsp;{$article['Title']}</a>";
			echo "</h3>";
			echo $article["Content"];
			echo "<div class='reply' style='padding-top:30px;'>";
			echo "<div class='bdsharebuttonbox' style='float:left'>";
			echo "<a href='#' class='bds_more' data-cmd='more'></a>";
			echo "<a href='#' class='bds_weixin' data-cmd='weixin' title='分享到微信'></a>";
			echo "<a href='#' class='bds_qzone' data-cmd='qzone' title='分享到QQ空间'></a>";
			echo "<a href='#' class='bds_tsina' data-cmd='tsina' title='分享到新浪微博'></a>";
			echo "<a href='#' class='bds_tqq' data-cmd='tqq' title='分享到腾讯微博'></a>";
			echo "<a href='#' class='bds_renren' data-cmd='renren' title='分享到人人网'></a></div>";
			echo "<a href='#reply-content' onclick='reply_thread(this)' class='reply-btn'>回复</a>";
			echo "<div style='clear:both;float:none'></div></div>";
			echo "<input type='hidden' id='tid' value='{$tid}' />";
			echo "</div>";
		}
		//回复内容
		$sql="select * from qo_reply where TID={$tid} and Status='通过' order by RID";
		$number=mysql_num_rows(mysql_query($sql));
		$result=mysql_query($sql." limit {$start},{$PageSize}");
		$floor=$start+2;
		while($arr=mysql_fetch_array($result)){
			if($arr["UID"]==""){
				$name=$arr["VisitorName"];
				$gid=getSetting("VisitorGroup");
				$groupname=getGroupName($gid);
				$user_url="javascript:void(0)";
			}else{
				$name=getUsername($arr["UID"]);
				$gid=getGID($name);
				$groupname=getGroupName($gid);
				$user_url="index.php?{$arr['UID']}";
			}
			
			echo "<div id='rid{$arr['RID']}' class='user-info'>";
			echo "<div style='float:left'>";
			echo "<a href='{$user_url}' style='margin:0px'><img class='avatar-small' src='avatar.php?uid={$arr['UID']}&size=small' /></a>";
			echo "<span class='vertical-middle'></span>";
			echo "<a href='{$user_url}' class='username'>{$name}</a>";
			echo "<span>|</span>";
			echo "<span><a class='grp' href='home.php?mod=pref&ac=usergrp&gid={$gid}'>{$groupname}</a></span>";
			echo "<span>|</span>";
			$time=getTime($arr["Time"]);
			echo "<span>发表于 {$time}</span></div>";
			echo "<span class='floor'>#{$floor}</span>";
			echo "</div>";
			echo "<div class='thread-content'>";
			//引用评论
			if($arr['Quote']!=""){
				$result1=mysql_query("select * from qo_reply where RID={$arr['Quote']}");
				echo "<blockquote>";
				echo "<font class='font1'>“</font>";
				echo "<div>";
				//引用评论是否被删除
				if(mysql_num_rows($result1)>0){
					$quote=mysql_fetch_array($result1);
					if($quote["UID"]==""){
						$name=$quote["VisitorName"];
					}else{
						$name=getUsername($quote["UID"]);
					}
					$time=getTime($quote["Time"]);
					echo "<a href='article.php?findpost&rid={$quote['RID']}'>".$name." 发表于 ".$time."</a>";
					echo "<br>";
					$content=$quote["ReplyContent"];
					//if(mb_strlen($content)>50) $content=mb_substr($content,0,50,"utf-8");
					echo $content;
				}else{
					echo "此回复已被删除";
				}
				echo "</div>";
				echo "<font class='font2'>”</font>";
				echo "<div style='clear:both;float:none'></div>";
				echo "</blockquote>";
			}
			echo $arr["ReplyContent"];
			echo "<div class='reply'><a href='#reply-content' onclick='reply_reply(this)' class='reply-btn'>回复</a>";
			echo "<div style='clear:both;float:none'></div></div>";
			echo "<input type='hidden' id='rid' value='{$arr['RID']}' />";
			echo "</div>";
			$floor++;
		}
		print_page($number,$PageSize,$page,$PageCount,false);
		
		//评论权限检查
		if(chkAuth("Comment")){
			$strHide="";
		}else{
			$strHide="style='display:none'";
			echo "<div id='reply' style='padding-top:20px;'>您所在的用户组没有权限发表评论</div>";
		}
		
		$uid=isset($_SESSION["qo_user"])?getUID($_SESSION["qo_user"]):"0";
		$placeholder=!isset($_SESSION["qo_user"])?"placeholder='注册帐号可以接收回复通知哦'" : "";
		
        echo "<div id='reply' {$strHide}>";
        echo "<p id='reply-tip'>发表您的留言</p>";
        echo "<form action='article_comm.php' method='post' autocomplete='off' onsubmit='return chkArticle()'>";
        if(!isset($_SESSION["qo_user"])) echo "<p>您的名字：<input type='text' name='username' /></p>";
		echo "<div id='img'><img id='avatar' src='avatar.php?uid={$uid}&size=big' />";
        echo "<p class='p-reply submit'>";
        echo "<label for='submit'>提交</label>";
		echo "<input id='submit' class='button' type='submit' name='reply' style='display:none;' />";
        echo "<span style='display:block;float:left;'>&nbsp;&nbsp;</span>";
        echo "<label for='reset'>清空</label><input id='reset' type='reset' style='display:none;' />";
		echo "<input type='hidden' name='url' value='".urlencode($_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"])."' />";
		echo "<input type='hidden' name='tid' value='{$tid}' />";
		echo "<input type='hidden' name='reply-type' id='reply-type' value='thread' />";
		echo "<input type='hidden' name='reply-id' id='reply-id' value='{$tid}' />";
        echo "<span style='display:block;clear:both'></span>";
        echo "</p></div>";
        echo "<div id='textarea'><p class='p-reply'><textarea {$placeholder} name='reply-content' id='reply-content' maxlength='200'></textarea>";
		echo "<span id='content-tip' style='color:#F00;font-size:12px;'>&nbsp;</span></p>";
        echo "<p class='p-reply' style='width:268px; {$HideCodeStr} '><input type='text' name='code' id='code' placeholder='图片验证码' />";
        echo '<img src="ValidateCode.php" width="130" height="50" style="cursor:pointer" onclick="'."this.src='ValidateCode.php?' + Math.random()".'" />';
        echo "<span id='code-tip' style='color:#F00;font-size:12px'></span>&nbsp;</p></div>";
		echo "<div style='clear:both;float:none'></div>";
        echo "</form>";
        echo "</div>";
        echo "</div>";
		echo "</div>";
	}
	else{
		header("location: index.php");
		exit;
	}
	
	include("include/footer.php");
?>
</body>
<script>window._bd_share_config={"common":{"bdSnsKey":{"tsina":"2267817543"},"bdText":"","bdMini":"1","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
<script type="text/javascript">
     setShareInfo({
         title:          '<?php echo $globaltitle;?>',
         summary:        '以原创、创新、实用为宗旨，努力打造高品质产品。',
         pic:            '<?php echo "http://".$_SERVER["HTTP_HOST"]; ?>/images/icon.png',
         url:            '<?php echo "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];?>'
     });
</script>
<title><?php echo $globaltitle."-QwqOffice软件工作室";?></title>
</html>