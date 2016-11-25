<?php 
;
include("./cfg.inc.php");
include("./_localfunc.php");
html_start(); // พ

 $TID=trim($TID);
 $ismanager=loginchk_lib("check");

 $postdata="select * from webboard_posts where id='$TID' ";
 $postdata=tmq($postdata);
	if (tmq_num_rows($postdata)==0) {
		die("no webboard_posts id $TID");
	}
	$postdata=tmq_fetch_array($postdata);

?><!-- <BR><?php pathgen($postdata[boardid],$TID);?>  --><?php 
	if ($catedata[isshowtouser]!="yes" && $ismanager!=true) {
		die("you cannot post in this forum");
	}
$s=tmq("select * from  webboard_posts where nestedid='$TID' and ishide<>'yes' order by dt desc limit 0,15");

while ($r=tmq_fetch_array($s)) {
	viewpostminimum($r);
}
viewpostminimum($postdata);

?>