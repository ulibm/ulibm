<?php // พ
function str_webpagereplacer($str) {
	global $dcrs;
	global $dcrURL;
	$s=tmq("select * from webpage_textreplacer where active='yes' order by ordr");
	while ($r=tmq_fetch_array($s)) {
		//echo "[$r[str1],$r[str2]]";
		if ($r[str2]=="[dcrurl]") {
			$r[str2]=$dcrURL;
		}
		if ($r[str2]=="[dcrs]") {
			$r[str2]=$dcrs;
		}
		$str=str_replace(stripslashes($r[str1]),stripslashes($r[str2]),$str);
	}
	return str_censor($str);
}
?>