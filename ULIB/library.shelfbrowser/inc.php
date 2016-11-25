<?php  //พ
function local_callndescr($str,$callntype) {
	$callntype=strtoupper($callntype);
	if ($callntype!="DC" && $callntype!="LC") {
		return "";
	}

	global $_STR_A_Z;
	$numbers=explode(',',"0,1,2,3,4,5,6,7,8,9");
	$ditits=explode(',',$_STR_A_Z);
	$res=strtoupper($str);
	$calln="";
	for ($i=0;$i<=strlen($res);$i++) {
		$tmp=substr($str,$i,1);
		if (in_array("$tmp",$ditits) || in_array("$tmp",$numbers) ) {
			$calln.=$tmp;
		}
	}
	if ($calln=="") {
		return "";
	}
	$calln=substr($calln,0,3);
	//echo $calln;
	if ($callntype=="DC") {
		$s=tmq("select * from keyhelp_dclist where dc ='$calln' ");
		if (tmq_num_rows($s)!=0) {
			$s=tmq_fetch_array($s);
			return $s[text];
		}
	}
	if ($callntype=="LC") {
		$s=tmq("select * from keyhelp_lclist where num ='$calln' ");
		if (tmq_num_rows($s)!=0) {
			$s=tmq_fetch_array($s);
			return $s[text];
		}
	}
}
?>