<?php 
;
include("./cfg.inc.php");
include("./_localfunc.php");
html_start();
	//mn_web($_REQPERM);
// พ
 $TID=trim($TID);
 $ismanager=library_gotpermission("webpage-postarticle");

 $postdata="select * from webpage_articles where id='$TID' ";
 $postdata=tmq($postdata);
	if (tmq_num_rows($postdata)==0) {
		die("no webpage_articles id $TID");
	}
	$postdata=tmq_fetch_array($postdata);

?><!-- <BR><?php pathgen($postdata[boardid],$TID);?>  --><?php 
	if ($catedata[isshowtouser]!="yes" && $ismanager!=true) {
		die("you cannot post in this forum");
	}
$s=tmq("select * from  webpage_articles where nestedid='$TID' and ishide<>'yes' order by dt desc limit 0,15");

while ($r=tmq_fetch_array($s)) {
	viewpostminimum($r);
}
viewpostminimum($postdata);

?>