<?php
/*
 * Created on 2013-6-21
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 try{
 $fp = fopen("confg.ini","w+") or die("Can't not open the config file, please try again later!'");
 $settings = new setbean();
 $settings->username = !empty($_POST["username"])?$_POST["username"]:null;
 $settings->password = !empty($_POST["password"])?$_POST["password"]:null;
 $settings->path = !empty($_POST["path"])?$_POST["path"]:null;
 $saveString = serialize($settings);
 @fwrite($fp,$saveString);
 @fclose($fp);
 if($settings->username!=null&&$settings->path!=null&&$settings->password!=null){
 	echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=settings.php?status=1\">";
 }else{
 	echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=settings.php?status=0\">";
 }
 }
 catch(Exception $e){
 	print($e);
 	echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=settings.php?status=0\">";
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
