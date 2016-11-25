<?php  
;
include("./cfg.inc.php");
include("./_localfunc.php");
html_start();
    // head();
$ismanager=library_gotpermission("webpage-postarticle");
 $TID=trim($TID);
if (editperm_chk("web-id-$TID")!=true) {
	die ("คุณไม่มีสิทธิ์ลบหรือแก้ไขรายการนี้::l::Your login have no permission to modify this article;");
}

 $postdata="select * from webpage_articles where id='$setdelete' ";
 if ($ismanager!=true) {
	$postdata.=" and ishide<>'yes' ";
 }
	$postdata=tmq($postdata);
	if (tmq_num_rows($postdata)==0) {
		die("no webpage_articles id $TID");
	}

	$postdata=tmq_fetch_array($postdata);


?><!-- <?php  pathgen($postdata[boardid],$TID);?>  --><?php  


	if (($postdata[tmid]!=$_tmid || $tmiddata[ispost]!="on") && $ismanager!=true) {
		die("you cannot delete this post");
	}

tmq("update webpage_articles set ishide='yes' where id='$setdelete' ");
	if ($postdata[nestedid]!=0) {
		redir("viewtopic.php?TID=$postdata[nestedid]");
	} else {
		redir("viewforum.php?ID=$postdata[boardid]");
	}

?>