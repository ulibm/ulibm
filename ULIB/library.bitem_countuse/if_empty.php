<?php 
	; 
		
        include ("../inc/config.inc.php");
loginchk_lib();
?><style>
body {
	background-color: #F4F4F4;
}
</style>
<?php 
ConnDB();
tmq("update media_mid set $qnid='NO' where $qnid='YES' ");
?><SCRIPT LANGUAGE="JavaScript">
	<!--
	alert("<?php  echo getlang("การทำงานเรียบร้อย::l::Operation success.")?>");
	top.location.reload();
	//-->
	</SCRIPT>