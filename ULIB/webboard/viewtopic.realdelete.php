<?php  
;
include("./cfg.inc.php");
include("./_localfunc.php");
html_start(); // พ
function local_del($wh) {
	echo "delete id =$wh<BR>";
	global $_VAL_FILE_SAVEPATH;
	global $_VAL_FILE_SAVEPATHunused;
	//delete files
		$file=tmq("select * from webboard_post_attatch where postid='$wh' ");	
		while ($filer=tmq_fetch_array($file)) {
			rename($_VAL_FILE_SAVEPATH.$filer[hidename],$_VAL_FILE_SAVEPATHunused.$filer[hidename]);
			tmq("delete from  webboard_post_attatch where  postid=$wh and id='$filer[id]' ");
		}
	//end delete files
	tmq("delete from  webboard_posts where id='$wh' ");
}


$ismanager=loginchk_lib("check");
 $setdelete=trim($setdelete);
 $postdata="select * from webboard_posts where id='$setdelete' ";
 $postdata.=" and ishide='yes' ";
	$postdata=tmq($postdata);
	if (tmq_num_rows($postdata)==0) {
		die("no webboard_posts id $setdelete ");
	}

	$postdata=tmq_fetch_array($postdata);

	if ($ismanager!=true) {
		die("you cannot rdelete this post");
	}
	local_del($setdelete);

	if ($postdata[nestedid]==0) {
		$scan=tmq("select * from webboard_posts where nestedid='$setdelete' ");
		while ($scanr=tmq_fetch_array($scan)) {
			local_del($scanr[id]);
		}

		redir("viewforum.php?ID=$postdata[boardid]");
	} else {
		redir("viewtopic.php?TID=$postdata[nestedid]");
	}

?>