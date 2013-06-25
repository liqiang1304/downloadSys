<?php
error_reporting(E_ALL & ~ E_NOTICE);
/*
Simple COMET script tested to work with IE6, IE8, IE9, Chrome 5, Chrome 10, Firefox 3.6.16, Firefox 4, Safari 5, Opera 11
*/
error_reporting(E_ALL & ~ E_NOTICE);
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

//Turn of Apache output compression
// Necessary if you have gzip setup in your httpd.conf (e.g. LoadModule deflate_module modules/mod_deflate.so)
//apache_setenv('no-gzip', 1);
//ini_set('zlib.output_compression', 0);

//Disable all PHP output buffering
//ini_set('output_buffering', 'Off');
//ini_set('implicit_flush', 1);
ob_implicit_flush(1);

for ($i = 0, $level = ob_get_level(); $i < $level; $i++) { ob_end_flush(); } //Flush all levels of the buffer to start

error_reporting(E_ALL);

?><html>
<head>
  <title>Comet php backend</title>
</head>
<body>
<script type="text/javascript">
	var dumpText = window.parent.dumpText;
	var processText = window.parent.processText;
	var displayfile = window.parent.displayfile;
	var displayexplan = window.parent.displayexplan;
</script>
<?php
/**
 * 下载远程文件类支持断点续传 
 */
class HttpDownload {
	private $m_url = "";
 	private $m_urlpath = "";
 	private $m_scheme = "http";
 	private $m_host = "";
 	private $m_port = "80";
 	private $m_user = "";
 	private $m_pass = "";
 	private $m_path = "/";
 	private $m_query = "";
 	private $m_fp = "";
 	private $m_error = "";
	private $m_httphead = "" ;
	private $m_html = "";
	private $file_size=0;
 	private $downurl = "";
	/**
	 * 初始化 
	 */
	public function PrivateInit($url){
		$urls = "";
		$urls = @parse_url($url);
		$this->m_url = $url;
		if(is_array($urls)) {
			$this->m_host = !empty($urls["host"])?$urls["host"]:null;
			if(!empty($urls["scheme"])) $this->m_scheme = $urls["scheme"];
			if(!empty($urls["user"])) $this->m_user = $urls["user"];
		    if(!empty($urls["pass"])) $this->m_pass = $urls["pass"];
		    if(!empty($urls["port"])) $this->m_port = $urls["port"];
		    if(!empty($urls["path"])) $this->m_path = $urls["path"];
		    $this->m_urlpath = $this->m_path;
			if(!empty($urls["query"])) {
     			$this->m_query = $urls["query"];
     			$this->m_urlpath .= "?".$this->m_query;
     		}
  		}
	}
	//获取文件大小
	function getFileSize($sizeurl){ 
        $sizeurl = parse_url($sizeurl);
        if($fp = @fsockopen($sizeurl["host"],empty($sizeurl["port"])?80:$sizeurl["port"],$error)){
                fputs($fp,"GET ".(empty($sizeurl["path"])?"/":$sizeurl["path"])." HTTP/1.1\r\n");
                fputs($fp,"Host:$sizeurl[host]\r\n\r\n");
                while(!feof($fp)){
                        $tmp = fgets($fp);
                        if(trim($tmp) == ""){
                                break;
                        }else if(preg_match("/Content-Length:(.*)/si",$tmp,$arr)){
                                return trim($arr[1]);
                        }
                }
                return null;
        }else{
                return null;
        }
}
 
