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
<title>������������ϵͳ</title>
<link href="twoColLiqRtHdr.css" rel="stylesheet" type="text/css" /><!--[if lte IE 7]>
<style>
.content { margin-right: -1px; } /* �� 1px ���߾���Է����ڴ˲����е��κ����У��Ҿ�����ͬ��У��Ч���� */
ul.nav a { zoom: 1; }  /* �������Խ�Ϊ IE �ṩ����Ҫ�� hasLayout ������������У������֮��Ķ���հ� */
</style>
<![endif]-->
</head>

<body background="images/bg.jpg">

<div class="container">
  <div class="header"><a href="#"><img src="images/logo.jpg" alt="�ڴ˴�����ձ�" name="Insert_logo" width="20%" height="90" id="Insert_logo" style="background-color: #8090AB; display:block;" /></a> 
    <!-- end .header --></div>
  <div class="sidebar1">
    <ul class="nav">
      <li><a href="index.php">��ҳ</a></li>
      <li><a href="#">�����ļ�����</a></li>
      <li><a href="settings.php">ϵͳ����</a></li>
      <li><a href="about.php">����</a></li>
    </ul>
    <p align="right"><a style="color:red;" href="logout.php">�ǳ�</a></p>
    
    <!-- end .sidebar1 --></div>
  <div class="content">
  	<h1>�����ļ�����</h1>
  	
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
  	<td><b>�ļ���</b></td>
  	<td><b>�ļ���С</b></td>
  	<td><b>��������</b></td>
  	<td><b>���ص�ַ</b></td>
  	<td><b>ɾ���ļ�</b></td>
  	</tr>
  	<?php
  		listDir($configbean->path);
  	?>
  	</table>
    <!-- end .content --></div>
  <div class="footer">
    <p>��Ȩ����(c) 2013 Copyright. ͬ�ô�ѧ ����. �뱣����Ȩ��Ϣ ����Ʒ��ѭ <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/2.5/cn/"><img alt="֪ʶ�������Э��" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-nd/2.5/cn/80x15.png" /></a><a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/2.5/cn/"> ֪ʶ��������-����ҵ��ʹ��-��ֹ���� 2.5 �й���½���Э��</a>������ɡ� </p>
   	
    <!-- end .footer --></div>
  <!-- end .container --></div>
  
  <script type="text/javascript">  	
  	function deletefile(filepath){
  		var r = confirm("�Ƿ�ɾ���ļ�: "+filepath+" ?");
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
					//echo "<b><font color='red'>�ļ�����</font></b>",$file,"<br><hr>"; 
					//listDir($dir."/".$file."/"); 
				}else{ 
					if($file!="." && $file!=".."){ 
						$tmpfile = $dir . "/" . $file;
						echo "<tr>";
						echo "<td> $file </td>";
						echo "<td>" . filesize($tmpfile) . "�ֽ� </td>";
						echo "<td>" . date("Y-m-d H:i:s",filectime($tmpfile)) . "</td>";
						echo "<td><a href=\"$dir/$file\" style=\"color:blue;\">���� </a></td>";
						echo "<td><a style=\"color:red;\" href=\"javascript:deletefile('$tmpfile')\">ɾ��</a></td>";
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