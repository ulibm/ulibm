<?php  //พ
$item=tmq("select * from media_mid where bcode='".$dat["AB"]."' ");
if (tmq_num_rows($item)==0) {
	$resp="18010001$siptime".
	"AB".$dat["AB"].$limiter.
	"ABItem ID:".$dat["AB"].$limiter.
	"AF|AG"
	;
} else {
	$item=tmq_fetch_array($item);
	$title=(marc_gettitle($item[pid]));
	if ($item[status]=="") {
		$cirstat="03";
	} else {
		$cirstat=$circulation_status[$item[status]];
		if ($cirstat=="") {
			$cirstat="01";
		}
	}
	$item=tmq("select * from checkout where mediaId='".$dat["AB"]."' ");
	if (tmq_num_rows($item)==0) {
		$item=tnr($item);

		unset($sec_marker);
		unset($sec_markers);
		//echo "select * from media_type where code='$item[RESOURCE_TYPE]' "; die;
		$sec_markers=tmq("select * from media_type where code='$item[RESOURCE_TYPE]' ",false);
		$sec_marker=tmq_fetch_array($sec_markers);
		
		$sec_marker=$sec_marker[sip_sec_marker];
		if (strlen($sec_marker)!=2) {
			$sec_marker="00";
		}
	} else {
		$item=tmq_fetch_array($item);
		$cirstat="04";
		$sec_marker="00";
                $returntime="AH".date('d-m-',mktime(0, 0, 0, $item[emon], $item[edat], $item[eyea]-543)).(date('Y',mktime(0, 0, 0, $item[emon], $item[edat], $item[eyea]-543))+543);
		//$returntime="AH".date('Ymd    His',mktime(0, 0, 0, $item[emon], $item[edat], $item[eyea]-543));
	}
	$feetype="01";

	$resp="18$cirstat$sec_marker$feetype".
		$siptime.
	"AB".$dat["AB"].$limiter.
	"AJ$title|AF|AG|".$returntime.$limiter;
}

local_sput($resp);

?>
