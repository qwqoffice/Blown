<?php include("wechat.php")?>
<?php
		session_start();
		require_once("db.php");
		require_once("lang_zh.php");
		require_once("func.php");
		autoLogin();//自动登录
		
		$kwd="";
		if(isset($_GET["kwd"])) $kwd=$_GET["kwd"];
?>
<div id="header">
	<div id="header-mid">
    	<div id="logo"><a href="index.php"><img src="images/logo.png" width="117" height="40" title="QwqOffice软件工作室" /></a></div>
        <?php
			$curUrl=urlencode($_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
			
			echo "<div class='float-right'>";
			if(isset($_SESSION["qo_user"])){
				$uid=getUID($_SESSION["qo_user"]);
				
				//头像、用户名
				echo "<a href='home.php?mod=spc'><img class='avatar-small' src='avatar.php?uid={$uid}&size=small' width='25' height='25' /></a>";
				echo "<span class='vertical-middle'></span>";
				echo "<span class='user'><a href='home.php?mod=spc'>{$_SESSION['qo_user']}</a></span>";
				//设置
				echo "<span class='user-info'><a href='home.php?mod=pref'>设置</a></span>";
				echo "<span class='user-info-sp'>|</span>";
				//消息
				echo "<span class='user-info'><a href='home.php?mod=notice'>消息";
				$msgcount=getMsgCount($uid);
				if($msgcount>0) echo "<em class='msgcount'>{$msgcount}</em>";
				echo "</a></span>";
				echo "<span class='user-info-sp'>|</span>";
				//管理中心
				if(chkAuth("Manage")){
					echo "<span class='user-info'><a href='admin.php'>管理中心</a></span>";
					echo "<span class='user-info-sp'>|</span>";
				}
				echo "<span class='user-info'><a href='logout.php?url={$curUrl}'>退出</a></span>";				
			}else{
				echo "<span class='user-info'><a href='login.php?url={$curUrl}'>登录</a></span>";
				echo "<span class='user-info-sp'>|</span>";
				echo "<span class='user-info'><a href='register.php'>注册</a></span>";
			}
			echo "</div>";
		?>
    <form id="search" action="article.php" method="get">
    	<input type="hidden" name="mod" value="search" />
    	<input class="text" type="text" name="kwd" autocomplete="off" placeholder="搜索主题" value="<?php echo $kwd; ?>" />
        <input class="btn" type="submit" value=" " />
    </form>
    </div>
</div>


<?php
	echo "<div id='navi'>";
	echo "<ul id='nav-ul'>";
	//一级导航
	$result=mysql_query("select * from qo_class where Parent=0 order by Sequence");
	while($l1=mysql_fetch_array($result)){
		$link="article.php?mod=main&cid={$l1['CID']}";
		if($l1["Link"]!="") $link=$l1["Link"];
		echo "<li>";
		echo "<a href='{$link}'>{$l1['ClassName']}</a>";
		//二级导航
		$result1=mysql_query("select * from qo_class where Parent={$l1['CID']} order by Sequence");
		if(mysql_num_rows($result1)>0){
    	    echo "<div id='outer'>";
        	echo "<div id='inner'>";
        	echo "<dl>";
			while($l2=mysql_fetch_array($result1)){
				$link="article.php?mod=class&cid={$l2['CID']}";
				if($l2["Link"]!="") $link=$l2["Link"];
        		echo "<dd><a href='{$link}'>{$l2['ClassName']}</a></dd>";
			}
        	echo "</dl>";
        	echo "</div>";
        	echo "</div>";
		}
		echo "</li>";
	}
	echo "</ul>";
	echo "</div>";
?>