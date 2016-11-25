<?php // พ
function tmq_connect($tthost, $ttuser, $ttpasswd,$newlink=false) {
	global $dbmode;
	global $tmq_connect_tthost;
	global $tmq_connect_ttuser;
	global $tmq_connect_ttpasswd;
	if ($dbmode=="mysql") {
		$tmp= mysql_connect($tthost, $ttuser, $ttpasswd,$newlink);
		//echo "tmq_connect($tthost, $ttuser, $ttpasswd)".$tmp;
		return $tmp;
	}
	if ($dbmode=="mysqli") {
		$tmq_connect_tthost=$tthost;
		$tmq_connect_ttuser=$ttuser;
		$tmq_connect_ttpasswd=$ttpasswd;
		//mysqli connect on select db
		return true;
	}
}
?>