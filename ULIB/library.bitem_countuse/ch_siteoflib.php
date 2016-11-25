<?php 
    ;
	include ("../inc/config.inc.php");
	loginchk_lib();

	$s=tmq("select * from countuse_name where countuse='$qnid' ");
	if (tmq_num_rows($s) ==0 )  {
		$name="[".getlang("ยังไม่ได้ตั้งชื่อ::l::Name not set")."]";
		echo $name;
		die;
	} 
	$s=tmq_fetch_array($s);
	$shelf=$s[shelf] ;

tmq("update media_mid set libsite='$siteoflib' where $qnid='YES'  and place='$shelf' ");
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
alert("<?php  echo getlang("การดำเนินการเรียบร้อย::l::Operation done."); ?> ");
//-->
</SCRIPT>
<?php 
redir("if_manage.php?qnid=$qnid");

	?>