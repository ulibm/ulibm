<?php // พ
function getlibsitevars($libsite,$varitem) {
	//return yes or no (string)
	$tmp=tmq("select * from libsite_vars_vars where libsite='$libsite' and varitem ='$varitem'  ");	
	$tmproot=tmq("select * from libsite_vars where code ='$varitem'  ");	
	$tmproot=tmq_fetch_array($tmproot);
	$valtype = $tmproot[valtype];
	if (tmq_num_rows($tmp)==0) {
		return $valtype($tmproot[defaultval]);
	} else {
		$tmp=tmq_fetch_array($tmp);
		return $valtype($tmp[value]);
	}
}
?>