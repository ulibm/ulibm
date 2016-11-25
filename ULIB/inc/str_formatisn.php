<?php  //พ
function str_formatisn($s) {
	$s=trim($s);
	$s=str_replace(" ","",$s);
	$s=str_replace("-","",$s);
	//echo "[$s]=".strlen($s);;
	if (strlen($s)==13) {
	    $s =preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{2})[^\d]*(\d{4})[^\d]*(\d{1}).*~', '$1-$2-$3-$4-$5', $s). "<br>\n";
	} elseif (strlen($s)==10) {
	    $s =preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{3})[^\d]*(\d{1}).*~', '$1-$2-$3-$4', $s). "<br>\n";
	} else {
		return $s;
	}
	return $s;
}
?>