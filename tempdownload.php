<?php  
$sourceFile = "http://dldir1.qq.com/music/clntupate/QQMusic_Setup_91_910.exe"; //Ҫ���ص���ʱ�ļ���  
$outFile = "c:\\download\\" . "QQMusic_Setup_91_910.exe"; //���ر��浽�ͻ��˵��ļ���  
$file_extension = strtolower(substr(strrchr($sourceFile, "."), 1)); //��ȡ�ļ���չ��  
//echo $sourceFile;  
/*if (!is_file($sourceFile)) {  
    die("<b>404 File not found!</b>");  
} */ 
//$len = filesize($sourceFile);
$filename = basename($sourceFile); //��ȡ�ļ�����  
$outFile_extension = strtolower(substr(strrchr($outFile, "."), 1)); //��ȡ�ļ���չ��  
//������չ�� ָ������������ʽ  
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
  
//��������������ʽ  
header("Content-Type: $ctype");  
header("Content-Disposition: attachment; filename=" . $outFile);  
header("Accept-Ranges: bytes");  
$size = filesize($sourceFile);  
//�����$_SERVER['HTTP_RANGE']����  
if (isset ($_SERVER['HTTP_RANGE'])) {  
    /*Rangeͷ�� ����Rangeͷ���������ʵ���һ�����߶���ӷ�Χ��  
    ���磬  
    ��ʾͷ500���ֽڣ�bytes=0-499  
    ��ʾ�ڶ���500�ֽڣ�bytes=500-999  
    ��ʾ���500���ֽڣ�bytes=-500  
    ��ʾ500�ֽ��Ժ�ķ�Χ��bytes=500- ����  
    ��һ�������һ���ֽڣ�bytes=0-0,-1 ����  
    ͬʱָ��������Χ��bytes=500-600,601-999 ����  
    ���Ƿ��������Ժ��Դ�����ͷ�����������GET����Range����ͷ����Ӧ����״̬��206��PartialContent�����ض�������200 ��OK����  
    */  
    // �ϵ���ٴ����� $_SERVER['HTTP_RANGE'] ��ֵ bytes=4390912-  
    list ($a, $range) = explode("=", $_SERVER['HTTP_RANGE']);  
    //if yes, download missing part  
    str_replace($range, "-", $range); //����ʲô���ء�������  
    $size2 = $size -1; //�ļ����ֽ���  
    $new_length = $size2 - $range; //��ȡ�´����صĳ���  
    header("HTTP/1.1 206 Partial Content");  
    header("Content-Length: $new_length"); //�����ܳ�  
    header("Content-Range: bytes $range$size2/$size"); //Content-Range: bytes 4908618-4988927/4988928   95%��ʱ��  
} else {  
    //��һ������  
    $size2 = $size -1;  
    header("Content-Range: bytes 0-$size2/$size"); //Content-Range: bytes 0-4988927/4988928  
    header("Content-Length: " . $size); //����ܳ�  
}  
//���ļ�  
$fp = fopen("$sourceFile", "rb");  
//����ָ��λ��  
fseek($fp, $range);  
$savefp = fopen($outFile,"a+") or die("д���ļ� $outFile ʧ�ܣ�");

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
	echo "��ǰ�����ļ�ָ�룺" . ftell($fp) . "<br/>";
	echo "��¼���ļ�ָ�룺" . $fparray->downfp . "<br/>";
	//$fp=$fparray->filefp;
}
}else{
	$tempfp = fopen($tempfilepath,"w") or die("error to create file $tempfilename");
}	
@fclose($tempfp);

$dlsize = 0; // set download size to 0;
//������  
while (!feof($fp)) {  
    //�����ļ��ִ��ʱ��  
    set_time_limit(0);
    
    //write offset to temp file;
    $tempfp = fopen($tempfilepath,"w+") or die("write $tempfilename error!");
    
    @fwrite ($savefp, fread($fp, 1024 * 8)); //����ļ�  
    
    $tmpsave->downfp=ftell($fp);
    $fpString = serialize($tmpsave);
    rewind($tempfp);
    @fwrite($tempfp,$fpString);
    @fclose($tmpfp);
    
    print("ok!");
    
    flush(); //�������  
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