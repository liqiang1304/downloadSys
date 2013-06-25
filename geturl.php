<meta http-equiv="Refresh" content="0; url=index.php" />
<?php include 'download.php'; ?>
<?php
/*
 * Created on 2013-5-29
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 //sleep(1);
 $url=$_POST["downloadURL"];
 while(true){
 	ob_end_flush(); //关闭php缓存，或者在flush前ob_flush();
				echo str_repeat(" ", 1024); //ie下 需要先发送256个字节, firefox 1024, chrome 2048
				set_time_limit(0);
 	echo("test<br/>");
 	sleep(1);
 	flush();
 }
 //ignore_user_abort(true); // 后台运行
 fileDownload($url);
?>
