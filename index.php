<?php
session_start();
if($_SESSION['login']!="true"){
	echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=login.php\">";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
      <li><a href="#">首页</a></li>
      <li><a href="dlmanage.php">下载文件管理</a></li>
      <li><a href="settings.php">系统设置</a></li>
      <li><a href="about.php">关于</a></li>
    </ul>
    <p align="right"><a style="color:red;" href="logout.php">登出</a></p>
    
    <!-- end .sidebar1 --></div>
  <div class="content">
    <h1>开始下载</h1>
    <form action="geturl.php" method="post">
    <p>　下载地址：<input id="downloadURL" name="downloadURL" type="text" size="50"/></p>
    <p>保存文件名：<input id="filename" name="filename" type="text" size="20"/> (若不填写则自动获取)</p>
    <p>　后台下载：<input type="checkbox" id="bg" name="bg"/> (若不勾选，关闭下载窗口后，下载自动停止)</p>
    <p>　点击下载：<input type="button" value="下载" onclick="dl()" /></p>
    <p id="returnValue" name="returnValue"></p>
    </form>
    <h2>使用方法</h2>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;想下载国外资源，网速很慢？买迅雷离线下载，太贵？如今国内外支持php免费主机多如牛毛，何不使用本软件下载，免费方便又快捷。您在上方地址栏输入需要下载的东西的地址，并输入保存文件名（若不输入则自动获取下载文件名），就可快速完成下载。若想检视下载速度以及进度，则不要关闭下载窗口，由于技术原因，关闭后不能再检视下载，但下载会在后台继续进行。下载完成后您会获取一个下载地址，可以以更快的速度从您的服务器上下载您所需要的。</p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;目前只支持普通下载，不支持BT、迅雷等特殊下载。下载速度受限于您使用的服务器的带宽及服务器所在国家。取回本地时，取决于您的本地带宽，以及您与您的服务器所连接的速度。</p>
    <!-- end .content --></div>
  <div class="footer">
    <p>版权所有(c) 2013 Copyright. 同济大学 李锵. 请保留版权信息 本作品遵循 <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/2.5/cn/"><img alt="知识共享许可协议" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-nd/2.5/cn/80x15.png" /></a><a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/2.5/cn/"> 知识共享署名-非商业性使用-禁止演绎 2.5 中国大陆许可协议</a>进行许可。 </p>
   	
    <!-- end .footer --></div>
  <!-- end .container --></div>
  
  <script type="text/javascript">
  	function jsDownload(){
		var url=document.getElementById("downloadURL").value;
		var xmlhttp;
		if (window.XMLHttpRequest){
			// code for IE7+, Firefox, Chrome, Opera, Safari
 			 xmlhttp=new XMLHttpRequest();
 		}
		else{
			// code for IE6, IE5  && (xmlhttp.status==200)
 		 	xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 		}
 		var len=0;
 		xmlhttp.onreadystatechange=function(){
 			if ((xmlhttp.readyState>=2)){
 				//var returnStr=xmlhttp.responseText;
 				//returnStr.replace( {1024},"");
 				//document.getElementById("returnValue").innerHTML=returnStr.substring(len,returnStr.length);
 					document.getElementById("returnValue").innerHTML=xmlhttp.responseText;
 					//document.getElementById("returnValue").innerHTML=xmlhttp.readyState;
 				//len=returnStr.length;
 			}
 		}
 		xmlhttp.open("POST","download.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("postURL="+url);
	}
	
	function dl(){
		var getUrl=document.getElementById("downloadURL").value;
		var filename=document.getElementById("filename").value;
		if(document.getElementById("bg").checked){
			var bg="true";
		}else{
			var bg="false";
		}
		window.open ('watching.php?postURL='+getUrl+"&filename="+filename+"&bg="+bg, "_blank", "toolbar=no, location=yes, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=yes, width=600, height=400");
	}

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