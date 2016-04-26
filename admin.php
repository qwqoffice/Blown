<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/style.admin.css" rel="stylesheet" type="text/css" />
<script src="http://libs.baidu.com/jquery/1.9.0/jquery.min.js"></script>
<link rel="stylesheet" href="ke4/themes/default/default.css" />
<link rel="stylesheet" href="ke4/plugins/code/prettify.css" />
<script charset="utf-8" src="ke4/kindeditor.js"></script>
<script charset="utf-8" src="ke4/lang/zh-CN.js"></script>
<script charset="utf-8" src="ke4/plugins/code/prettify.js"></script>
<script src="http://qzonestyle.gtimg.cn/qzone/qzact/common/share/share.js"></script>
<script src="js/md5.js"></script>
<script src="js/admin.js"></script>
</head>

<body>
<?php
	include("include/wechat.php");
	session_start();
	require_once("include/db.php");
	require_once("include/func.php");
	require_once("include/lang_zh.php");
	autoLogin();//自动登录
	
	//检查权限
	if(!chkAuth("Manage")){
		header("location: message.php?msg=auth0");
		exit;
	}
	
	if(isset($_GET["mod"])){
		$mod=$_GET["mod"];
	}else{
		$mod="";
	}
	//页码
	if(isset($_GET["page"])){
		$page=$_GET["page"];
	}else{
		$page="1";
	}
	$PageSize=10;//每页行数
	$PageCount=8;//最大显示分页数
	$start=($page-1)*$PageSize;
	$end=$page*$PageSize;
	$globaltitle="管理中心";
	$u=$_SESSION["qo_user"];
	$uid=getUID($u);
	//定义菜单
	$menus=array("notice"=>"公告管理",
				 "navi"=>"导航管理",
				 "carousel"=>"轮播管理",
				 "article"=>"主题管理",
				 "reply"=>"评论管理",
				 "attach"=>"附件管理",
				 "user"=>"用户管理",
				 "usergrp"=>"用户组管理",
				 "logs"=>"系统日志");
	
	echo "<table cellpadding='0' cellspacing='0' width='100%' height='100%'><tr><td height='61' colspan='2'>";
	echo "<div id='header'>";
	echo "<a href='admin.php'><img src='images/logo.png' width='146' height='50' style='float:left;margin-left:15px;' />";
	echo "<span class='title'>管理中心</span></a>";
	echo "<span class='home'><a href='index.php'>站点首页</a></span>";
	echo "<span class='greeting'><a href='index.php?{$uid}'>{$_SESSION['qo_user']}</a></span>";
	echo "</div></td></tr>";
	echo "<tr><td width='170' style='vertical-align:top;position:relative;background-color:#EEE;'>";
	echo "<div id='menu'>";
	echo "<ul>";
	//输出菜单
	foreach($menus as $key=>$value){
		$curStr=$mod==$key ? "class='cur'" : "";
		echo "<a href='admin.php?mod={$key}' {$curStr}><img src='images/{$key}.png' width='20' height='20' /><li>{$value}</li></a>";
	}
	echo "</ul>";
	echo "<span class='copyright'>QwqOffice 2016</span>";
	echo "</div></td>";
	echo "<td style='vertical-align:top;'>";
	echo "<div id='content'>";
	//公告管理
	if($mod=="notice"){
		$types=array("String"=>"文字", "Link"=>"链接");
		$status=array("Show"=>"显示","Hide"=>"隐藏");
		
		if(isset($_GET["opr"])){
			$opr=$_GET["opr"];
		}else{
			$opr="mgr";
		}
		//列表
		if($opr=="mgr" || $opr=="search"){
			$globaltitle="公告管理";
			$kwd="";
			if(isset($_GET["kwd"])) $kwd=$_GET["kwd"];
			echo "<h4>{$globaltitle}</h4>";
			echo "<div class='search'><form action='' autocomplete='off' method='get'>";
			echo "<input type='hidden' name='mod' value='{$mod}' />";
			echo "<input type='hidden' name='opr' value='search' />";
			echo "<input type='text' name='kwd' placeholder='输入标题/链接/是否显示' value='{$kwd}' />";
			echo "&nbsp;&nbsp;<input type='submit' value='搜索' />";
			echo "</form></div>";
			echo "<form action='admin_comm.php' method='post'><table id='table' cellspacing='0'>";
			echo "<tr><td></td><td>NID</td><td>作者</td><td>标题</td><td>类型</td><td>内容</td><td>时间</td><td>状态</td><td></td></tr>";
			if($opr=="mgr"){
				$sql="select * from qo_notice,qo_user where qo_notice.UID=qo_user.UID order by NID";
			}else{
				$kwd=mb_substr(addslashes(str_replace(" ","%",$_GET["kwd"])),0,10,"utf-8");
				$sql="select * from qo_notice,qo_user where qo_notice.UID=qo_user.UID and (Title like '%{$kwd}%' or Content like '%{$kwd}%') order by NID";
			}
			$number=mysql_num_rows(mysql_query($sql));
			$result=mysql_query($sql." limit {$start},{$PageSize}");
			$maxPage=$number%$PageSize==0 ? $number/$PageSize : floor($number/$PageSize)+1;
			while($arr=mysql_fetch_array($result)){
				$month=substr($arr["Time"],0,7);
				
				echo "<tr><td><input type='checkbox' name='delete[]' value='{$arr['NID']}' /></td>";
				echo "<td>{$arr['NID']}</td>";
				echo "<td><a href='home.php?mod=spc&ac=profile&uid={$arr['UID']}#notice{$arr['NID']}'>{$arr['Username']}</td>";
				echo "<td class='noticetitle'><a href='home.php?mod=notice&ac=notice&date={$month}&nid={$arr['NID']}' style='color:black'>{$arr['Title']}</a></td>";
				echo "<td>{$types[$arr['NoticeType']]}</td>";
				echo "<td>{$arr['Content']}</td>";
				echo "<td>{$arr['Time']}</td>";
				echo "<td>{$status[$arr['Status']]}</td>";
				echo "<td><a href='admin.php?mod=notice&opr=edit&nid={$arr['NID']}' class='mainlink'>编辑</a></td></tr>";
			}
			echo "<tr><td><input id='checkbox' type='checkbox' onclick='checkAll(this)' /><label for='checkbox'>删?</label></td>";
			echo "<td><input type='submit' name='{$mod}' value='提交' /></td>";
			echo "<td colspan='6'>";
			print_page($number,$PageSize,$page,$PageCount,true);//分页
			echo "</td><td></td></tr>";
			echo "<tr><td colspan='10'><a href='admin.php?mod=notice&opr=new'><input type='button' value='发布公告' /></a></td></tr>";
			echo "</table></form>";
		}
		//添加、编辑
		else if($opr=="new" || $opr=="edit"){
			
			if($opr=="edit"){
				if(isset($_GET["nid"])){
					$nid=$_GET["nid"];
					chkExists("qo_notice","NID",$uid);//检查NID
				}else{
					exit;
				}
				$notice=mysql_fetch_array(mysql_query("select * from qo_notice where NID={$nid}"));
				$oldspan=$notice["Title"];
				$oldtitle=strip_tags($oldspan);
				$oldtype=$notice["NoticeType"];
				$oldcontent=str_replace("<br />","\r\n",$notice["Content"]);
				$oldsta=$notice["Status"];
				$globaltitle="公告管理-编辑公告";
				echo "<h4>{$globaltitle}</h4>";
			}else{
				$oldtitle="";
				$oldtype="";
				$oldcontent="";
				$oldsta="";
				$globaltitle="公告管理-发布公告";
				echo "<h4>{$globaltitle}</h4>";
			}
			
			echo "<form action='admin_comm.php' autocomplete='off' method='post' onsubmit='return chkNotice()'>";
			echo "<table id='table' class='detail-table' cellspacing='0'>";
			echo "<tr><td><p><label for='noticeTitle'>标题</label></p>";
			echo "<p><input type='text' name='noticeTitle' id='noticeTitle' value='{$oldtitle}' />";
			echo "</p></td></tr>";
			echo "<tr><td><p><label>类型：</label></p>";
			//输出类型
			$i=1;
			foreach($types as $k=>$v){
				$checkStr=$i==1?"checked":"";
				if($opr=="edit") $checkStr=$oldtype==$k?"checked":"";
				echo "<p class='inputradio'><input type='radio' name='type' value='{$k}' id='{$k}' {$checkStr} /><label for='{$k}'>{$v}</label></p>";
				$i++;
			}
			echo "</td></tr>";
			echo "<tr><td><p><label for='noticeContent'>内容：</label></p>";
			echo "<p><textarea name='noticeContent' id='noticeContent' max-width='200'>{$oldcontent}</textarea></p></td></tr>";
			echo "<tr><td><p><label>状态</label></p>";
			echo "<p class='inputradio'>";
			//输出状态
			$i=1;
			foreach($status as $k=>$v){
				$checkStr=$i==1?"checked":"";
				if($opr=="edit") $checkStr=$oldsta==$k?"checked":"";
				echo "<input type='radio' name='status' value='{$k}' id='{$k}' {$checkStr} /><label for='{$k}'>{$v}</label>&nbsp;&nbsp;";
				$i++;
			}
			echo "</p>";
			echo "</td></tr>";
			echo "<tr><td><p><input type='submit' name='{$mod}' id='{$mod}' value='提交' />";
			echo "<input type='hidden' name='opr' value='{$opr}' />";
			echo "&nbsp;&nbsp;<input type='reset' value='重置' /></p></td></tr>";
			if($opr=="edit"){
				echo "<div id='oldspan' style='display:none'>{$oldspan}</div>";
				echo "<input type='hidden' name='nid' value='{$_GET['nid']}' />";
			}
			echo "</table></form>";
		}else{
			header("location: admin.php");
			exit;
		}
	}
	//导航管理
	else if($mod=="navi"){
		$globaltitle="导航管理";
		echo "<h4>{$globaltitle}</h4>";
		echo "<form action='admin_comm.php' autocomplete='off' method='post'><table cellspacing='10' id='navi-table'>";
		echo "<tr><td width='50'></td><td>CID</td><td>显示顺序</td><td>名称</td><td>链接</td></tr>";
		//一级导航
		$result=mysql_query("select * from qo_class where Parent=0 order by Sequence");
		while($l1=mysql_fetch_array($result)){
			echo "<tr><td><input type='checkbox' name='delete[]' value='{$l1['CID']}' /></td>";
			echo "<td>{$l1['CID']}</td>";
			echo "<td><input class='sequence' type='number' name='seqnew[{$l1['CID']}]' value='{$l1['Sequence']}' /></td>";
			echo "<td><input type='text' name='namenew[{$l1['CID']}]' value='{$l1['ClassName']}' />";
			echo "&nbsp;<a href='javascript:void(0)' onclick='addL2(this)' class='mainlink'>添加</a>";
			echo "<input type='hidden' value='{$l1['CID']}' /></td>";
			echo "<td><input class='link' type='text' name='linknew[{$l1['CID']}]' value='{$l1['Link']}' placeholder='默认article.php?mod=main&cid={CID}' /></td></tr>";
			//二级导航
			$result1=mysql_query("select * from qo_class where Parent={$l1['CID']} order by Sequence");
			if(mysql_num_rows($result1)>0){
				$num=mysql_num_rows($result1);
				for($i=1; $i<=$num; $i++){
					$l2=mysql_fetch_array($result1);
					echo "<tr><td><input type='checkbox' name='delete[]' value='{$l2['CID']}' /></td>";
					echo "<td>{$l2['CID']}</td>";
					echo "<td><input class='sequence' type='number' name='seqnew[{$l2['CID']}]' value='{$l2['Sequence']}' /></td>";
					echo "<td class='".($i==$num?"lastnode":"node")."'><input class='l2' type='text' name='namenew[{$l2['CID']}]' value='{$l2['ClassName']}' /></td>";
					echo "<td><input class='link' type='text' name='linknew[{$l2['CID']}]' value='{$l2['Link']}' placeholder='默认article.php?mod=class&cid={CID}' /></td></tr>";
				}
			}
		}
		$text="删除操作不可恢复，您确定要删除选中的版块及清除其中主题吗？";
		echo "<tr><td></td><td></td><td colspan='3'><a href='javascript:void(0);' onclick='addL1(this)' class='mainlink'>添加一级导航</a></td></tr>";
		echo "<tr><td><input id='checkbox' type='checkbox' onclick='checkAll(this)' /><label for='checkbox'>删?</label></td>";
		echo "<td colspan='3'><input type='submit' name='{$mod}' value='提交' onclick='".'return confirmMsg("'.$text.'");'."' /></td></tr>";
		echo "</table></form>";
	}
	//图片轮播管理
	else if($mod=="carousel"){
		$globaltitle="图片轮播管理";
		echo "<h4>{$globaltitle}</h4>";
		$result=mysql_query("select * from qo_indeximg order by Sequence");
		while($row=mysql_fetch_row($result)){
			$img_array[]=$row;
		}
		$title=array("图片<br>(900*400)","轮播顺序","名称","链接");
		$input_name=array("","seqnew","namenew","linknew");
		echo "<form action='admin_comm.php' autocomplete='off' method='post' enctype='multipart/form-data'>";
		echo "<table cellspacing='10' id='carou-table'>";
		for($i=0; $i<count($title); $i++){
			echo "<tr><td>{$title[$i]}</td>";
			for($j=0; $j<3; $j++){
				if($i==0){
					echo "<td><label id='input-label' for='file{$j}' title='点击更换图片'>";
					echo "<img src='images-index/{$img_array[$j][4]}' width='225' height='100' />";
					echo "<input type='file' id='file{$j}' name='files[]' onchange='updateIMG(this)' />";
					echo "</label></td>";
				}else if($i==1){
					echo "<td><input type='number' name='{$input_name[$i]}[]' value='{$img_array[$j][$i]}' /></td>";
				}else{
					echo "<td><input type='text' name='{$input_name[$i]}[]' value='{$img_array[$j][$i]}' /></td>";
				}
			}
			echo "</tr>";
		}
		for($j=0; $j<3; $j++){
			echo "<input type='hidden' name='num[]' value='{$img_array[$j][0]}' />";
		}
		echo "<tr><td colspan='4'><input type='submit' name='{$mod}' value='提交' /></td></tr>";
		echo "</table></form>";
	}
	//主题管理
	else if($mod=="article"){
		if(isset($_GET["opr"])){
			$opr=$_GET["opr"];
		}else{
			$opr="mgr";
		}
		//列表
		if($opr=="mgr" || $opr=="search"){
			$globaltitle="主题管理";
			$kwd="";
			if(isset($_GET["kwd"])) $kwd=$_GET["kwd"];
			echo "<h4>{$globaltitle}</h4>";
			echo "<div class='search'><form action='' autocomplete='off' method='get'>";
			echo "<input type='hidden' name='mod' value='{$mod}' />";
			echo "<input type='hidden' name='opr' value='search' />";
			echo "<input type='text' name='kwd' placeholder='输入标题/作者/分类' value='{$kwd}' />";
			echo "&nbsp;&nbsp;<input type='submit' value='搜索' />";
			echo "</form></div>";
			echo "<form action='admin_comm.php'  method='post'><table id='table' cellspacing='0'>";
			echo "<tr><td></td><td>TID</td><td>标题</td><td>作者</td><td>分类</td><td>类型</td><td>发表时间</td><td>浏览</td><td>回复</td><td></td></tr>";
			if($opr=="mgr"){
				$sql="select * from qo_article, qo_class, qo_user where qo_article.CID=qo_class.CID and qo_article.UID=qo_user.UID order by TID";
			}else{
				$kwd=mb_substr(addslashes(str_replace(" ","%",$_GET["kwd"])),0,10,"utf-8");
				$sql="select * from qo_article, qo_class, qo_user where qo_article.CID=qo_class.CID and qo_article.UID=qo_user.UID and (Title like '%{$kwd}%' or Username like '%{$kwd}%' or ClassName like '%{$kwd}%') order by TID";
			}
			$number=mysql_num_rows(mysql_query($sql));
			$result=mysql_query($sql." limit {$start},{$PageSize}");
			$maxPage=$number%$PageSize==0 ? $number/$PageSize : floor($number/$PageSize)+1;
			while($arr=mysql_fetch_array($result)){
				$reply_count=mysql_num_rows(mysql_query("select * from qo_reply where TID={$arr['TID']} and Status='通过'"));
				echo "<tr><td><input type='checkbox' name='delete[]' value='{$arr['TID']}' /></td>";
				echo "<td>{$arr['TID']}</td>";
				echo "<td class='bolder'><a href='article.php?mod=view&tid={$arr['TID']}' class='mainlink'>{$arr['Title']}</a></td>";
				echo "<td><a href='index.php?{$arr['UID']}'>{$arr['Username']}</a></td>";
				echo "<td><a href='article.php?mod=class&cid={$arr['CID']}'>{$arr['ClassName']}</a></td>";
				echo "<td>{$_LANG[$arr['ArticleType']]}</td>";
				echo "<td>{$arr['Time']}</td>";
				echo "<td>{$arr['ClickCount']}</td>";
				echo "<td>{$reply_count}</td>";
				echo "<td><a href='admin.php?mod=article&opr=edit&tid={$arr['TID']}' class='mainlink'>编辑</a></td></tr>";
			}
			
			$text="删除操作不可恢复，您确定要删除选中的主题吗？";
			echo "<tr><td><input id='checkbox' type='checkbox' onclick='checkAll(this)' /><label for='checkbox'>删?</label></td>";
			echo "<td><input type='submit' name='{$mod}' value='提交' onclick='".'return confirmMsg("'.$text.'");'."' /></td>";
			echo "<td colspan='8'>";
			print_page($number,$PageSize,$page,$PageCount,true);//分页
			echo "</td></tr>";
			echo "<tr><td colspan='10'><a href='admin.php?mod=article&opr=new'><input type='button' value='发表主题' /></a></td></tr>";
			echo "</table></form>";
		}
		//发表、编辑
		else if($opr=="new" || $opr=="edit"){
			//主题类型
			$articleType=array("Product","Original","Repaint");
			
			if($opr=="edit"){
				if(isset($_GET["tid"])){
					$tid=$_GET["tid"];
					chkExists("qo_article","TID",$tid);//检查TID
				}else{
					exit;
				}
				$article=mysql_fetch_array(mysql_query("select * from qo_article where TID={$tid}"));
				$oldcid=$article["CID"];
				$oldtype=$article["ArticleType"];
				$oldtitle=$article["Title"];
				$oldcontent=htmlspecialchars($article["Content"]);
				$globaltitle="主题管理-编辑主题";
				echo "<h4>{$globaltitle}</h4>";
			}else{
				$oldcid="";
				$oldtype="";
				$oldtitle="";
				$oldcontent="";
				$globaltitle="主题管理-发表主题";
				echo "<h4>{$globaltitle}</h4>";
			}
			
			echo "<form autocomplete='off' name='textarea' action='admin_comm.php' method='post'>";
			//输出分类列表
			echo "<p style='margin-top:0px'><label for='cid'>分类：</label>";
			$result=mysql_query("select * from qo_class where Parent=0 order by Sequence");
			if(mysql_num_rows($result)>0){
				echo "<select name='cid' id='cid'>";
				while($l1=mysql_fetch_array($result)){
					$result1=mysql_query("select * from qo_class where Parent={$l1['CID']} order by Sequence");
					if(mysql_num_rows($result1)>0){
						echo "<optgroup label='{$l1['ClassName']}'>";
						while($l2=mysql_fetch_array($result1)){
							echo "<option value='{$l2['CID']}' ".($oldcid==$l2["CID"]?"selected":"").">{$l2['ClassName']}</option>";
						}
						echo "</optgroup>";
					}
				}
				echo "</select>";
			}
			//输出类型列表
			echo "<label style='margin-left:25px;' for='type'>类型：</label>";
			echo "<select name='type' id='type'>";
			foreach($articleType as $v){
				$selectStr=$v==$oldtype?"selected":"";
				echo "<option value='{$v}' {$selectStr}>{$_LANG[$v]}</option>";
			}
			echo "</select>";
			echo "<label style='margin-left:25px;' for='title'>标题：</label>";
			echo "<input style='width:300px' type='text' name='title' id='title' value='{$oldtitle}' /></p>";
			echo "<textarea name='content'>{$oldcontent}</textarea>";
			echo "<p><input type='submit' name='{$mod}' value='提交' />";
			echo "<input type='hidden' name='opr' value='{$opr}' />";
			if($opr=="edit") echo "<input type='hidden' name='tid' value='{$_GET['tid']}' />";
			echo "&nbsp;&nbsp;&nbsp;&nbsp;<input type='reset' value='重置' /></p>";
			echo "</form>";
		}else{
			header("location: admin.php");
			exit;
		}
	}
	//评论管理
	else if($mod=="reply"){
		if(isset($_GET["opr"])){
			$opr=$_GET["opr"];
		}else{
			$opr="mgr";
		}
		//列表
		if($opr=="mgr" || $opr=="search"){
			$globaltitle="评论管理";
			$kwd="";
			if(isset($_GET["kwd"])) $kwd=$_GET["kwd"];
			echo "<h4>{$globaltitle}</h4>";
			echo "<div class='search'><form action='' autocomplete='off' method='get'>";
			echo "<input type='hidden' name='mod' value='{$mod}' />";
			echo "<input type='hidden' name='opr' value='search' />";
			echo "<input type='text' name='kwd' placeholder='输入回复内容/审核状态' value='{$kwd}' />";
			echo "&nbsp;&nbsp;<input type='submit' value='搜索' />";
			echo "</form></div>";
			echo "<form action='admin_comm.php' autocomplete='off' method='post'><table id='table' cellspacing='0'>";
			echo "<tr><td></td><td>RID</td><td>作者</td><td>所在主题</td><td>引用</td><td>内容</td><td>发表时间</td><td>IP</td><td>状态</td><td></td></tr>";
			if($opr=="mgr"){
				$sql="select * from qo_reply order by RID";
			}else{
				$kwd=mb_substr(addslashes(str_replace(" ","%",$_GET["kwd"])),0,10,"utf-8");
				$sql="select * from qo_reply where ReplyContent like '%{$kwd}%' or Status='{$kwd}' order by RID";
			}
			$number=mysql_num_rows(mysql_query($sql));
			$result=mysql_query($sql." limit {$start},{$PageSize}");
			$maxPage=$number%$PageSize==0 ? $number/$PageSize : floor($number/$PageSize)+1;
			while($arr=mysql_fetch_array($result)){
				if($arr["Quote"]==""){
					$reply="-";
				}else{
					$reply=mysql_fetch_array(mysql_query("select * from qo_reply where RID={$arr['Quote']}"));
					$reply=htmlspecialchars($reply["ReplyContent"]);
				}
				echo "<tr><td><input type='checkbox' name='delete[]' value='{$arr['RID']}' /></td>";
				echo "<td>{$arr['RID']}</td>";
				if($arr["UID"]==""){
					$name=$arr["VisitorName"];
				}else{
					$name=mysql_fetch_array(mysql_query("select * from qo_user where UID={$arr['UID']}"));
					$name=$name["Username"];
				}
				echo "<td class='bolder'>{$name}</td>";
				$title=mysql_fetch_array(mysql_query("select * from qo_article where TID={$arr['TID']}"));
				$title=$title["Title"];
				echo "<td><a href='article.php?mod=view&tid={$arr['TID']}' class='mainlink'>{$title}</a></td>";
				echo "<td title='{$reply}'>".mb_substr($reply,0,5,"utf-8").(mb_strlen($reply)>5?"..":"")."</td>";
				$content=htmlspecialchars($arr["ReplyContent"]);
				echo '<td title="'.$content.'">'.mb_substr($content,0,10,"utf-8").(mb_strlen($content)>10?"..":"")."</td>";
				echo "<td>{$arr['Time']}</td>";
				echo "<td>{$arr['ReplyIP']}</td>";
				echo "<td>{$arr['Status']}</td>";
				echo "<td><a href='admin.php?mod=reply&opr=edit&rid={$arr['RID']}' class='mainlink'>审核</a></td></tr>";
			}
			
			echo "<tr><td><input id='checkbox' type='checkbox' onclick='checkAll(this)' /><label for='checkbox'>删?</label></td>";
			echo "<td><input type='submit' name='{$mod}' value='提交' /></td>";
			echo "<td colspan='8'>";
			print_page($number,$PageSize,$page,$PageCount,true);//分页
			echo "</td></tr>";
			echo "<tr><td colspan='10'><a href='admin.php?mod=reply&opr=verify'><input type='button' value='审核评论' /></a></td></tr>";
			echo "</table></form>";
		}
		//编辑、审核
		else if($opr=="verify" || $opr=="edit"){
			$globaltitle="评论审核";
			echo "<h4>{$globaltitle}</h4>";
			echo "<form action='admin_comm.php' autocomplete='off' method='post'><table id='table' cellspacing='0'>";
			echo "<tr><td></td><td>RID</td><td>作者</td><td>内容</td><td>发表时间</td><td>IP</td><td colspan='3'>审核</td></tr>";
			if($opr=="verify"){
				$sql="select * from qo_reply where Status='审核中' order by RID";
				$oldsta="审核中";
			}else{
				if(isset($_GET["rid"])){
					$rid=$_GET["rid"];
					chkExists("qo_reply","RID",$rid);//检查RID
				}else{
					exit;
				}
				$sql="select * from qo_reply where RID={$rid} order by RID";
				$reply=mysql_fetch_array(mysql_query($sql));
				$oldsta=$reply["Status"];
			}
			$status=array("审核中","通过","不通过");
			$number=mysql_num_rows(mysql_query($sql));
			$result=mysql_query($sql." limit {$start},{$PageSize}");
			$maxPage=$number%$PageSize==0 ? $number/$PageSize : floor($number/$PageSize)+1;
			while($arr=mysql_fetch_array($result)){
				echo "<tr><td><input type='checkbox' name='delete[]' value='{$arr['RID']}' /></td>";
				echo "<td>{$arr['RID']}</td>";
				if($arr["UID"]==""){
					$name=$arr["VisitorName"];
				}else{
					$name=mysql_fetch_array(mysql_query("select * from qo_user where UID={$arr['UID']}"));
					$name=$name["Username"];
				}
				echo "<td class='bolder'>{$name}</td>";
				$content=htmlspecialchars($arr["ReplyContent"]);
				echo '<td title="'.$content.'">'.mb_substr($content,0,15,"utf-8").(mb_strlen($content)>15?"..":"")."</td>";
				echo "<td>{$arr['Time']}</td>";
				echo "<td>{$arr['ReplyIP']}</td>";
				for($i=0; $i<count($status); $i++){
					echo "<td><input type='radio' id='pend{$arr['RID']}[{$i}]' name='pend[{$arr['RID']}]' value='{$status[$i]}' ".($status[$i]==$oldsta?"checked":"")." /><label for='pend{$arr['RID']}[{$i}]'>{$status[$i]}</label></td>";
				}
			}
			
			echo "<tr><td><input id='checkbox' type='checkbox' onclick='checkAll(this)' /><label for='checkbox'>删?</label></td>";
			echo "<td><input type='submit' name='{$mod}' value='提交' /></td>";
			echo "<td colspan='8'>";
			print_page($number,$PageSize,$page,$PageCount,true);//分页
			echo "</td></tr>";
			echo "</table></form>";
		}else{
			header("location: admin.php");
			exit;
		}
	}
	//附件管理
	else if($mod=="attach"){
		$globaltitle="附件管理";
		$kwd="";
		if(isset($_GET["kwd"])) $kwd=$_GET["kwd"];
		echo "<h4>{$globaltitle}</h4>";
		echo "<div class='search'><form action='' autocomplete='off' method='get'>";
		echo "<input type='hidden' name='mod' value='{$mod}' />";
		echo "<input type='hidden' name='opr' value='search' />";
		echo "<input type='text' name='kwd' placeholder='输入文件名/作者' value='{$kwd}' />";
		echo "&nbsp;&nbsp;<input type='submit' value='搜索' />";
		echo "</form></div>";
		echo "<form action='admin_comm.php' autocomplete='off' method='post'><table id='table' cellspacing='0'>";
		echo "<tr><td></td><td>AID</td><td>文件名</td><td>作者</td><td>所在主题</td><td>大小</td><td>下载次数</td><td></td></tr>";
		if(!isset($_GET["kwd"])){
			$sql="select * from qo_attach,qo_user where qo_attach.Author=qo_user.UID order by AID";
		}else{
			$kwd=mb_substr(addslashes(str_replace(" ","%",$_GET["kwd"])),0,10,"utf-8");
			$sql="select * from qo_attach,qo_user where qo_attach.Author=qo_user.UID and (FileName like '%{$kwd}%' or Author like '%{$kwd}%') order by AID";
		}
		$number=mysql_num_rows(mysql_query($sql));
		$result=mysql_query($sql." limit {$start},{$PageSize}");
		$maxPage=$number%$PageSize==0 ? $number/$PageSize : floor($number/$PageSize)+1;
		while($arr=mysql_fetch_array($result)){
			echo "<tr><td><input type='checkbox' name='delete[]' value='{$arr['AID']}' /></td>";
			echo "<td>{$arr['AID']}</td>";
			echo "<td class='bolder'>{$arr['FileName']}</td>";
			echo "<td><a href='index.php?{$arr['UID']}'>{$arr['Username']}</a></td>";
			$result1=mysql_query("select * from qo_article where Content like '%download.php?aid={$arr['AID']}%'");
			if(mysql_num_rows($result1)>0){
				$article=mysql_fetch_array($result1);
				echo "<td><a href='article.php?mod=view&tid={$article['TID']}'>{$article['Title']}</a></td>";
			}else{
				echo "<td>-</td>";
			}
			echo "<td>{$arr['FileSize']}</td>";
			echo "<td>{$arr['DownCount']}</td>";
			echo "<td>".(file_exists($arr["RealFileName"])? "<a href='download.php?aid={$arr['AID']}&count=no' class='mainlink'>下载</a>" : "<span style='color:#F00'>丢失</span>")."</td></tr>";
		}

		echo "<tr><td><input id='checkbox' type='checkbox' onclick='checkAll(this)' /><label for='checkbox'>删?</label></td>";
		echo "<td><input type='submit' name='{$mod}' value='提交' /></td>";
		echo "<td colspan='5'>";
		print_page($number,$PageSize,$page,$PageCount,true);//分页
		echo "</td><td></td></tr>";
		echo "</table></form>";
	}
	//用户管理
	else if($mod=="user"){
		if(isset($_GET["opr"])){
			$opr=$_GET["opr"];
		}else{
			$opr="mgr";
		}
		//列表
		if($opr=="mgr" || $opr=="search"){
			$globaltitle="用户管理";
			$kwd="";
			if(isset($_GET["kwd"])) $kwd=$_GET["kwd"];
			echo "<h4>{$globaltitle}</h4>";
			echo "<div class='search'><form action='' autocomplete='off' method='get'>";
			echo "<input type='hidden' name='mod' value='{$mod}' />";
			echo "<input type='hidden' name='opr' value='search' />";
			echo "<input type='text' name='kwd' placeholder='输入用户名/管理组' value='{$kwd}' />";
			echo "&nbsp;&nbsp;<input type='submit' value='搜索' />";
			echo "</form></div>";
			echo "<form action='admin_comm.php' method='post'><table id='table' cellspacing='0'>";
			echo "<tr><td></td><td>UID</td><td>用户名</td><td>用户组</td><td>主题数</td><td>回帖数</td><td>注册IP</td><td>注册时间</td><td>最后登录</td><td></td></tr>";
			if($opr=="mgr"){
				$sql="select * from qo_user, qo_group where qo_user.GID=qo_group.GID order by UID";
			}else{
				$kwd=mb_substr(addslashes(str_replace(" ","%",$_GET["kwd"])),0,10,"utf-8");
				$sql="select * from qo_user, qo_group where qo_user.GID=qo_group.GID and (Username like '%{$kwd}%' or GroupName like '%{$kwd}%') order by UID";
			}
			$number=mysql_num_rows(mysql_query($sql));
			$result=mysql_query($sql." limit {$start},{$PageSize}");
			$maxPage=$number%$PageSize==0 ? $number/$PageSize : floor($number/$PageSize)+1;
			while($arr=mysql_fetch_array($result)){
				$thread_count=mysql_num_rows(mysql_query("select * from qo_article where UID={$arr['UID']}"));
				$reply_count=mysql_num_rows(mysql_query("select * from qo_reply where UID={$arr['UID']}"));
				echo "<tr><td><input type='checkbox' name='delete[]' value='{$arr['UID']}' /></td>";
				echo "<td>{$arr['UID']}</td>";
				echo "<td class='bolder'><a href='index.php?{$arr['UID']}' class='mainlink'>{$arr['Username']}</a></td>";
				echo "<td><a href='home.php?mod=pref&ac=usergrp&gid={$arr['GID']}'>{$arr['GroupName']}</a></td>";
				echo "<td>{$thread_count}</td>";
				echo "<td>{$reply_count}</td>";
				echo "<td>{$arr['RegIP']}</td>";
				echo "<td>{$arr['RegDate']}</td>";
				echo "<td>{$arr['LastLogin']}</td>";
				echo "<td><a href='admin.php?mod=user&opr=edit&uid={$arr['UID']}' class='mainlink'>编辑</a></td></tr>";
			}
			echo "<tr><td><input id='checkbox' type='checkbox' onclick='checkAll(this)' /><label for='checkbox'>删?</label></td>";
			echo "<td><input type='submit' name='{$mod}' value='提交' /></td>";
			echo "<td colspan='7'>";
			print_page($number,$PageSize,$page,$PageCount,true);//分页
			echo "</td><td></td></tr>";
			echo "<tr><td colspan='11'><a href='admin.php?mod=user&opr=new'><input type='button' value='添加用户' /></a></td></tr>";
			echo "</table></form>";
		}
		//添加、编辑
		else if($opr=="new" || $opr=="edit"){
			if($opr=="edit"){
				if(isset($_GET["uid"])){
					$uid=$_GET["uid"];
					chkExists("qo_user","UID",$uid);//检查UID
				}else{
					exit;
				}
				$username=mysql_fetch_array(mysql_query("select * from qo_user where UID={$uid}"));
				$oldname=$username["Username"];
				$oldgid=$username["GID"];
				$globaltitle="用户管理-编辑用户";
				echo "<h4>{$globaltitle}</h4>";
			}else{
				$oldname="";
				$oldgid="";
				$globaltitle="用户管理-添加用户";
				echo "<h4>{$globaltitle}</h4>";
			}
			
			echo "<form action='admin_comm.php' autocomplete='off' method='post' onsubmit='return chkUser()'>";
			echo "<table id='table' class='detail-table' cellspacing='0'>";
			echo "<tr><td><p><label for='username'>用户名：</label></p>";
			echo "<p class='bolder'>";
			if($opr=="edit"){
				echo $oldname;
			}else{
				echo "<input type='text' name='username' id='username' />";
			}
			echo "</p></td></tr>";
			echo "<tr><td><p><label for='password'>密码：</label></p>";
			$tips=$opr=="edit"?" placeholder='不修改密码请留空'":"";
			echo "<p><input type='text' name='password' id='password'{$tips} /></p></td></tr>";
			echo "<tr><td><p><label for='gid'>用户组：</label></p>";
			echo "<p><select name='gid' id='gid'>";
			$result=mysql_query("select * from qo_group order by GID");
			//输出用户组列表
			while($grp=mysql_fetch_array($result)){
				$isSelect=($oldgid==$grp["GID"] || ($opr=="new" && $grp["GID"]==getSetting("DefaultGroup")))?"selected":"";
				if($grp["GID"]!=getSetting("VisitorGroup")){
					echo "<option value='{$grp['GID']}' {$isSelect}>{$grp['GroupName']}</option>";
				}
			}
			echo "</select></p></td></tr>";
			echo "<tr><td><p><input type='submit' name='{$mod}' id='{$mod}' value='提交' />";
			echo "<input type='hidden' name='opr' value='{$opr}' />";
			if($opr=="edit") echo "<input type='hidden' name='uid' value='{$_GET['uid']}' />";
			echo "&nbsp;&nbsp;<input type='reset' value='重置' /></p></td></tr>";
			echo "</table></form>";
		}else{
			header("location: admin.php");
			exit;
		}
	}
	//用户组管理
	else if($mod=="usergrp"){
		if(isset($_GET["opr"])){
			$opr=$_GET["opr"];
		}else{
			$opr="mgr";
		}
		//列表
		if($opr=="mgr" || $opr=="search"){
			$globaltitle="用户组管理";
			$kwd="";
			if(isset($_GET["kwd"])) $kwd=$_GET["kwd"];
			echo "<h4>{$globaltitle}</h4>";
			echo "<div class='search'><form action='' autocomplete='off' method='get'>";
			echo "<input type='hidden' name='mod' value='{$mod}' />";
			echo "<input type='hidden' name='opr' value='search' />";
			echo "<input type='text' name='kwd' placeholder='输入组名称' value='{$kwd}' />";
			echo "&nbsp;&nbsp;<input type='submit' value='搜索' />";
			echo "</form></div>";
			echo "<form action='admin_comm.php' method='post'><table id='table' cellspacing='0'>";
			echo "<tr><td></td><td>GID</td><td>组名称</td><td></td></tr>";
			//获取四个默认用户组
			$groups[]=getSetting("VisitorGroup");
			$groups[]=getSetting("AdminGroup");
			$groups[]=getSetting("DefaultGroup");
			$groups[]=getSetting("TestAdminGroup");
			
			if($opr=="mgr"){
				$sql="select * from qo_group order by GID";
			}else{
				$kwd=mb_substr(addslashes(str_replace(" ","%",$_GET["kwd"])),0,10,"utf-8");
				$sql="select * from qo_group where GroupName like '%{$kwd}%' order by GID";
			}
			$number=mysql_num_rows(mysql_query($sql));
			$result=mysql_query($sql." limit {$start},{$PageSize}");
			$maxPage=$number%$PageSize==0 ? $number/$PageSize : floor($number/$PageSize)+1;
			while($arr=mysql_fetch_array($result)){
				echo "<tr><td>";
				//不是默认用户组，输出删除框
				if(!in_array($arr["GID"],$groups)) echo "<input type='checkbox' name='delete[]' value='{$arr['GID']}' />";
				echo "</td>";
				echo "<td>{$arr['GID']}</td>";
				echo "<td class='bolder'><a href='home.php?mod=pref&ac=usergrp&gid={$arr['GID']}' class='mainlink'>{$arr['GroupName']}</a></td>";				
				echo "<td><a href='admin.php?mod=usergrp&opr=edit&gid={$arr['GID']}' class='mainlink'>详情 / 编辑</a></td></tr>";
			}

			echo "<tr><td><input id='checkbox' type='checkbox' onclick='checkAll(this)' /><label for='checkbox'>删?</label></td>";
			echo "<td><input type='submit' name='{$mod}' value='提交' /></td>";
			echo "<td>";
			print_page($number,$PageSize,$page,$PageCount,true);//分页
			echo "</td><td></td></tr>";
			echo "<tr><td colspan='4'><a href='admin.php?mod=usergrp&opr=new'><input type='button' value='添加用户组' /></a></td></tr>";
			echo "</table></form>";
		}
		//添加、编辑
		else if($opr=="new" || $opr=="edit"){
			if($opr=="edit"){
				if(isset($_GET["gid"])){
					$gid=$_GET["gid"];
					chkExists("qo_group","GID",$gid);//检查GID
				}else{
					exit;
				}
				$group=mysql_fetch_array(mysql_query("select * from qo_group where GID={$gid}"));
				$oldname=$group["GroupName"];
				$oldauths=explode(";",$group["Authority"]);
				$globaltitle="用户组管理-编辑用户组";
				echo "<h4>{$globaltitle}</h4>";
			}else{
				$oldname="";
				$oldauths=array();
				$globaltitle="用户组管理-添加用户组";
				echo "<h4>{$globaltitle}</h4>";
			}
			
			echo "<form action='admin_comm.php' autocomplete='off' method='post'>";
			echo "<table id='table' class='detail-table' cellspacing='0'>";
			echo "<tr><td><p><label for='groupname'>组名称：</label></p>";
			echo "<p><input type='text' name='groupname' id='groupname' value='{$oldname}' /></p></td></tr>";
			echo "<tr><td><p><label>权限：</label></p>";
			//输出权限列表
			$result=mysql_query("select * from qo_authority order by AuthID");
			while($auth=mysql_fetch_array($result)){
				$authname=$_LANG[$auth['AuthName']];
				$isChk=in_array($auth['AuthID'],$oldauths) ? "checked" : "";
				echo "<p class='auth-list'>";
				echo "<input type='checkbox' name='auths[]' value='{$auth['AuthID']}' id='auths[{$auth['AuthID']}]' {$isChk} /><label for='auths[{$auth['AuthID']}]'>{$authname}</label>";
				echo "<br></p>";
			}
			echo "<p><input id='checkbox' type='checkbox' onclick='checkAll(this)' /><label for='checkbox'>全选</label></p>";
			echo "</td></tr>";
			echo "<tr><td><p><input type='submit' name='{$mod}' id='{$mod}' value='提交' onclick='return chkGroup()' />";
			echo "<input type='hidden' name='opr' value='{$opr}' />";
			if($opr=="edit") echo "<input type='hidden' name='gid' value='{$_GET['gid']}' />";
			echo "&nbsp;&nbsp;<input type='reset' value='重置' /></p></td></tr>";
			echo "</table></form>";
		}else{
			header("location: admin.php");
			exit;
		}
	}
	//系统日志
	else if($mod=="logs"){
		$globaltitle="系统日志";
		$kwd="";
		if(isset($_GET["kwd"])) $kwd=$_GET["kwd"];
		echo "<h4>{$globaltitle}</h4>";
		echo "<div class='search'><form action='' autocomplete='off' method='get'>";
		echo "<input type='hidden' name='mod' value='{$mod}' />";
		echo "<input type='hidden' name='opr' value='search' />";
		echo "<input type='text' name='kwd' placeholder='输入时间/操作' value='{$kwd}' />";
		echo "&nbsp;&nbsp;<input type='submit' value='搜索' />";
		echo "</form></div>";
		echo "<form action='admin_comm.php' autocomplete='off' method='post'><table id='table' cellspacing='0'>";
		echo "<tr><td></td><td>LID</td><td>UID</td><td>用户名</td><td>IP</td><td>时间</td><td>操作</td></tr>";
		if(!isset($_GET["kwd"])){
			$sql="select * from qo_logs,qo_user where qo_logs.UID=qo_user.UID order by LID";
		}else{
			$kwd=mb_substr(addslashes(str_replace(" ","%",$_GET["kwd"])),0,10,"utf-8");
			$sql="select * from qo_logs,qo_user where qo_logs.UID=qo_user.UID and (Time like binary '%{$kwd}%' or Action like '%{$kwd}%') order by LID";
		}
		$number=mysql_num_rows(mysql_query($sql));
		$result=mysql_query($sql." limit {$start},{$PageSize}");
		while($arr=mysql_fetch_array($result)){
			echo "<tr><td><input type='checkbox' name='delete[]' value='{$arr['LID']}' /></td>";
			echo "<td>{$arr['LID']}</td>";
			echo "<td>{$arr['UID']}</td>";
			echo "<td class='bolder'><a href='index.php?{$arr['UID']}'>{$arr['Username']}</a></td>";
			echo "<td>{$arr['IP']}</td>";
			echo "<td>{$arr['Time']}</td>";
			echo "<td>{$arr['Action']}</td>";
		}

		echo "<tr><td><input id='checkbox' type='checkbox' onclick='checkAll(this)' /><label for='checkbox'>删?</label></td>";
		echo "<td><input type='submit' name='{$mod}' value='提交' /></td>";
		echo "<td colspan='5'>";
		print_page($number,$PageSize,$page,$PageCount,true);//分页
		echo "</td><td></td></tr>";
		echo "</table></form>";
	}
	//管理中心首页
	else if($mod==""){
		$globaltitle="管理中心";
		echo "<h4>{$globaltitle}</h4>";
		$sys="";
		if(function_exists("php_uname")) $sys=php_uname('s')." / ";//服务器系统
		$soft=$_SERVER["SERVER_SOFTWARE"]; //服务器软件
		$phpver=PHP_VERSION; //PHP版本
		$mysql=mysql_get_server_info();//MySql
		//GD库
		if(function_exists("gd_info")){ 
			$gd = gd_info();
			$gdinfo = $gd['GD Version'];
		}else{
			$gdinfo = "未知";
		}
		$freetype = $gd["FreeType Support"] ? "支持" : "不支持";//FreeType字体
		$allowurl= ini_get("allow_url_fopen") ? "支持" : "不支持";//远程文件
		$max_upload = ini_get("file_uploads") ? ini_get("upload_max_filesize") : "不可用";//最大上传限制
		echo "<table id='info-table' cellspacing='0'>";
		echo "<tr><td>服务器系统及 PHP<td><td>{$sys}PHP {$phpver}<td></tr>";
		echo "<tr><td>服务器软件<td><td>{$soft}<td></tr>";
		echo "<tr><td>MySQL版本<td><td>{$mysql}<td></tr>";
		echo "<tr><td>上传许可<td><td>{$max_upload}<td></tr>";
		echo "<tr><td>版权所有<td><td>QwqOffice软件工作室<td></tr>";
		echo "</table>";
	}
	//提示信息
	else if($mod=="message"){
		$globaltitle="提示信息";
		echo "<h4>{$globaltitle}</h4>";
		$message=array("notice0"=>"公告更新失败",
					"notice1"=>"公告更新成功",
					"navi0"=>"导航设置失败",
					"navi1"=>"导航设置成功",
					"carousel0"=>"图片轮播设置失败",
					"carousel1"=>"图片轮播设置成功",
					"article0"=>"主题更新失败",
					"article1"=>"主题更新成功",
					"reply0"=>"评论更新失败",
					"reply1"=>"评论更新成功",
					"attach0"=>"附件更新失败",
					"attach1"=>"附件更新成功",
					"user0"=>"用户更新失败",
					"user1"=>"用户更新成功",
					"usergrp0"=>"用户组更新失败",
					"usergrp1"=>"用户组更新成功",
					"logs0"=>"日志更新失败",
					"logs1"=>"日志更新成功",
					"auth0"=>"您没有权限执行此操作",
					"testadmin0"=>"测试管理员没有权限操作");
		if(isset($_GET["msg"])){
			$msg=$_GET["msg"];
			if(!array_key_exists($msg, $message)){
				header("location: admin.php");
				exit;
			}
			if(strpos($msg,"0")===false){
				$resu=1;
			}else{
				$resu=0;
			}
		}else{
			header("location: admin.php");
			exit;
		}
		if(isset($_GET["url"])){
			$url=$_GET["url"];
		}else{
			$url="admin.php";
		}
		if($resu){
			$img="success.png";
			header("refresh:2; url={$url}");
		}else{
			$img="failed.png";
		}
		
		echo "<div id='message'>";
    	echo "<p><img src='images/{$img}' width='25' height='25' style='vertical-align:top' />&nbsp;&nbsp;{$message[$msg]}</p>";
        echo "<p><a href='".($resu ? $url : "javascript:history.back()")."'>".($resu ? "如果您的浏览器没有自动跳转，请点击此链接" : "点击返回上一页")."</a></p>";
		echo "</div>";
	}else{
		header("location: admin.php");
		exit;
	}
	echo "</div></td></tr>";
	

	
	function chkExists($table, $column, $value){
		if(mysql_num_rows(mysql_query("select * from {$table} where {$column}={$value}"))<1){
			header("location: admin.php");
			exit;
		}
	}
?>
</body>
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