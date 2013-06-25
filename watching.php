<?php
/*
 * Created on 2013-6-3
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 	set_time_limit(0);
 	$urlString=!empty($_GET["postURL"])?$_GET["postURL"]:null;
 	$fileName=!empty($_GET["filename"])?$_GET["filename"]:basename($urlString);
 	$bg=!empty($_GET["bg"])?$_GET["postURL"]:"false";
 	if(!filter_var($urlString, FILTER_VALIDATE_URL)){
 		$fileName="URL无效，请重新输入！";
 	}
?>
<?php
session_start();
if($_SESSION["login"]!="true"){
	echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=login.php\">";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>下载-<?php echo $fileName; ?></title>
	<style>
	#processBg{background-color:#B9F8F9;z-index:10;}
	#processBk{border-style: solid; border-color:#B9F8F9; width:100px;}
	</style>
</head>
<body>
	<h1 align="center">正在下载</h1>
	<h3>文件名：<?php echo $fileName; ?></h3>
	<p id="sizeoffile">文件大小：</p>
	<p>下载进度：<div id="processBk"><div id="processBg"><p id="process" style="display : inline;"></p></div></div></p>
	<p>下载速度：<p id="content" style="display : inline;"></p></p><br/>
	<p>说明：<p id="explan" style="display : inline;"></p></p><br/>
	<p align="right" style="color:gray;"><input type="button" value="关闭下载" name="name" onclick="javascript: window.close();"/>若要检视下载，请勿关闭此页面。<p>
	<iframe frameborder="0" height="500" src="download.php?postURL=<?php echo $urlString; ?>&filename=<?php echo $fileName; ?>"></iframe>
	
	<script type="text/javascript">

	var content = document.getElementById('content');
	var dumpText = function(text){
		content.innerHTML = text;
	}
	var process = document.getElementById('process');
	var processBg = document.getElementById('processBg');
	var processText = function(text){
		process.innerHTML = text;
		processBg.style.width = parseInt(text) + "px";
	}
	var sizeoffile = document.getElementById('sizeoffile');
	var displayfile = function(filesize){
		sizeoffile.innerHTML = filesize;
	}
	var explan = document.getElementById('explan');
	var displayexplan = function(content){
		explan.innerHTML = content;
	}
	</script>
</body>
</html>