	/**
	* 打开指定网址
	*/
	function OpenUrl($url,$savefilename) {
		$this->file_size=$this->getFileSize($url);
		$this->downurl=$url;
		echo '<script type="text/javascript">';
		if(round($this->file_size/1024)<1024){
			echo "displayfile(\"文件大小：" . round($this->file_size/1024) . " KB\");";
		}else if(round($this->file_size/1024/1024)<1024){
			echo "displayfile(\"文件大小：" . round($this->file_size/1024/1024,2) . " MB\");";
		}else{
			echo "displayfile(\"文件大小：" . round($this->file_size/1024/1024/1024,2) . " GB\");";
		}
		//echo "displayfile(\"very Big!\");";
		echo "</script>\r\n";
		flush();
		#重设各参数
		$this->m_url = "";
		$this->m_urlpath = "";
		$this->m_scheme = "http";
		$this->m_host = "";
		$this->m_port = "80";
		$this->m_user = "";
		$this->m_pass = "";
		$this->m_path = "/";
		$this->m_query = "";
		$this->m_error = "";
		$this->m_httphead = "" ;
		$this->m_html = "";
		$this->Close();
		#初始化系统
		$this->PrivateInit($url);
		$this->PrivateStartSession($savefilename);
	}

	/**
	* 获得某操作错误的原因
	*/
	public function printError() {
		echo "错误信息：".$this->m_error;
		echo "具体返回头：<br>";
		foreach($this->m_httphead as $k=>$v) { 
			echo "$k => $v <br>\r\n"; 
		}
	}
 
	/**
	* 判别用Get方法发送的头的应答结果是否正确
	*/
	public function IsGetOK() {
		if( preg_match("/^2/",$this->GetHead("http-state")) ) { 
			return true; 
		} else {
			$this->m_error .= $this->GetHead("http-state")." - ".$this->GetHead("http-describe")."<br>";
			return false;
		}
	}
	
	/**
	* 看看返回的网页是否是text类型
	*/
	public function IsText() {
		if (ereg("^2",$this->GetHead("http-state")) && eregi("^text",$this->GetHead("content-type"))) { 
			return true; 
		} else {
			$this->m_error .= "内容为非文本类型<br>";
			return false;
		}
	}
	/**
	* 判断返回的网页是否是特定的类型
	*/
	public function IsContentType($ctype) {
		if (ereg("^2",$this->GetHead("http-state")) && $this->GetHead("content-type") == strtolower($ctype)) { 
			return true; 
		} else {
			$this->m_error .= "类型不对 ".$this->GetHead("content-type")."<br>";
			return false;
		}
	}
	
	public function gettime() {
    	list($usec, $sec) = explode(" ", microtime());
    	return (float)$usec + (float)$sec;    //开始时间一直很小，原来是少了$这个符号
	}
	
