<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GBK" />
<title>加速离线下载系统</title>
<link href="twoColLiqRtHdr.css" rel="stylesheet" type="text/css" /><!--[if lte IE 7]>
<style>
.content { margin-right: -1px; } /* 此 1px 负边距可以放置在此布局中的任何列中，且具有相同的校正效果。 */
ul.nav a { zoom: 1; }  /* 缩放属性将为 IE 提供其需要的 hasLayout 触发器，用于校正链接之间的额外空白 */
</style>
<![endif]-->
</head>

<body background="images/bg.jpg">

<div class="container">
  <div class="header"><a href="#"><img src="images/logo.jpg" alt="在此处插入徽标" name="Insert_logo" width="20%" height="90" id="Insert_logo" style="background-color: #8090AB; display:block;" /></a> 
    <!-- end .header --></div>
  <div class="sidebar1">
    <ul class="nav">
      <li><a href="index.php">首页</a></li>
      <li><a href="#">下载文件管理</a></li>
      <li><a href="settings.php">系统设置</a></li>
      <li><a href="about.php">关于</a></li>
    </ul>
    <p align="right"><a style="color:red;" href="logout.php">登出</a></p>
    
    <!-- end .sidebar1 --></div>
  <div class="content">
  <h1 align="center">关于</h1>
	<p>关于该系统：<p>
	<p>&nbsp;&nbsp;&nbsp;&nbsp;该系统经测试能在自己搭建的php环境中运行，而上网的免费的服务器由于php的安全机制过于严格，许多函数被禁用，因此该程序可能会工作不正常。此外在使用此程序之前，请把该根目录下查看修改confg.ini文件的权限禁止，因为其包涵该系统信息及账户信息。此程序可提供每次一个文件的离线下载至服务器并取回本地，至于网速已在首页申明。</p>
	<p>关于作者：</p>	
  	<p>&nbsp;&nbsp;&nbsp;&nbsp;作者乃同济大学软件学院大二学生，由于web客户端开发这门课要写一个期末项目，于是想写一个实用性强的项目。于是出此策写了一个离线下载系统，其在本地工作情况良好，但在网上的服务器中工作取决于服务器的权限。这是很令人忧伤的一件事情。但是我发现wordpress也是用php写的，但是他的功能十分完整，于是我打算参考其思想，避开服务器中的那些安全机制强的部分，使用比较安全的函数进行编写程序，可能会解决这一问题。</p>
  	
    <!-- end .content --></div>
  <div class="footer">
    <p>版权所有(c) 2013 Copyright. 同济大学 李锵. 请保留版权信息 本作品遵循 <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/2.5/cn/"><img alt="知识共享许可协议" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-nd/2.5/cn/80x15.png" /></a><a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/2.5/cn/"> 知识共享署名-非商业性使用-禁止演绎 2.5 中国大陆许可协议</a>进行许可。 </p>
   	
    <!-- end .footer --></div>
  <!-- end .container --></div>
  
  <script type="text/javascript">
  	
  </script>
</body>
</html>

<?php


/*
 * Created on 2013-5-29
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
?>