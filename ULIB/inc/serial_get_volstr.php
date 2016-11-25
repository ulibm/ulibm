<?php  //พ
function serial_get_volstr($id,$echonote="yes",$inumber="yes") {
	global $thaimonstr;
	$s=tmq("select * from media_mid where id='$id' ");
	$s=tmq_fetch_array($s);
	if (trim($s[calln])!="") {
		return stripslashes($s[calln]);
	}
	$sr=tmq("select * from serial_info where mid='$s[pid]' ",false);
	$sr=tmq_fetch_array($sr);

	$res="";
	//printr($s);
	if (trim($s[jenum_1])!="" && trim($sr[enum1])!="") {
		$res.=stripslashes(getlang($sr[enum1]))." " . $s[jenum_1] . " ";
	}
	if (trim($s[jenum_2])!="" && trim($sr[enum2])!="") {
		$res.=stripslashes(getlang($sr[enum2]))." " .  $s[jenum_2] . " ";
	}
	if (trim($s[jenum_3])!="" && trim($sr[enum3])!="") {
		$res.=stripslashes(getlang($sr[enum3]))." " . $s[jenum_3] . " ";
	}
	/*
	$jchrono_2=$s[jchrono_2];
	for ($i=12; $i>0;$i--) {
		$jchrono_2=str_replace("$i",$thaimonstr[$i],$jchrono_2);
	}
	if (trim("$s[jchrono_1]$s[jchrono_2]$s[jchrono_3]")!="") {
		if ("$s[jchrono_3]"=="0") {
			$s[jchrono_3]="";
		}
		$res.=" (" . $s[jchrono_1] . " " . $jchrono_2 . " " . $s[jchrono_3] . ")" ;
	}
	$res=str_replace("( ","(",$res);
	$res=str_replace(" )",")",$res);
	*/

	if ($inumber=="yes") {
		$res.=" $s[inumber]";
	}
	if ($echonote=="yes") {
		$res.=" $s[jpublicnote]";
	}
	$res=trim($res);
	//echo "serial_get_volstr=($inumber)[$res]";
	return $res;
}
?>