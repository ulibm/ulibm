<?php 
if ($keyword==""|| $url=="") {
	die;
}
$time=floor($time);
if ($time!=0) {
	sleep($time);
}
//////////////

$url=urldecode($url);
$url=urldecode($url);
$searchuri=urldecode($url)."/_USIS.search.php?startrow=$startrow&keyword=".urlencode($keyword);
$handle = @fopen($searchuri, "r");
if ($handle) {
	$buffer="";
    while (!feof($handle)) {
        $buffer .= fgets($handle, 4096);
    }
	if (strlen($buffer)<50) {
		echo "<FONT SIZE=-2 COLOR=gray>".getlang("มีปัญหาในการเชื่อมต่อ::l::Connection Problems")."</FONT>";
	} else {
		echo $buffer;
	}
    @fclose($handle);
} else {
	echo "<FONT SIZE=-2 COLOR=gray>".("มีปัญหาในการเชื่อมต่อ/Connection Problems")."</FONT>";
}
?>