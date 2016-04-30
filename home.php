<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="原创软件,软件下载,软件开发,程序设计,编程">
<meta name="description" content="以原创、创新、实用为宗旨，努力打造高品质产品">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src="http://libs.baidu.com/jquery/1.9.0/jquery.min.js"></script>
<script src="http://qzonestyle.gtimg.cn/qzone/qzact/common/share/share.js"></script>
<script src="js/swfobject.js"></script>
<script src="js/fullAvatarEditor.js"></script>
<script src="js/home.js"></script>
<script src="js/md5.js"></script>
<script src="js/script.js"></script>
</head>

<body>
<?php
	include("include/header.php");
	
	if(isset($_GET["mod"])){
		$mod=$_GET["mod"];
	}else{
		header("location: home.php?mod=spc");
		exit;
	}
	
	if(isset($_GET["ac"])){
		$ac=$_GET["ac"];
	}else{
		$ac="";
	}
	
	//页码
	if(isset($_GET["page"])){
		$page=(int)$_GET["page"];
	}else{
		$page="1";
	}
	$PageSize=8;//每页行数
	$PageCount=6;//最大显示分页数
	$start=($page-1)*$PageSize;
	
	if($mod=="spc" && isset($_GET["uid"])){
		$uid=(int)$_GET["uid"];
		$username=getUsername($uid);
	}else if($mod=="pref" && isset($_GET["gid"]) && isset($_SESSION["qo_user"])){		
		$uid=getUID($_SESSION["qo_user"]);
		$username=$_SESSION["qo_user"];
		$gid=(int)$_GET["gid"];
		
		//检查GID
		if(mysql_num_rows(mysql_query("select * from qo_group where GID={$gid}"))<1){
			header("location: index.php");
			exit;
		}
	}else if($mod=="notice" && $ac=="notice" && !isset($_SESSION["qo_user"])){
		//$uid="0";
		$username="";
	}else if($mod!="spc" && isset($_SESSION["qo_user"]) || $mod=="spc" && !isset($_GET["uid"]) && isset($_SESSION["qo_user"])){
		$uid=getUID($_SESSION["qo_user"]);
		$username=$_SESSION["qo_user"];
		$gid=getGID($username);
	}else{
		header("location: message.php?msg=auth0");
		exit;
	}
	
	$uidStr="";
	//个人空间
	if($mod=="spc"){
		$uidStr="&uid={$uid}";
		$menus=array("profile"=>"资料","article"=>"主题","reply"=>"回复");
		$title="个人资料";
		$globaltitle="{$username}的{$title}";
	}
	//设置
	else if($mod=="pref"){
		$menus=array("avatar"=>"头像","privacy"=>"隐私","password"=>"密码","usergrp"=>"用户组");
		$title="设置";
		$globaltitle=$title;
	}
	//通知
	else if($mod=="notice"){
		if($username==""){
			$menus=array("notice"=>"公告");
		}else{
			$menus=array("msg"=>"短消息","mypost"=>"我的帖子","notice"=>"公告");
		}
		$title="通知";
		$globaltitle=$title;
	}
	else{
		header("location: index.php");
		exit;
	}
	$menukeys=array_keys($menus);
	if(!in_array($ac,$menukeys)) $ac=$menukeys[0];
	
	//当前位置
	echo "<div id='location'>";
	echo "<a href='index.php' class='nvhm'>&nbsp;</a>";
	if($username!=""){
		echo "<span>&nbsp;>&nbsp;</span>";
		echo "<a href='home.php?mod=spc&uid={$uid}'>{$username}</a>";
	}
	echo "<span>&nbsp;>&nbsp;</span>";
	echo "<span class='nolink'>{$title}</span>";
	echo "</div>";
	
	
	echo "<div id='content' class='article-content'>";
	echo "<div id='homepage'>";
	echo "<table width='100%' cellspacing='0' cellpadding='0'>";
	echo "<tr><td width='150px' height='100%' style='vertical-align:top;background-color:#EAEAEA'><div id='user-menu'>";
	echo "<h4>{$title}</h4>";
	//输出菜单
	echo "<ul>";
	foreach($menus as $key=>$value){
		$curStr=$ac==$key? "class='cur'" : "";
		echo "<a {$curStr} href='home.php?mod={$mod}&ac={$key}{$uidStr}'>";
		echo "<img src='images/{$key}.png' width='20' height='20' />";
		echo "<li>{$value}";
		if($mod=="notice" && ($key=="msg" || $key=="mypost")){
			if($key=="msg"){
				$msgcount=getPrivateMsgCount($uid);
			}else if($key=="mypost"){
				$msgcount=getThreadMsgCount($uid);
			}
			if($msgcount>0) echo "<em class='msgcount menu-msgcount'>{$msgcount}</em>";
		}
		
		echo "</li></a>";
	}
	echo "</ul>";
	echo "</div></td>";
	echo "<td height='100%' style='vertical-align:top;padding-left:30px;padding-right:30px'><div id='user-content'>";
	//内容
	//个人空间
	if($mod=="spc"){
		//资料
		if($ac=="profile"){
			$user_url="http://".dirname($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])."/?{$uid}";
			$u=getUser($uid);
			$th_count=getThreadCount($uid);
			$re_count=getReplyCount($uid);
			$gid=getGID($username);
			$gpname=getGroupName($gid);
			$last=$u["LastLogin"];
			$regip=$u["RegIP"];
			$regtime=$u["RegDate"];
			$isAdmin=isset($_SESSION["qo_user"]) ? getGID($_SESSION["qo_user"])==getSetting("AdminGroup") : false;
			$isSelf=isset($_SESSION["qo_user"]) ? $uid==getUID($_SESSION["qo_user"]) : false;
			echo "<div id='info'>";
			echo "<div style='display:inline-block'><div style='float:left;margin-right:10px;'><img class='avatar' src='avatar.php?uid={$uid}&size=middle' width='60' height='60' /></div>";
			echo "<div style='float:left'><div><span class='username'>{$username}</span> (UID: {$uid})";
			echo "<a href='home.php?mod=notice&ac=msg&talk={$uid}'><label style='float:right;margin-top:5px;margin-right:2px;' class='submit-btn'>发消息</label></a></div>";
			echo "<div><a class='user-url' href='{$user_url}'>{$user_url}</a></div></div></div>";
			echo "<p class='title'>统计信息</p>";
			echo "<p class='sta-info'><a href='home.php?mod=spc&ac=article{$uidStr}'>主题数 {$th_count}</a>";
			echo "&nbsp;&nbsp;&nbsp;<a href='home.php?mod=spc&ac=reply{$uidStr}'>回复数 {$re_count}</a></p>";
			echo "<p class='title'>活跃概况</p>";
			echo "<p class='info'><span>用户组</span>";
			echo "&nbsp;&nbsp;&nbsp;<a href='home.php?mod=pref&ac=usergrp&gid={$gid}'>{$gpname}</a></p>";
			if($isAdmin || $isSelf){
				echo "<p class='info'><span>注册IP</span>";
				echo "&nbsp;&nbsp;&nbsp;<span>{$regip}</span></p>";
				echo "<p class='info'><span>注册时间</span>";
				echo "&nbsp;&nbsp;&nbsp;<span>{$regtime}</span></p>";
			}
			echo "<p class='info'><span>最后访问</span>";
			echo "&nbsp;&nbsp;&nbsp;<span>{$last}</span></p>";
			echo "</div>";
		}
		//主题、回复
		else if($ac=="article" || $ac=="reply"){
			//隐私检查
			$uname=isset($_SESSION["qo_user"]) ? $_SESSION["qo_user"] : "";
			if(getUID($uname)!=$uid){
				$u=getUser($uid);
				$priv=explode(";", $u["Privacy"]);
				if(!in_array("Home",$priv) && getGID($uname)!=getSetting("AdminGroup")){
					echo "<div id='thread-list'>";
					echo "<div class='no-result'>当前用户设置不允许查看动态</div>";
					echo "</div>";
					exit;
				}
				//权限检查
				else if(!chkAuth("VisitUserHome")){
					echo "<div id='thread-list'>";
					echo "<div class='no-result'>您所在的用户组没有权限查看他人动态</div>";
					echo "</div>";
					exit;
				}
			}
			
			
			if($ac=="article"){
				$sql="select * from qo_article,qo_class,qo_user where qo_article.UID=qo_user.UID and qo_article.CID=qo_class.CID and qo_user.UID={$uid} order by TID desc";
			}else if($ac=="reply"){
				$sql="select * from qo_class,qo_reply,qo_article,qo_user where qo_article.UID=qo_user.UID and qo_article.CID=qo_class.CID and qo_article.TID=qo_reply.TID and qo_reply.UID={$uid} and Status='通过' order by RID desc";
			}
			
			echo "<div id='thread-list' style='border:none'>";
			$number=mysql_num_rows(mysql_query($sql));
			$result=mysql_query($sql." limit {$start},{$PageSize}");
			if($ac=="article"){
				print_thread($result,false);//输出主题列表
			}else if($ac=="reply"){
				print_thread($result,true);//输出带回复主题列表
			}
			print_page($number,$PageSize,$page,$PageCount,false);
			echo "</div>";
		}
	}
	//设置
	else if($mod=="pref"){
		$uid=getUID($_SESSION["qo_user"]);
		//头像设置
		if($ac=="avatar"){
			echo "<div id='info'>";
			echo "<p class='middle-title' style='margin-top:12px;'>当前头像</p>";
			echo "<p class='tiptext'>如果您还没有设置自己的头像，系统会显示为默认头像<p>";
			echo "<div class='oldavatar'>";
			echo "<img src='avatar.php?uid={$uid}&size=big' />";
			echo "</div>";
			echo "<p class='middle-title'>设置新头像</p>";
			echo "<div id='avatarEditor'>";
            echo "本组件需要安装Flash Player后才可使用，请从<a href='http://www.adobe.com/go/getflashplayer'>这里</a>下载安装";
			echo "</div>";
			echo "</div>";
		}
		//隐私设置
		else if($ac=="privacy"){
			$u=getUser($uid);
			$privs=array("Home"=>"允许其他用户查看我的动态","Msg"=>"接收短消息");
			$userpriv=explode(";",$u["Privacy"]);
			
			echo "<div id='info'>";
			echo "<p class='middle-title' style='margin-top:12px'>隐私设置</p>";
			echo "<form action='home_comm.php' method='post' autocomplete='off'>";
			//输出隐私列表
			foreach($privs as $k=>$v){
				$isCheck=in_array($k,$userpriv) ? "checked" : "";
				echo "<p class='small-content'><input type='checkbox' name='mypriv[{$k}]' id='mypriv[{$k}]' style='vertical-align:middle' {$isCheck} />";
				echo "<label class='ipt-label' for='mypriv[{$k}]'>{$v}</label></p>";
			}
			echo "<p><label class='submit-btn' for='{$ac}'>保存</label>";
			echo "<input type='submit' name='{$ac}' id='{$ac}' style='display:none' /></p>";
			echo "</form>";
			echo "</div>";
		}
		//密码设置
		else if($ac=="password"){
			echo "<div id='info'>";
			echo "<p class='middle-title' style='margin-top:12px;'>修改密码</p>";
			echo "<form action='home_comm.php' method='post' autocomplete='off'>";
			echo "<table cellpadding='3'>";
			echo "<tr><td><label for='oldpwd' class='label-title'>原密码</label></td><td><input type='password' name='oldpwd' id='oldpwd' /></td></tr>";
			echo "<tr><td><label for='newpwd' class='label-title'>新密码</label></td><td><input type='password' name='newpwd' id='newpwd' /></td></tr>";
			echo "<tr><td><label for='repwd' class='label-title'>重复密码</label></td><td><input type='password' name='repwd' id='repwd' /></td></tr>";
			echo "</table>";
			echo "<label for='{$ac}' class='submit-btn'>保存</label>";
			echo "<input type='submit' name='{$ac}' id='{$ac}' style='display:none' onclick='return chkPass()' />";
			echo "</form>";
			echo "</div>";
		}
		//用户组
		else if($ac=="usergrp"){
			$curgid=getGID($_SESSION["qo_user"]);
			$curgrp=mysql_fetch_array(mysql_query("select * from qo_group where GID={$curgid}"));
			$curauths=explode(";",$curgrp["Authority"]);
			$result=mysql_query("select * from qo_authority order by AuthID");
			$isSelf=$gid==$curgid;
			
			echo "<div id='info'>";
			echo "<p class='middle-title' style='margin-top:12px'>用户组</p>";
			echo "<table class='usergrp' cellpadding='6' cellspacing='0'>";
			echo "<tr><td></td><td class='curgrp'>我的用户组-{$curgrp['GroupName']}</td>";
			if(!$isSelf){
				$grp=mysql_fetch_array(mysql_query("select * from qo_group where GID={$gid}"));
				$auths=explode(";",$grp["Authority"]);
				echo "<td class='usergrp'>{$grp['GroupName']}</td>";
			}
			echo "</tr>";
			while($auth=mysql_fetch_array($result)){
				$authname=$_LANG[$auth['AuthName']];
				$curgrpImg=in_array($auth['AuthID'],$curauths) ? "yes.png" : "no.png";
				echo "<tr><td>{$authname}</td><td><img src='images/{$curgrpImg}' width='15' height='15' /></td>";
				if(!$isSelf){
					$grpImg=in_array($auth['AuthID'],$auths) ? "yes.png" : "no.png";
					echo "<td><img src='images/{$grpImg}' width='15' height='15' /></td>";
				}
				echo "</tr>";
			}
			echo "</table>";
			
			$result=mysql_query("select * from qo_group order by GID");
			echo "<select class='grplist'>";
			while($grp=mysql_fetch_array($result)){
				$isSelected=$gid==$grp["GID"] ? "selected" : "";
				echo "<option value='{$grp['GID']}' {$isSelected}>{$grp['GroupName']}</option>";
			}
			echo "</select>";
			
			//权限说明
			echo "<div style='clear:both;float:none'></div>";
			echo "<p style='font-size:12px'><img style='vertical-align:text-bottom' src='images/yes.png' width='15' height='15' /><span class='vertical-middle'></span>&nbsp;有权操作";
			echo "&nbsp;&nbsp;&nbsp;&nbsp;<img style='vertical-align:text-bottom' src='images/no.png' width='15' height='15' /><span class='vertical-middle'></span>&nbsp;无权操作</p>";
			echo "</div>";
		}
	}
	//通知
	else if($mod=="notice"){
		//短消息
		if($ac=="msg"){
			//发送消息界面
			if(isset($_GET["talk"])){
				$talkuid=(int)$_GET["talk"];
				if(mysql_num_rows(mysql_query("select * from qo_user where UID={$talkuid}"))<1){
					header("location: index.php");
					exit;
				}
				$sessionCount=getSessionCount($uid, $talkuid);
				$unSeenSessionCount=getUnSeenSessionCount($uid, $talkuid);
				$talkname=getUsername($talkuid);
				$maxPage=$sessionCount%$PageSize==0 ? $sessionCount/$PageSize : floor($sessionCount/$PageSize)+1;//最大页数
				if($sessionCount==0) $maxPage=1;
				if($page!=$maxPage && isset($_GET["last"])){
					echo "<script>location.href='home.php?mod=notice&ac=msg&talk={$talkuid}&page={$maxPage}'</script>";
				}
				
				$sql="select * from qo_message where ((UID={$uid} and ToUID={$talkuid}) or (UID={$talkuid} and ToUID={$uid})) and MsgType='Private' order by MID";
				$number=mysql_num_rows(mysql_query($sql));
				$result=mysql_query($sql." limit {$start},{$PageSize}");
				
				echo "<div id='info'>";
				echo "<p style='font-size:12px;font-weight:bolder;'>共有 {$sessionCount} 条与 <a href='home.php?mod=spc&uid={$talkuid}'>{$talkname}</a> 的对话记录</p>";
				echo "<ul class='message-list'>";
				while($msg=mysql_fetch_array($result)){
					$time=getTime($msg['Time']);
					$name=getUsername($msg["UID"]);
					if($name==getUsername($uid)){
						$name="您";
						$class="";
					}else{
						$class="class='name'";
					}
					
					echo "<li><div class='avatar sendmsg'><a href='home.php?mod=spc&uid={$msg['UID']}'><img class='avatar-small' src='avatar.php?uid={$msg['UID']}' width='42' height='42' /></a>";
					echo "<span class='vertical-middle'></span></div>";
					echo "<div id='msg-content'><p><span><a {$class} href='home.php?mod=spc&uid={$msg['UID']}'>{$name}</a></span></p>";
					echo "<p>{$msg['MsgContent']}</p>";
					echo "<p class='time'>{$time}</p></div>";
					echo "<div style='clear:both;float:none'></div>";
					echo "</li>";
				}
				echo "</ul></div>";
				if($unSeenSessionCount>0){
					setSessionSeen($uid, $talkuid);//设为已读
					echo "<script>location.reload();</script>";
					exit;
				}
				print_page($number,$PageSize,$page,$PageCount,false);
				//对话文本框
				echo "<div id='sendmsg'><form method='post' action='home_comm.php' autocomplete='off'>";
				echo "<a href='home.php?mod=spc&uid={$uid}'><img style='vertical-align:top;margin-right:20px' class='avatar-small' src='avatar.php?uid={$uid}&size=middle' width='42' height='42' /></a>";
				echo "<textarea name='msgcontent' maxlength='200' class='msg-txt'></textarea>";
				echo "<input type='hidden' name='talkuid' value='{$talkuid}' />";
				echo "<p><label style='margin-left:64px;float:none' class='submit-btn' for='send'>发送</label><input style='display:none' type='submit' id='send' name='send' /></p>";
				echo "</form></div>";
			}
			//会话列表界面
			else{
				$sql="select * from qo_message where (ToUID={$uid} or UID={$uid}) and MsgType='Private' order by MID desc";
				//$number=mysql_num_rows(mysql_query($sql));
				$result=mysql_query($sql." limit {$start},{$PageSize}");
				$talklist=array();//会话UID列表
				
				echo "<div id='info'>";
				
				if(mysql_num_rows($result)>0){
					echo "<ul class='message-list'>";
					while($msg=mysql_fetch_array($result)){
						$time=getTime($msg['Time']);
						$name=getUsername($msg["UID"]);
						$toname=getUsername($msg["ToUID"]);
						if($uid==$msg['UID']){
							$talkid=$msg["ToUID"];
							if(in_array($msg["ToUID"],$talklist)) continue;
						}else{
							$talkid=$msg["UID"];
							if(in_array($msg["UID"],$talklist)) continue;
						}
						$sessionCount=getSessionCount($uid,$talkid);
						
						echo "<li><div class='avatar'><a href='{$link}'><img class='avatar-small' src='avatar.php?uid={$talkid}' width='42' height='42' /></a>";
						echo "<span class='vertical-middle'></span></div>";
						echo "<p>";
						if($uid==$msg['UID']){
							echo "<a href='home.php?mod=spc&uid={$uid}'>您</a> 对 <span><a class='name' href='home.php?mod=spc&uid={$talkid}'>{$toname}</a></span> 说 : {$msg['MsgContent']}";
							$talklist[]=$msg["ToUID"];
						}else{
							echo "<span><a class='name' href='home.php?mod=spc&uid={$talkid}'>{$name}</a></span> 对 <a href='home.php?mod=spc&uid={$uid}'>您</a> 说 : {$msg['MsgContent']}";
							$talklist[]=$msg["UID"];
						}
						echo "</p>";
						echo "<p class='time'>{$time}&nbsp;&nbsp;|&nbsp;&nbsp;共 {$sessionCount} 条&nbsp;&nbsp;|&nbsp;&nbsp;";
						echo "<a href='home.php?mod=notice&ac=msg&talk={$talkid}&last'>查看</a>";
						if($msg["isRead"]=="False"){
							if($uid!=$msg['UID']) echo "<span class='new'></span>";
						}
						echo "</p>";
						echo "</li>";
					}
					echo "</ul></div>";
					$number=count($talklist);
					print_page($number,$PageSize,$page,$PageCount,false);
				}else{
					echo "<div class='no-result'>暂无消息</div>";
				}
			}
		}
		//帖子通知
		else if($ac=="mypost"){
			$sql="select * from qo_reply,qo_message where ToUID={$uid} and qo_reply.RID=qo_message.RID and Status='通过' and MsgType='Post' order by MID desc";
			$number=mysql_num_rows(mysql_query($sql));
			$result=mysql_query($sql." limit {$start},{$PageSize}");
			
			echo "<div id='info'>";
			
			if(mysql_num_rows($result)>0){
				echo "<ul class='message-list'>";
				while($msg=mysql_fetch_array($result)){
					$article=mysql_fetch_array(mysql_query("select * from qo_article,qo_reply where qo_article.TID=qo_reply.TID and RID={$msg['RID']}"));
					if($article['UID']!=""){
						$uid=$article["UID"];
						$name=getUsername($uid);
						$link="home.php?mod=spc&uid={$uid}";
					}else{
						$uid="";
						$name=$msg["VisitorName"];
						$link="javascript:void(0)";
					}
					$time=getTime($msg['Time']);
					echo "<li><div class='avatar'><a href='{$link}'><img class='avatar-small' src='avatar.php?uid={$uid}' width='42' height='42' /></a>";
					echo "<span class='vertical-middle'></span></div>";
					echo "<p><span><a class='name' href='{$link}'>{$name}</a></span>";
					echo " 回复了您的帖子 ";
					echo "<a href='article.php?mod=view&tid={$article['TID']}'>{$article['Title']}</a>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='article.php?findpost&rid={$msg['RID']}'>查看</a>";
					echo "</p>";
					echo "<p class='time'>{$time}";
					if($msg["isRead"]=="False"){
						echo "<span class='new'></span>";
						setMsgSeen($msg["MID"]);
					}
					echo "</p>";
					echo "</li>";
				}
				echo "</ul></div>";
				print_page($number,$PageSize,$page,$PageCount,false);
			}else{
				echo "<div class='no-result'>暂无消息</div>";
			}
		}
		//公告
		else if($ac=="notice"){
			$nid="";
			$date="";
			if(isset($_GET["nid"])) $nid=(int)$_GET["nid"];
			if(isset($_GET["date"])) $date=substr($_GET["date"],0,7);
			
			echo "<div id='info'>";
			//输出年列表
			$result=mysql_query("select left(Time,4) as Year from qo_notice group by Year order by Year desc");
			if(mysql_num_rows($result)>0){
				echo "<select id='year-select'>";
				while($year=mysql_fetch_array($result)){
					$selectStr=substr($date,0,4)==$year["Year"]?"selected":"";
					echo "<option value='{$year['Year']}' {$selectStr}>{$year['Year']}</option>";
				}
				echo "</select>&nbsp;";
			}
			//输出月列表
			$result=mysql_query("select substring(Time,6,2) as Month from qo_notice where Time like '".substr($date,0,4)."%' group by Month order by Month desc");
			if(mysql_num_rows($result)>0){
				echo "<select id='month-select'>";
				while($month=mysql_fetch_array($result)){
					$selectStr=substr($date,5,2)==$month["Month"]?"selected":"";
					echo "<option value='{$month['Month']}' {$selectStr}>{$month['Month']}</option>";
				}
				echo "</select>";
			}
			
			if(isset($_GET["date"])){
				$sql="select * from qo_notice,qo_user where qo_notice.UID=qo_user.UID and Time like '{$date}%' order by NID desc";
			}else{
				$sql="select * from qo_notice,qo_user where qo_notice.UID=qo_user.UID order by NID desc";
			}
			$num=mysql_num_rows(mysql_query($sql));
			$result=mysql_query($sql." limit {$start},{$PageSize}");
			//显示公告列表
			if(mysql_num_rows($result)>0){
				echo "<ul class='notice-detail'>";
				while($notice=mysql_fetch_array($result)){
					$hideStr=$nid==$notice["NID"]?"":" style='height:0px'";
					$rotateStr=$nid==$notice["NID"]?" class='rotate'":"";
					$curStr=$nid==$notice["NID"]?" class='cur'":"";
					$time=substr($notice["Time"],0,10);
					echo "<li id='notice{$notice['NID']}' {$curStr}>";
					echo "<p class='title'><em>{$notice['Title']}</em>&nbsp;&nbsp;<span class='time'>({$time})</span>";
					echo "<img src='images/triangle.png' {$rotateStr} /></p>";
					echo "<div {$hideStr}><p>作者: <a href='home.php?mod=spc&ac=profile&uid={$notice['UID']}'>{$notice['Username']}</a></p>";
					if($notice["NoticeType"]=="String"){
						echo "<p>{$notice['Content']}</p></div>";
					}else{
						echo "<p><a href='{$notice['Content']}'>{$notice['Content']}</a></p></div>";
					}
					echo "</li>";
					echo "<hr>";
				}
				echo "</ul>";
				if(!isset($_GET["date"])) print_page($num,$PageSize,$page,$PageCount,false);
			}else{
				echo "<div class='no-result'>暂无公告</div>";
			}
			echo "</div>";
		}
	}
	echo "</div></td></tr>";
	echo "</table>";
	echo "</div>";
	echo "</div>";
	
	include("include/footer.php");
?>
</body>
<title><?php echo $globaltitle."-QwqOffice软件工作室"; ?></title>
</html>