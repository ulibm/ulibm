<?php // พ
function viewdiffman_add($cate,$id,$str) {
	global $useradminid;
	$now=time();
	tmq("insert into viewdiffman set loginid='$useradminid',
	dt='$now',
	cate='$cate',
	code='$id',
	str='".addslashes($str)."'
	");
}
?>