	/**
	* 用 HTTP 协议下载文件
	*/
	public function SaveToBin($savefilename) {
		$tmpsave=new filebean();
		$tmpsave->fileurl=$this->downurl;
		$tmpsave->filename=$savefilename;
		$timeLength=1;
		$startTime=0;
		$times=0;
		$tmpfilename=$savefilename . ".tmp";
		if (!$this->IsGetOK()) return false;
		if (@feof($this->m_fp)) { 
			$this->m_error = "连接已经关闭！"; 
			return false; 
		}
		print($savefilename);
		print($tmpfilename);
		if(file_exists($savefilename)&&!file_exists($tmpfilename)){
			echo '<script type="text/javascript">';
			echo "displayexplan(\"文件已下载完成并存在，若要重新下载请删除旧文件或重命名文件名。\")";
			echo "</script>\r\n";
			return true;
		}
		
		
		$fileoffset = 0;
		$fp = fopen($savefilename,"x") or $fileoffset=1;
		fclose($fp);
		$fp = fopen($savefilename,"r") or die("写入文件 $savefilename 失败！");
		fseek($fp,-1,SEEK_END);
		print("open offset: " . ftell($fp) . "<br/>");
		$fileoffset += ftell($fp);
		fclose($fp);
		$fp = fopen($savefilename,"a") or die("写入文件 $savefilename 失败！");
		
		if(file_exists($tmpfilename)){
		$tmpfp = fopen($tmpfilename,"r") /*or die("读取文件 $tmpfilename 失败！")*/;
		$tmpstring="";
		while(!feof($tmpfp)){
			$tmpstring.=fgets($tmpfp);
		}
		$fparray = new filebean();
		$fparray = unserialize($tmpstring);
		echo "bbbbbbbbbbbbbbbbbbbbbbbbbb";
		if(($fparray->fileurl==$this->downurl)&&($fparray->filename==$savefilename)){
			echo "当前网络文件指针：" . ftell($this->m_fp) . "<br/>";
			echo "记录的文件指针：" . $fparray->downfp . "<br/>";
		}
		fclose($tmpfp);
		}else{
			echo "file not found!!";
		}
		
		$dlsize=0;
		while (!feof($this->m_fp)) {	
			if($timeLength==1){
				$dlsize+=$times*256;
				echo '<script type="text/javascript">';
				if(round($times*256/1024)<=1024){
					echo "dumpText(\"". round($times*256/1024) ." Kb/s\");";
				}else{
					echo "dumpText(\"". round($times*256/1024/1024,2) ." Mb/s\");";
				}
				echo "processText(\"". round((ftell($fp)+$fileoffset)/$this->file_size*100,2) ."%\");";
				//echo "processBgColor(". round($dlsize/$this->file_size*100) .");";
				//.str_repeat(' ',500); //500 characters of padding
				echo "</script>\r\n";
				
				flush();
				
				//ob_end_flush(); //关闭php缓存，或者在flush前ob_flush();
				//echo str_repeat(" ", 2048); //ie下 需要先发送256个字节, firefox 1024, chrome 2048
				set_time_limit(0);
				
				$startTime=$this->gettime();
				//echo($times*256/1024 . "kb/s <br/>");
				$times=0;
				
				//flush(); //把apache缓存推送到浏览器去
			}
			$tmpfp = fopen($tmpfilename,"w") or die("写入文件 $tmpfilename 失败！");
			@fwrite($fp,fread($this->m_fp,256));
			//$fparray[2]=$this->m_fp;
			$tmpsave->downfp=ftell($fp)+$fileoffset;
			//print("dlsize：" . $dlsize . "<br/>");
			//print("offset: " . ftell($fp) . "<br/>");
			//-----$tmpsave->downfp=filesize($savefilename);
			//$tmpsave->filefp=$fp;
			$fpstring=serialize($tmpsave);
			rewind($tmpfp);
			@fwrite($tmpfp,$fpstring);
			$times++;
			$endTime=$this->gettime();
			$timeLength=floor($endTime-$startTime);
			@fclose($tmpfp);
		}
		@fclose($this->m_fp);
		@fclose($tmpfp);
		
		echo '<script type="text/javascript">';
		echo "dumpText(\"已经下载完成!\");";
		unlink($tmpfilename);
		echo "processText(\"100%\");";
		echo "displayexplan(\"服务器端下载完成，<a href=\\\"$savefilename\\\">点击这里取回本地</a>，下载后请关闭该网页。\")";
		
		echo "</script>\r\n";
		flush();
		//echo($savefilename." have been saved!<br/>");
		return true;
	}
	
	/**
	* 保存网页内容为 Text 文件
	*/
	public function SaveToText($savefilename) {
		if ($this->IsText()) {
			$this->SaveBinFile($savefilename);
		} else {
			return "";
		}
	}
	
	
	/**
	* 用 HTTP 协议获得一个网页的内容
	*/
	public function GetHtml() {
		if (!$this->IsText()) return "";
		if ($this->m_html!="") return $this->m_html;
		if (!$this->m_fp||@feof($this->m_fp)) return "";
		while(!feof($this->m_fp)) {
			$this->m_html .= fgets($this->m_fp,256);
		}
		@fclose($this->m_fp);
		return $this->m_html;
	}
	
