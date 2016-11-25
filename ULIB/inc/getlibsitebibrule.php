<?php // พ
function getlibsitebibrule($libfrom,$libto,$code) {
	//return yes or no (string)
	$tmp=tmq("select * from libsite_bibpermission where libfrom='$libfrom' and libto='$libto' and code='$code'  ");	
	if (tmq_num_rows($tmp)==0) {
		return "no";
	} else {
		return "yes";
	}
}
?>