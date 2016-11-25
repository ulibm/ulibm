<?php // พ
function tmq_dump($tb,$f,$v,$d="") {
	global $dbmode;
	$t=tmq("select * from $tb $d",false);
	$tmp=Array();
	while ($r=tmq_fetch_array($t)) {
		$tmp[$r[$f]]=$r[$v];
	}
	return $tmp;
}
?>