<?php
header("Content-Type:text/html; charset=utf-8");
include_once "httpdownload.php";
$file = "http://dldir1.qq.com/qqfile/qq/QQ2013/2013Beta4/6741/QQ2013Beta4.exe"; //服务器文件名,包括路径
$filename = "qq.exe";    //下载另存为的文件名
/*if (!$file || !file_exists($file)) {
echo("您要下载的文件不存在，单击<a href=\"index.php\" mce_href=\"index.php\">这里</a>返回首页。");
exit();
}*/
$object = new httpdownload();
$object->set_byfile($file);
$object->filename = $filename;
$object->download();
?>
