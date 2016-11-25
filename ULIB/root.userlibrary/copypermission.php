<?php 
;
include("../inc/config.inc.php");
head();
mn_root("userlibrary");
// พ
if ($ID!="" && $sourceperm!="") {
	tmq("delete from library_permission where lib='$ID'  ",false);
	$source=tmq("select * from library_permission where lib='$sourceperm'");
		while ($r=tmq_fetch_array($source)) {
			tmq("insert into library_permission set lib='$ID' , code='$r[code]'  ");
		}
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert('done.');
	self.location="permission.php?ID=<?php  echo $ID?>";
//-->
</SCRIPT>
<?php 
foot();
?>