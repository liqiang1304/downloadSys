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
      <li><a href="dlmanage.php">�����ļ�����</a></li>
      <li><a href="#">ϵͳ����</a></li>
      <li><a href="about.php">����</a></li>
    </ul>
     <p align="right"><a style="color:red;" href="logout.php">�ǳ�</a></p>
    
    <!-- end .sidebar1 --></div>
  <div class="content">
  	<form id="sbmfrm" method="post" action="saveset.php">
    <h1 align="center">ϵͳ���ù���</h1>
    <h3>��������</h3>
    <table align="center">
    <tr>
    <td>�����ַ��</td>
    <td><input id="path" name="path" type="text"/></td>
    </tr>
    </table>
    <br/>
    <h3>�û�����</h3>
    <table align="center">
    <tr>
    <td align="right">�û�����</td>
    <td><input id="username" name="username"  type="text"/></td>
    </tr>
    <tr>
    <td align="right">���룺</td>
    <td><input id="password" name="password" type="text"/></td>
    </tr>
    </table>
    <br/>
    <table align="center">
    <tr>
    <td>
    <input align="center" type="button" value="����" onclick="sbmt()" />
    </td>
    </tr>
    </table>
    </form>
    <!-- end .content --></div>
  <div class="footer">
    <p>��Ȩ����(c) 2013 Copyright. ͬ�ô�ѧ ����. �뱣����Ȩ��Ϣ ����Ʒ��ѭ <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/2.5/cn/"><img alt="֪ʶ�������Э��" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-nd/2.5/cn/80x15.png" /></a><a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/2.5/cn/"> ֪ʶ��������-����ҵ��ʹ��-��ֹ���� 2.5 �й���½���Э��</a>������ɡ� </p>
   	
    <!-- end .footer --></div>
  <!-- end .container --></div>
  
  <script type="text/javascript">
  	function sbmt(){
  		var path = document.getElementById("path").value;
  		var username = document.getElementById("username").value;
  		var password = document.getElementById("password").value;
  		
  		if(path==""||username==""||password==""){
  			alert("����д��������Ϣ���ٱ���");
 	 	}else{
 	 		document.getElementById("sbmfrm").submit();
 	 	}
  	}
  	
  	<?php
  		if($_GET["status"]==1){
  	?>
  		alert("������Ϣ�ɹ���");
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