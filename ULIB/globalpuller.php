<?php 
include("./inc/config.inc.php");
//die("test response");
if ($url=="") {
	die("globalpuller with no url");
}
if ($charset=="") {
	header("Content-Type: text/html; charset=UTF-8");
} else {
	header("Content-Type: text/html; charset=$charset");
	//echo("Content-Type: text/html; charset=$charset");
}
//echo "charset=$charset ";
$time=floor($time);
if ($time!=0) {
	sleep($time);
}
//////////////

$tmp=getval("_SETTING","urlmappuller");
$tmp=trim($tmp);
$tmp=explodenewline($tmp);
$tmp=arr_filter_remnull($tmp);
while (list($k,$v)=@each($tmp)) {
   $tmp2=explode("=",$v);
   $url=str_replace($tmp2[0],$tmp2[1],$url);
}
//echo $url;
$url=urldecode($url);
$url=urldecode($url);
$url=urldecode($url);
$searchuri=urldecode($url);
$searchuri=str_replace(' ','%20',$searchuri);
$handle = @fopen($searchuri, "r");
//echo "[$searchuri]";
if ($handle) {
	$buffer="";
    while (!feof($handle)) {
        $buffer .= fgets($handle, 4096);
    }
	if (strlen($buffer)<50) {
		echo "<FONT SIZE=-2 COLOR=gray>".getlang("มีปัญหาในการเชื่อมต่อ::l::Connection Problems")." (read content)</FONT>";
	} else {
	

	  
		echo "$buffer";
	}
    @fclose($handle);
} else {
	echo $searchuri;
	echo "<FONT SIZE=-2 COLOR=gray>".("มีปัญหาในการเชื่อมต่อ/Connection Problems")." (open url)</FONT>";
}
?>