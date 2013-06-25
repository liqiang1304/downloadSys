<?php
/*
 * Created on 2013-6-21
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
$deletefile =!empty($_GET["path"])?$_GET["path"]:null;
if(file_exists($deletefile)){
	unlink($deletefile);
}
echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=dlmanage.php\">";
?>
