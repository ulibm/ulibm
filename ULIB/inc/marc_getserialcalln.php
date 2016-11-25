<?php 
function marc_getserialcalln($md,$mode="full") {
	$s=tmq("select * from media_mid where id='$md' ");
	$s=tmq_fetch_array($s);
	$res=marc_getcalln($s[pid]);
   if (trim($res)!="") {
      $res .= " -- ";
   } 
   $res.=serial_get_volstr($s[id],"no","no") ." " ;
	if ($mode=="full") {
		if (trim($s[inumber])!="ฉ.") {
			$res.=$s[inumber];
		}
	}
	//echo "marc_getserialcalln=[$res]";
	//return "<!--(-->".trim($res)."<!--)-->";
	return trim($res);
}
?>