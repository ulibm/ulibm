<?php // พ
function member_log($mem,$type1,$descr="") {
	$now=time();
	$descr=addslashes($descr);
	tmq("insert into member_log set dt='$now',memid='$mem', type1='$type1',descr='$descr' ",false);

}
?>