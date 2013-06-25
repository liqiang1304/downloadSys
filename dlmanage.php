<?php
date_default_timezone_set("PRC");
?>
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
      <li><a href="#">下载文件管理</a></li>
      <li><a href="settings.php">系统设置</a></li>
      <li><a href="about.php">关于</a></li>
    </ul>
    <p align="right"><a style="color:red;" href="logout.php">登出</a></p>
    
    <!-- end .sidebar1 --></div>
  <div class="content">
  	<h1>下载文件管理</h1>
  	
  	<?php
  		$configbean = new setbean();
  		$fp = fopen("confg.ini","r") or die("Can't open config file!'");
  		$freadstring = "";
  		while(!feof($fp)){
  			$freadstring .= fgets($fp);
  		}
  		$configbean = unserialize($freadstring);
  	?>
  	<table border="1px" cellspacing="0px" style="border-collapse:collapse" width="90%">
  	<tr>
  	<td><b>文件名</b></td>
  	<td><b>文件大小</b></td>
  	<td><b>下载日期</b></td>
  	<td><b>下载地址</b></td>
  	<td><b>删除文件</b></td>
  	</tr>
  	<?php
  		listDir($configbean->path);
  	?>
  	</table>
    <!-- end .content --></div>
  <div class="footer">
    <p>版权所有(c) 2013 Copyright. 同济大学 李锵. 请保留版权信息 本作品遵循 <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/2.5/cn/"><img alt="知识共享许可协议" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-nd/2.5/cn/80x15.png" /></a><a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/2.5/cn/"> 知识共享署名-非商业性使用-禁止演绎 2.5 中国大陆许可协议</a>进行许可。 </p>
   	
    <!-- end .footer --></div>
  <!-- end .container --></div>
  
  <script type="text/javascript">  	
  	function deletefile(filepath){
  		var r = confirm("是否删除文件: "+filepath+" ?");
			if (r == true) {
				window.location = "deletefile.php?path=" + filepath ;
			}
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
 
 function listDir($dir){ 
	if(is_dir($dir)){ 
		if ($dh = opendir($dir)) { 
			while (($file= readdir($dh)) !== false){ 
				if((is_dir($dir."/".$file)) && $file!="." && $file!=".."){ 
					//echo "<b><font color='red'>文件名：</font></b>",$file,"<br><hr>"; 
					//listDir($dir."/".$file."/"); 
				}else{ 
					if($file!="." && $file!=".."){ 
						$tmpfile = $dir . "/" . $file;
						echo "<tr>";
						echo "<td> $file </td>";
						echo "<td>" . filesize($tmpfile) . "字节 </td>";
						echo "<td>" . date("Y-m-d H:i:s",filectime($tmpfile)) . "</td>";
						echo "<td><a href=\"$dir/$file\" style=\"color:blue;\">下载 </a></td>";
						echo "<td><a style=\"color:red;\" href=\"javascript:deletefile('$tmpfile')\">删除</a></td>";
						echo "</tr>";
					} 
				} 
			} 
			closedir($dh); 
			} 
		}else{
			echo "The path $dir error! Please check it.";
		}
	} 
 
 
  class setbean{
	public $username;
	public $password;
	public $path;
	
	function __construct(){
		$username="";
		$password="";
		$path="";
	}
}
?>