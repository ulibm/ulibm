<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	$_REQPERM="index_reindex";
	mn_lib();

  $sql1 ="SELECT distinct importid, count(id) as cc FROM media  group by importid"; 

	$sql2 = "$sql1 order by id desc ";
//echo $sql2;
$decisval=floor($decisval);
	$result = tmq($sql2);
while ($r=tmq_fetch_array($result)) {
	if ($r[cc]<=$decisval) {
		tmq("update media set importid='Merge:$newname'  where importid='$r[importid]' ");
		tmq("update index_db set importid='Merge:$newname'  where importid='$r[importid]' ");
		tmq("update index_db_subj  set importid='Merge:$newname'  where importid='$r[importid]' ");
	}
}
?><SCRIPT LANGUAGE="JavaScript">
<!--
alert("<?php  echo getlang("การดำเนินการเรียบร้อย::l::Operation done."); ?>");
//-->
</SCRIPT><?php 
redir("media_type.php");
foot();
?>