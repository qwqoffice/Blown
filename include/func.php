<?php
	//获取客户端IP
	function getIP(){
		$IP="-";
		foreach(array("HTTP_CLIENT_IP", "HTTP_X_FORWARDED_FOR", "HTTP_FROM", "REMOTE_ADDR") as $v) {
			if(isset($_SERVER[$v])){
				if(!preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/', $_SERVER[$v])){
					continue;
				}
				$IP = $_SERVER[$v];
			}
		}
		return $IP;
	}

	//读取COOKIE，自动登录
	function autoLogin(){
		if(isset($_COOKIE["qo_user"])){
			if(md5(md5("qo_".$_COOKIE["qo_user"]))==$_COOKIE["qo_key"]){
				//用户不存在退出登录
				if(mysql_num_rows(mysql_query("select * from qo_user where Username='{$_COOKIE['qo_user']}'"))<1){
					header("location: logout.php");
					exit;
				}
				if(!isset($_SESSION["qo_user"])) $_SESSION["qo_user"]=$_COOKIE["qo_user"];
				//刷新COOKIE
				setcookie("qo_user", $_SESSION["qo_user"], time()+3600*24*7);
				setcookie("qo_key", md5(md5("qo_".$_SESSION["qo_user"])), time()+3600*24*7);
				//刷新登录时间
				$username=$_SESSION["qo_user"];
				$datetime=date("Y-m-d H:i:s");
				mysql_query("update qo_user set LastLogin='{$datetime}' where Username='{$username}'");
			}else{
				exit;
			}
		}
	}
	
	//获取UID
	function getUID($username){
		$u=mysql_fetch_array(mysql_query("select UID from qo_user where Username='{$username}'"));
		return $u["UID"];
	}
	
	//获取主题作者
	function getThreadAuthor($tid){
		$u=mysql_fetch_array(mysql_query("select UID from qo_article where TID={$tid}"));
		return $u["UID"];
	}
	
	//获取AuthID
	function getAuthID($authname){
		$a=mysql_fetch_array(mysql_query("select AuthID from qo_authority where AuthName='{$authname}'"));
		return $a["AuthID"];
	}
	
	//获取设置项
	function getSetting($key){
		$setting=mysql_fetch_array(mysql_query("select Value from qo_setting where Name='{$key}'"));
		return $setting["Value"];
	}
	
	//获取GID
	function getGID($username){
		$group=mysql_fetch_array(mysql_query("select GID from qo_user where Username='{$username}'"));
		return $group["GID"];
	}
	function getGIDByUID($uid){
		$group=mysql_fetch_array(mysql_query("select GID from qo_user where UID='{$uid}'"));
		return $group["GID"];
	}
	
	//获取用户组名
	function getGroupName($gid){
		$group=mysql_fetch_array(mysql_query("select GroupName from qo_group where GID={$gid}"));
		return $group["GroupName"];
	}
	
	//获取用户名
	function getUsername($uid){
		$u=mysql_fetch_array(mysql_query("select Username from qo_user where UID={$uid}"));
		return $u["Username"];
	}
	
	//获取用户主题数
	function getThreadCount($uid){
		return mysql_num_rows(mysql_query("select * from qo_article where UID={$uid}"));
	}
	
	//获取用户回复数
	function getReplyCount($uid){
		return mysql_num_rows(mysql_query("select * from qo_reply where UID={$uid} and Status='通过'"));
	}
	
	//获取用户实体
	function getUser($uid){
		return mysql_fetch_array(mysql_query("select * from qo_user where UID={$uid}"));
	}
	
	//获取总用户数
	function getTotalUser(){
		return mysql_num_rows(mysql_query("select * from qo_user"));
	}
	
	//获取最新会员
	function getLastUser(){
		return mysql_fetch_array(mysql_query("select * from qo_user order by UID desc"));
	}
	
	//消息设为已读
	function setMsgSeen($mid){
		mysql_query("update qo_message set isRead='True' where MID={$mid}");
	}
	
	//会话设为已读
	function setSessionSeen($uid, $talkuid){
		mysql_query("update qo_message set isRead='True' where UID={$talkuid} and ToUID={$uid}");
	}
	
	//获取会话消息数
	function getSessionCount($uid, $talkuid){
		return mysql_num_rows(mysql_query("select * from qo_message where ((UID={$uid} and ToUID={$talkuid}) or (UID={$talkuid} and ToUID={$uid})) and MsgType='Private'"));
	}
	
	//获取未读会话消息数
	function getUnSeenSessionCount($uid, $talkuid){
		return mysql_num_rows(mysql_query("select * from qo_message where UID={$talkuid} and ToUID={$uid} and MsgType='Private' and isRead='False'"));
	}
	
	//获取消息总数
	function getMsgCount($uid){
		return mysql_num_rows(mysql_query("select * from qo_message where ToUID={$uid} and isRead='False'"));
	}
	
	//获取帖子回复消息数
	function getThreadMsgCount($uid){
		return mysql_num_rows(mysql_query("select * from qo_message where ToUID={$uid} and MsgType='Post' and isRead='False'"));
	}
	
	//获取私人消息数
	function getPrivateMsgCount($uid){
		return mysql_num_rows(mysql_query("select * from qo_message where ToUID={$uid} and MsgType='Private' and isRead='False'"));
	}
	
	//根据RID获取TID、在第几页显示
	function findPost($rid){
		$sql="select * from qo_reply where RID={$rid}";
		if(mysql_num_rows(mysql_query($sql))<1) return array();
		$reply=mysql_fetch_array(mysql_query($sql));
		$tid=$reply["TID"];
		$row=mysql_num_rows(mysql_query("select * from qo_reply where TID={$tid} and Status='通过' and RID<={$rid}"));
		$page=$row%10==0 ? $row/10 : floor($row/10)+1;
		$artile["TID"]=$tid;
		$artile["Page"]=$page;
		return $artile;
	}
	
	//根据TID获取UID
	function getUIDFromTID($tid){
		$thread=mysql_fetch_array(mysql_query("select * from qo_article where TID={$tid}"));
		return $thread["UID"];
	}
	
	//根据RID获取UID
	function getUIDFromRID($rid){
		$reply=mysql_fetch_array(mysql_query("select * from qo_reply where RID={$rid}"));
		return $reply["UID"];
	}
	
	//判断RID对应用户是否为会员
	function isUser($rid){
		$reply=mysql_fetch_array(mysql_query("select * from qo_reply where RID={$rid}"));
		return ($reply["UID"]!="");
	}
	
	//获取帖子总数
	function getTotalPost($param){
		//所有
		if($param=="All"){
			$sql="select A.CountA+B.CountB as TotalPost
					from
						(select count(*) as CountA
						 from qo_reply
						 where Status='通过') as A,
						(select count(*) as CountB
						 from qo_article) as B";
		}
		//某日
		else{
			$timeStr="(Time between '{$param} 00:00:00' and '{$param} 23:59:59')";
			$sql="select A.CountA+B.CountB as TotalPost
					from
						(select count(*) as CountA
						 from qo_reply
						 where Status='通过' and {$timeStr}) as A,
						(select count(*) as CountB
						 from qo_article where {$timeStr}) as B";
		}
		$result=mysql_fetch_array(mysql_query($sql));
		return $result["TotalPost"];
	}
	

	//获取格式化后的时间
	function getTime($datetime){
		$date=strtotime(substr(date("Y-m-d H:i:s"),0,10))-strtotime(substr($datetime,0,10));
		$day=(int)($date/(3600*24));
		//相差7天不作修改
		if($day>7){
			return $datetime;
		}
		//...天前
		else if($day>=3&&$day<=7){
			return $day." 天前";
		}
		//前天...
		else if($day==2){
			return " 前天 ".substr($datetime,11,5);
		}
		//昨天...
		else if($day==1){
			return " 昨天 ".substr($datetime,11,5);
		}
		//今天
		else if($day<1){
			$time=time()-strtotime($datetime);
			$hour=(int)(($time%(3600*24))/(3600));
			$min=(int)($time%(3600)/60);
			$sec=(int)($time%(60));
			//...小时前
			if($hour>=1){
				return $hour." 小时前";
			}
			else{
				//半小时前
				if($min>=30){
					return "半小时前";
				}
				//...分钟前
				else if($min>=1&&$min<30){
					return $min." 分钟前";
				}
				//...秒前
				else{
					return $sec." 秒前";
				}
			}
		}
	}
	
	//输出分页(总条目数量，每页条目数，当前页码，最大显示分页数，只有一页时是否不显示)
	function print_page($num,$pagesize,$page,$maxtotalpage,	$onlyone){
		//获取当前文件名
		$url=explode('/',$_SERVER['PHP_SELF']);
		$file=end($url);
		
		$maxPage=$num%$pagesize==0 ? $num/$pagesize : floor($num/$pagesize)+1;//最大页数
		if($maxPage==1 && $onlyone) return;//只有1页时不显示
		//获取GET参数
		$getstr=array();
		foreach($_GET as $key=>$value){
			if($key!="page") $getstr[].=$key."=".$value;
		}
		$string=implode("&",$getstr);
		$prePage=$page-1;
		$nextPage=(isset($_GET["page"]) ? $page : 1)+1;
		if($page>0 && $page<=$maxPage){
			$Count=$maxtotalpage;
			if($page<=$Count/2+1){
				$startPage=1;
				$endPage=$Count+1;
			}else if($page>=$maxPage-$Count/2){
				$startPage=$maxPage-$Count;
				$endPage=$maxPage;
			}else{
				$startPage=$page-$Count/2;
				$endPage=$page+$Count/2;
			}
			
			echo "<div style='padding-right:10px'>";
			echo "<div style='float:right'><table id='page_table' align='center' border='0'><tr>";
			if($page!=1) echo "<td><a href='{$file}?{$string}&page={$prePage}'>«</a></td>";
			if($page-($Count/2)>=4) echo "<td><a href='{$file}?{$string}&page=1'>1..</a></td>";
			for($i=$startPage; $i<=$endPage; $i++){
				if($i==$page){
					echo "<td><span class='current'>{$page}</span></td>";
				}else{
					if($i>0 && $i<=$maxPage){
						echo "<td><a href='{$file}?{$string}&page={$i}'>{$i}</a></td>";
					}
				}
			}
			if($maxPage-($page+$Count/2)>=3) echo "<td><a href='{$file}?{$string}&page={$maxPage}'>..{$maxPage}</a></td>";
			if($page<$maxPage) echo "<td><a href='{$file}?{$string}&page={$nextPage}'>»</a></td>";
			echo "</tr></table></div>";
			echo "<div style='clear:both;float:none;'></div>";
			echo "</div>";
		}
	}
	
	//输出主题列表
	function print_thread($result,$isWithPost){
		$_LANG=$GLOBALS["_LANG"];
		$is_res_empty=true;
		$num=mysql_num_rows($result);
		$i=1;
		echo "<ul>";
		while($arr=mysql_fetch_array($result)){
			$is_res_empty=false;
			if(isset($_GET["mod"])){
				$mod=$_GET["mod"];
			}else{
				$mod="";
			}
			$icon=$arr["ICON"]!=""?"images-icon/{$arr['ICON']}":"images/default_icon.png";
			
			if($mod=="main"){
				echo "<li>";
				$thread_count=mysql_num_rows(mysql_query("select * from qo_article where CID={$arr['CID']}"));
				echo "<div style='float:left;margin-right:10px;'>";
				echo "<a href='article.php?mod=class&cid={$arr['CID']}' style='margin:0px'><img class='forum-icon' src='{$icon}' width='50' height='50' /></a>";
				echo "</div>";
				
				echo "<div><a href='article.php?mod=class&cid={$arr['CID']}' class='title'>{$arr['ClassName']}</a></div>";
				echo "<div><span>帖子：{$thread_count}</span><div>";
				echo "</li>";
			}
			else{
				$reply_count=mysql_num_rows(mysql_query("select * from qo_reply where TID={$arr['TID']} and Status='通过'"));
				echo "<li>";
				echo "<div style='float:left;margin-right:10px;'>";
				echo "<a href='article.php?mod=class&cid={$arr['CID']}' style='margin:0px'><img class='forum-icon' src='{$icon}' width='50' height='50' /></a>";
				echo "</div>";
				
				echo "<div><a href='article.php?mod=class&cid={$arr['CID']}' class='title {$arr['ArticleType']}'>[{$arr['ClassName']}]</a>";
				echo "<span class='title {$arr['ArticleType']}'>[{$_LANG[$arr['ArticleType']]}]</span>";
        		echo "&nbsp;<a href='article.php?mod=view&tid={$arr['TID']}' class='title {$arr['ArticleType']}'>{$arr['Title']}</a>";
				
        		echo "<div><a href='index.php?{$arr['UID']}'>{$arr['Username']}</a>";
        		echo "<span>|</span>";
        		echo "<span>浏览：{$arr['ClickCount']}</span>";
        		echo "<span>|</span>";
        		echo "<span>回复：{$reply_count}</span>";
        		echo "<span>|</span>";
				$time=getTime($arr["Time"]);
        		echo "<span>{$time}</span></div>";
				echo "</li>";
				
				if($isWithPost){
					echo "<li class='myreply'><font class='quote-left'>“</font>";
					echo "<div style='float:left'>{$arr['ReplyContent']}</div>";
					echo "<font class='quote-right'>”</font>";
					echo "<div style='clear:both;float:none'></div>";
					echo "</li>";
					echo "<div style='clear:both;float:none'></div>";
				}
			}
			if(basename($_SERVER["PHP_SELF"])=="index.php"){
				if($num>10 || $i<$num) echo "<hr />";
			}else{
				echo "<hr />";
			}
			$i++;
		}
        echo "</ul>";
		
		if($is_res_empty) echo "<div class='no-result'>还没有相关的帖子</div>";
	}
	
	//相对路径转绝对路径
	function format_url($srcurl, $baseurl){
		$srcinfo=parse_url($srcurl);
		if(isset($srcinfo['scheme'])){
			return $srcurl;
		}
		$baseinfo=parse_url($baseurl);
		$url=$baseinfo['scheme'].'://'.$baseinfo['host'];
		if(substr($srcinfo['path'], 0, 1)=='/'){
			$path=$srcinfo['path'];
		}else{
			$path=dirname($baseinfo['path']).'/'.$srcinfo['path'];
		}
		$rst=array();
		$path_array=explode('/', $path);
		if(!$path_array[0]){
			$rst[]='';
		}
		foreach ($path_array as $key => $dir){
			if ($dir=='..'){
				if(end($rst)=='..'){
					$rst[]='..';
				}elseif(!array_pop($rst)){
					$rst[]='..';
				}
			}elseif($dir && $dir!='.'){
				$rst[]=$dir;
			}
		}
		if(!end($path_array)){
			$rst[]='';
		}
		$url.=implode('/', $rst);
		return str_replace('\\', '/', $url);
	}
	
	//权限检查
	function chkAuth($authority){
		if(isset($_SESSION["qo_user"])){
			if(getUID($_SESSION["qo_user"])==getSetting("RootUser")) return true;
			$gid=getGID($_SESSION["qo_user"]);
		}else{
			$gid=getSetting("VisitorGroup");
		}
		$result=mysql_fetch_array(mysql_query("select Authority from qo_group where GID={$gid}"));
		$auths=explode(";",$result["Authority"]);
		if(in_array(getAuthID($authority),$auths)){
			return true;
		}else{
			return false;
		}
	}
?>