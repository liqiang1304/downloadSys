<?php
/*
 * Created on 2013-6-21
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
session_start();
unset($_SESSION['login']);
session_destroy();
echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=login.php\">";
?>
