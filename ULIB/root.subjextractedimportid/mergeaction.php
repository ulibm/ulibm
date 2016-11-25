<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	mn_root("subjextractedimportid");

  $sql1 ="SELECT distinct importid, count(id) as cc FROM index_subjextract group by importid"; 

	$sql2 = "$sql1 order by id desc ";
//echo $sql2;
$decisval=floor($decisval);
	$result = tmq($sql2);
while ($r=tmq_fetch_array($result)) {
	if ($r[cc]<=$decisval) {
		tmq("update index_subjextract set importid='Merge:$newname'  where importid='$r[importid]' ");
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