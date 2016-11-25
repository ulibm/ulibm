<?php 
    ;
	include ("../inc/config.inc.php");
	loginchk_lib();
$now=time();
tmq("update media_mid set status='$status',status_lastupdate='$now' where ismarked='YES' ");
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
alert("<?php  echo getlang("การดำเนินการเรียบร้อย::l::Operation done."); ?> ");
//-->
</SCRIPT>
<?php 
redir("media_type.php");

	?>