<?php // พ
function getval($main, $sub) {
	//debug_print_backtrace();
	$s=tmq("select * from valmem where  main='$main' and sub= '$sub' ");
	if (tmq_num_rows($s)==1) {
		$s=tmq_fetch_array($s);
		return stripslashes($s["val"]);
	} else {
		$s=tmq("select * from val where main='$main' and sub= '$sub' ",false);
		$rechecknum=tnr($s);
		$s=tmq_fetch_array($s);
		tmq("delete from valmem where  main='$main' and sub= '$sub' ");
		if (strlen($s["val"])<255) {
			tmq("insert into valmem set
			main='$main',
			sub='$sub',
			val='$s[val]'
			",false);
		}
		if ($rechecknum>1) {
		 tmq("delete from val where main='$main' and sub= '$sub' limit 1");
		}
		return stripslashes($s[val]);
	}
}
?>