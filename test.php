<?php
header("Content-Type:text/html; charset=utf-8");
include_once "httpdownload.php";
$file = "http://dldir1.qq.com/qqfile/qq/QQ2013/2013Beta4/6741/QQ2013Beta4.exe"; //�������ļ���,����·��
$filename = "qq.exe";    //�������Ϊ���ļ���
/*if (!$file || !file_exists($file)) {
echo("��Ҫ���ص��ļ������ڣ�����<a href=\"index.php\" mce_href=\"index.php\">����</a>������ҳ��");
exit();
}*/
$object = new httpdownload();
$object->set_byfile($file);
$object->filename = $filename;
$object->download();
?>
