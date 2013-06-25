<?php  
$sourceFile = "http://dldir1.qq.com/music/clntupate/QQMusic_Setup_91_910.exe"; //要下载的临时文件名  
$outFile = "c:\\download\\" . "QQMusic_Setup_91_910.exe"; //下载保存到客户端的文件名  
$file_extension = strtolower(substr(strrchr($sourceFile, "."), 1)); //获取文件扩展名  
//echo $sourceFile;  
/*if (!is_file($sourceFile)) {  
    die("<b>404 File not found!</b>");  
} */ 
//$len = filesize($sourceFile);
$filename = basename($sourceFile); //获取文件名字  
$outFile_extension = strtolower(substr(strrchr($outFile, "."), 1)); //获取文件扩展名  
//根据扩展名 指出输出浏览器格式  
switch ($outFile_extension) {  
    case "exe" :  
        $ctype = "application/octet-stream";  
        break;  
    case "zip" :  
        $ctype = "application/zip";  
        break;  
    case "mp3" :  
        $ctype = "audio/mpeg";  
        break;  
    case "mpg" :  
        $ctype = "video/mpeg";  
        break;  
    case "avi" :  
        $ctype = "video/x-msvideo";  
        break;  
    default :  
        $ctype = "application/octet-stream";  
}  
//Begin writing headers  
header("Cache-Control:");  
header("Cache-Control: public");  
  
//设置输出浏览器格式  
header("Content-Type: $ctype");  
header("Content-Disposition: attachment; filename=" . $outFile);  
header("Accept-Ranges: bytes");  
$size = filesize($sourceFile);  
//如果有$_SERVER['HTTP_RANGE']参数  
if (isset ($_SERVER['HTTP_RANGE'])) {  
    /*Range头域 　　Range头域可以请求实体的一个或者多个子范围。  
    例如，  
    表示头500个字节：bytes=0-499  
    表示第二个500字节：bytes=500-999  
    表示最后500个字节：bytes=-500  
    表示500字节以后的范围：bytes=500- 　　  
    第一个和最后一个字节：bytes=0-0,-1 　　  
    同时指定几个范围：bytes=500-600,601-999 　　  
    但是服务器可以忽略此请求头，如果无条件GET包含Range请求头，响应会以状态码206（PartialContent）返回而不是以200 （OK）。  
    */  
    // 断点后再次连接 $_SERVER['HTTP_RANGE'] 的值 bytes=4390912-  
    list ($a, $range) = explode("=", $_SERVER['HTTP_RANGE']);  
    //if yes, download missing part  
    str_replace($range, "-", $range); //这句干什么的呢。。。。  
    $size2 = $size -1; //文件总字节数  
    $new_length = $size2 - $range; //获取下次下载的长度  
    header("HTTP/1.1 206 Partial Content");  
    header("Content-Length: $new_length"); //输入总长  
    header("Content-Range: bytes $range$size2/$size"); //Content-Range: bytes 4908618-4988927/4988928   95%的时候  
} else {  
    //第一次连接  
    $size2 = $size -1;  
    header("Content-Range: bytes 0-$size2/$size"); //Content-Range: bytes 0-4988927/4988928  
    header("Content-Length: " . $size); //输出总长  
}  
//打开文件  
$fp = fopen("$sourceFile", "rb");  
//设置指针位置  
fseek($fp, $range);  
$savefp = fopen($outFile,"a+") or die("写入文件 $outFile 失败！");

//new bean which save to temp file;
$tmpsave = new filebean();
$tmpsave->fileurl=$sourceFile;
$tmpsave->filename=$outFile;

//open temp file
$tempfilename = $outFile . ".tmp";
$tempfilepath = $tempfilename;
if(file_exists($tempfilepath)){
	$tempfp = fopen($tempfilepath,"r") or die("error to read file $tempfilename");
$tmpstring="";
while(!feof($tempfp)){
	$tmpstring.=fgets($tempfp);
}
print($tempfp);
$fparray = new filebean();
$fparray = unserialize($tmpstring);
print("oldurl:" . $fparray->fileurl);
print("newurl" . $sourceFile);
print("oldname:" . $fparray->filename);
print("newname:" . $outFile);
if(($fparray->fileurl==$sourceFile)&&($fparray->filename==$outFile)){
	//$this->m_fp=$fparray->downfp;
	fseek($fp,$fparray->downfp);
	echo "当前网络文件指针：" . ftell($fp) . "<br/>";
	echo "记录的文件指针：" . $fparray->downfp . "<br/>";
	//$fp=$fparray->filefp;
}
}else{
	$tempfp = fopen($tempfilepath,"w") or die("error to create file $tempfilename");
}	
@fclose($tempfp);

$dlsize = 0; // set download size to 0;
//虚幻输出  
while (!feof($fp)) {  
    //设置文件最长执行时间  
    set_time_limit(0);
    
    //write offset to temp file;
    $tempfp = fopen($tempfilepath,"w+") or die("write $tempfilename error!");
    
    @fwrite ($savefp, fread($fp, 1024 * 8)); //输出文件  
    
    $tmpsave->downfp=ftell($fp);
    $fpString = serialize($tmpsave);
    rewind($tempfp);
    @fwrite($tempfp,$fpString);
    @fclose($tmpfp);
    
    print("ok!");
    
    flush(); //输出缓冲  
    ob_flush();  
}  
@fclose($savefp);
@fclose($fp);  
exit ();

class filebean{
	public $filename;
	public $fileurl;
	public $downfp;
	public $filefp;
	
	function __construct(){
		$filename="";
		$fileurl="";
		$downfp="";
		$filefp="";
	}
}