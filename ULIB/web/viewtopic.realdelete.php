<?php  
;
include("./cfg.inc.php");
include("./_localfunc.php");
html_start();
function local_del($wh) {
	echo "delete id =$wh<BR>";
	global $_VAL_FILE_SAVEPATH;
	global $_VAL_FILE_SAVEPATHunused;
	//delete files
		$file=tmq("select * from webpage_article_attatch where postid='$wh' ");	
		while ($filer=tmq_fetch_array($file)) {
			unlink($_VAL_FILE_SAVEPATH.$filer[hidename]);
			tmq("delete from  webpage_article_attatch where  postid=$wh and id='$filer[id]' ");
		}
	//end delete files
	tmq("delete from  webpage_articles where id='$wh' ");
}


$ismanager=library_gotpermission("webpage-postarticle");
 $setdelete=trim($setdelete);
 if (editperm_chk("web-id-$setdelete")!=true) {
	die ("คุณไม่มีสิทธิ์ลบหรือแก้ไขรายการนี้::l::Your login have no permission to modify this article;");
}

 $postdata="select * from webpage_articles where id='$setdelete' ";
 $postdata.=" and ishide='yes' ";
	$postdata=tmq($postdata);
	if (tmq_num_rows($postdata)==0) {
		die("no webpage_articles id $setdelete ");
	}

	$postdata=tmq_fetch_array($postdata);

	if ($ismanager!=true) {
		die("you cannot rdelete this post");
	}
	local_del($setdelete);

	if ($postdata[nestedid]==0) {
		$scan=tmq("select * from webpage_articles where nestedid='$setdelete' ");
		while ($scanr=tmq_fetch_array($scan)) {
			local_del($scanr[id]);
		}

		redir("viewforum.php?ID=$postdata[boardid]");
	} else {
		redir("viewtopic.php?TID=$postdata[nestedid]");
	}

?>