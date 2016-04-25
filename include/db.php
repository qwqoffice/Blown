<?php
	error_reporting(E_ALL ^ E_DEPRECATED);
	mysql_connect("localhost", "root", "");
	mysql_query("set names utf8");
	mysql_select_db("qwqoffice");
?>