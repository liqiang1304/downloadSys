<?php
session_start();
if($_SESSION['login']!="true"){
	echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=login.php\">";
}
?>
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
      <li><a href="dlmanage.php">下载文件管理</a></li>
      <li><a href="#">系统设置</a></li>
      <li><a href="about.php">关于</a></li>
    </ul>
     <p align="right"><a style="color:red;" href="logout.php">登出</a></p>
    
    <!-- end .sidebar1 --></div>
  <div class="content">
  	<form id="sbmfrm" method="post" action="saveset.php">
    <h1 align="center">系统设置管理</h1>
    <h3>下载设置</h3>
    <table align="center">
    <tr>
    <td>保存地址：</td>
    <td><input id="path" name="path" type="text"/></td>
    </tr>
    </table>
    <br/>
    <h3>用户设置</h3>
    <table align="center">
    <tr>
    <td align="right">用户名：</td>
    <td><input id="username" name="username"  type="text"/></td>
    </tr>
    <tr>
    <td align="right">密码：</td>
    <td><input id="password" name="password" type="text"/></td>
    </tr>
    </table>
    <br/>
    <table align="center">
    <tr>
    <td>
    <input align="center" type="button" value="保存" onclick="sbmt()" />
    </td>
    </tr>
    </table>
    </form>
    <!-- end .content --></div>
  <div class="footer">
    <p>版权所有(c) 2013 Copyright. 同济大学 李锵. 请保留版权信息 本作品遵循 <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/2.5/cn/"><img alt="知识共享许可协议" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-nd/2.5/cn/80x15.png" /></a><a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/2.5/cn/"> 知识共享署名-非商业性使用-禁止演绎 2.5 中国大陆许可协议</a>进行许可。 </p>
   	
    <!-- end .footer --></div>
  <!-- end .container --></div>
  
  <script type="text/javascript">
  	function sbmt(){
  		var path = document.getElementById("path").value;
  		var username = document.getElementById("username").value;
  		var password = document.getElementById("password").value;
  		
  		if(path==""||username==""||password==""){
  			alert("请填写完所有信息后再保存");
 	 	}else{
 	 		document.getElementById("sbmfrm").submit();
 	 	}
  	}
  	
  	<?php
  		if($_GET["status"]==1){
  	?>
  		alert("保存信息成功！");
  	<?php
  		}
  	?>
  	
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