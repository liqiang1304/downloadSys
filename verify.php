<?php
/*
 * Created on 2013-6-21
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 $username = $_POST["login_username"];
 $password = $_POST["login_password"];

 $configbean = new setbean();
 $fp = fopen("confg.ini","r") or die("Can't open config file!'");
 $freadstring = "";
 while(!feof($fp)){
 	$freadstring .= fgets($fp);
 }
 $configbean = unserialize($freadstring);
 
 if($username==$configbean->username&&$password==$configbean->password){
 	session_start();
 	$_SESSION['login']="true";
 	echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=index.php\">";
 }else{
 	echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=login.php\">";
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
