<?php 
function ymd_datestr($a,$mode="full") {
	////func("ymd_datestr($a) ");
	global $thaimonstr;
	global $thaimonstrbrief;
	/*
	$today=date("Y-n-j");
	$yesterday=date("Y-n-j", mktime(0, 0, 0, date('n'), date('j')-1, date('Y')));;
	$cmdday=date("Y-n-j",$a);
	if ($cmdday==$today) {
		$result_dt1="วันนี้";
	} elseif ($cmdday==$yesterday) {
		$result_dt1="เมื่อวานนี้";
	} else {
		$result_dt1= date(" j/",$a) . $thaimonstr[date("n",$a)] . "/". (date("Y",$a)+543) ;
	}
	*/
	if (floor($a)==0) {
		return "ไม่ได้ระบุวัน";
	}
		$result_dt1= trim(@date(" j/",$a) . $thaimonstr[@date("n",$a)] . "/". (@date("Y",$a)+543));

	if ($mode=="shortdt") {
		return trim("<nobr>".@date("H:i",$a). "</nobr> <nobr>".@date(" j",$a)  . " ". $thaimonstrbrief[@date("n",$a)] . " ". substr(@date("Y",$a)+543,-2) ."</nobr>");
	} 
	if ($mode=="datetime") {
		return trim(@date(" j",$a)  . " ". $thaimonstrbrief[@date("n",$a)] . " ". substr(@date("Y",$a)+543,-2) . " " .@date("H:i",$a));
	} 
	if ($mode=="time") {
		return trim(@date("H:i",$a));
	} 

	if ($mode=="shortd") {
		return trim("<nobr>".@date(" j",$a)  . " ". $thaimonstrbrief[@date("n",$a)] . " ". substr(@date("Y",$a)+543,-2) ."</nobr>");
	} 

	if ($mode=="full") {
		return trim("<nobr>".@date("H:i",$a). "</nobr> <nobr>".$result_dt1."</nobr>");
	} 
	if ($mode=="date") {
		return trim($result_dt1);
	} 
}
?>