<?php // พ
function sql_gotallliblimit_bylibmember($lib,$field) {
	$res=" ( 0 ";

	$s=tmq("select * from library where libsite ='$lib' ");
	while ($r=tmq_fetch_array($s)) {
		$res="$res or $field='$r[UserAdminID]' ";
	}
	$res="$res ) ";
	return $res;
}
?>