	/**
	* 开始 HTTP 会话
	*/
	public function PrivateStartSession($savefilename) {
		
		if (!$this->PrivateOpenHost()) {
			$this->m_error .= "打开远程主机出错!";
			return false;
		}
		if ($this->GetHead("http-edition")=="HTTP/1.1") {
			$httpv = "HTTP/1.1";
		} else {
			$httpv = "HTTP/1.0";
		}
		fputs($this->m_fp,"GET ".$this->m_urlpath." $httpv\r\n");
		fputs($this->m_fp,"Host: ".$this->m_host."\r\n");
		fputs($this->m_fp,"Accept: */*\r\n");
		fputs($this->m_fp,"User-Agent: Mozilla/4.0+(compatible;+MSIE+6.0;+Windows+NT+5.2)\r\n");
		
		$dlbegin = 0;
		$tmpfilename=$savefilename . ".tmp";
		if(file_exists($tmpfilename)){
		$tmpfp = fopen($tmpfilename,"r") /*or die("读取文件 $tmpfilename 失败！")*/;
		$tmpstring="";
		while(!feof($tmpfp)){
			$tmpstring.=fgets($tmpfp);
		}
		$fparray = new filebean();
		$fparray = unserialize($tmpstring);
		echo "bbbbbbbbbbbbbbbbbbbbbbbbbb";
		if(($fparray->fileurl==$this->downurl)&&($fparray->filename==$savefilename)){
			$dlbegin = $fparray->downfp;
			//fseek($this->m_fp,$fparray->downfp);
			echo "当前网络文件指针：" . ftell($this->m_fp) . "<br/>";
			echo "记录的文件指针：" . $fparray->downfp . "<br/>";
		}
		fclose($tmpfp);
		}else{
			echo "file not found!!";
		}

		
		fputs($this->m_fp,"Range: bytes=$dlbegin-\r\n");
		#HTTP1.1协议必须指定文档结束后关闭链接,否则读取文档时无法使用feof判断结束
		if ($httpv=="HTTP/1.1") {
			fputs($this->m_fp,"Connection: Close\r\n\r\n");
		} else {
			fputs($this->m_fp,"\r\n");
		}
		$httpstas = fgets($this->m_fp,256);
		$httpstas = split(" ",$httpstas);
		$this->m_httphead["http-edition"] = trim($httpstas[0]);
		$this->m_httphead["http-state"] = trim($httpstas[1]);
		$this->m_httphead["http-describe"] = "";
		for ($i=2;$i<count($httpstas);$i++) {
			$this->m_httphead["http-describe"] .= " ".trim($httpstas[$i]);
		}
		
		while (!feof($this->m_fp)) {
			$line = str_replace("\"","",trim(fgets($this->m_fp,256)));
			if($line == "") break;
			if (ereg(":",$line)) {
				$lines = split(":",$line);
				$this->m_httphead[strtolower(trim($lines[0]))] = trim($lines[1]);
			}
		}
	}
	
	/**
	* 获得一个Http头的值
	*/
	public function GetHead($headname) {
		$headname = strtolower($headname);
		if (isset($this->m_httphead[$headname])) {
			return $this->m_httphead[$headname];
		} else {
			return "";
		}
	}
	
	/**
	* 打开连接
	*/
	public function PrivateOpenHost() {
		if ($this->m_host=="") return false;
		$this->m_fp = @fsockopen($this->m_host, $this->m_port, $errno, $errstr,10);
		if (!$this->m_fp){
			$this->m_error = $errstr;
			return false;
		} else {
			return true;
		}
	}
	
	/**
	* 关闭连接
	*/
	public function Close(){
		@fclose($this->m_fp);
	}
}

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

#下载文件
	$urlString=!empty($_GET["postURL"])?$_GET["postURL"]:null;
	$fileName=!empty($_GET["filename"])?$_GET["filename"]:basename($urlString);
	$bg=!empty($_GET["bg"])?$_GET["postURL"]:"false";
	if($bg=="true"){
		ignore_user_abort(true); // 后台运行
	}
	print($urlString);
	print($fileName);
	//$fparray[0]=$urlString;
	//$fparray[1]=$fileName;
	set_time_limit(0); // 取消脚本运行时间的超时上限
	//$fileName=basename($urlString);
	$filePath="downloads/";
	$file = new HttpDownload(); # 实例化类
	$file->OpenUrl($urlString,$filePath.$fileName); # 远程文件地址
	$file->SaveToBin($filePath.$fileName); # 保存路径及文件名
	$file->Close(); # 释放资源
?>
</body>
</html>

