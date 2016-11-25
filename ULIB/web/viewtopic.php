<?php 
;
include("./cfg.inc.php");
include("./_localfunc.php");
html_start();
     head();// พ
	 mn_web($_REQPERM);

	// print_r($_SESSION);
$ismanager=library_gotpermission("webpage-postarticle");
 $TID=trim($TID);
 $postdata="select * from webpage_articles where id='$TID' ";
 if ($ismanager!=true) {
	$postdata.=" and ishide<>'yes' ";
 }
	$postdata=tmq($postdata);
	if (tmq_num_rows($postdata)==0) {
		die("no webpage_articles id $TID");
	}
	$postdata=tmq_fetch_array($postdata);

if (strpos($postdata[viewers],",$_tmid,")===false) {
	$newviewers=$postdata[viewers].",$_tmid,";
	tmq("update webpage_articles set viewers='$newviewers' where id='$TID' ");
}

$backto=urlencode("viewtopic.php?TID=$TID");
pagesection($postdata[topic]);
?><?php pathgen($postdata[boardid],$TID);?> <?php 

/*
	if ($catedata[isshowtouser]!="yes" && $ismanager!=true) {
		die("you cannot post in this forum");
	}
*/

viewpost($postdata);
?>

<?php 
$sql="select * from  webpage_articles where nestedid='$TID'  ";
 if ($ismanager!=true) {
	$sql.=" and ishide<>'yes' ";
 }
$sql.="  order by dt asc, ID asc ";
//echo $sql;
?><!--<?php 
$s=tmqp($sql,"viewtopic.php?TID=$TID","skip");
?>--><TABLE width="<?php  echo $_TBWIDTH?>" align=center>
<?php  echo $_pagesplit_btn_var; ?>
</TABLE><?php 
while ($r=tmq_fetch_array($s)) {
	viewpost($r);
}
?><TABLE width=780 align=center>
<?php  echo $_pagesplit_btn_var; ?>
</TABLE><BR><?php 
pathgen($postdata[boardid],$TID);
include("inc.webjump.php");

foot();
?>