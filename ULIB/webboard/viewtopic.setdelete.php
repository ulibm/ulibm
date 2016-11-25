<?php 
;
include("./cfg.inc.php");
include("./_localfunc.php");
html_start();
    // head(); // พ
$ismanager=loginchk_lib("check");
 $TID=trim($TID);
 $postdata="select * from webboard_posts where id='$setdelete' ";
 if ($ismanager!=true) {
	$postdata.=" and ishide<>'yes' ";
 }
	$postdata=tmq($postdata);
	if (tmq_num_rows($postdata)==0) {
		die("no webboard_posts id $TID");
	}

	$postdata=tmq_fetch_array($postdata);


?><!-- <?php pathgen($postdata[boardid],$TID);?>  --><?php 


	if (($postdata[tmid]!=$_tmid || $tmiddata[ispost]!="on") && $ismanager!=true) {
		die("you cannot delete this post");
	}

tmq("update webboard_posts set ishide='yes' where id='$setdelete' ");
	if ($postdata[nestedid]!=0) {
		redir("viewtopic.php?TID=$postdata[nestedid]");
	} else {
		redir("viewforum.php?ID=$postdata[boardid]");
	}

?>