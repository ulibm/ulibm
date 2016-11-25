<?php // พ
function str_preformat($str) {
	global $newline;
	$str=str_replace(' ','&nbsp;',$str);
	/*$str=str_replace("
",'<BR>',$str);
	$str=str_replace($newline,'<BR>',$str);*/
	$stra=explodenewline($str);
	$str=implode("<br>",$stra);
	return $str;
}
?>