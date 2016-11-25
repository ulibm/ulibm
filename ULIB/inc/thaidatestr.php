<?php //พ
function thaidatestr($dt=0,$tim="NO") {
	global $thaimonstr;
	if ($dt==0) {
		$dt=time();
	} 

	$s="";
	$dat=date("j",$dt);
	$mon=$thaimonstr[date("n",$dt)];
	$yea=floor(date("Y",$dt)+543);
	$s= "$dat $mon $yea";
	if ($tim!="NO") {
		$s=date("s:i:H")." $s";
	}
	return $s;
}
?>