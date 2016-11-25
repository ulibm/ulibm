<?php  
include ("../inc/config.inc.php");
				include("../_REQPERM.php");
					loginchk_lib();
		$suff=barcodeval_get("memberpic-local-suffix");
		$pref=barcodeval_get("memberpic-local-prefix");
		$target="$dcrs/pic/$pref$id$suff";
		//echo "[$target]";
     @copy("./file/temp$useradminid.jpg", $target); 
	@unlink("./file/temp$useradminid.jpg");
	
				 $now=time();
tmq("insert into member_edittrace set 
login='$useradminid',
dt='$now',
memid='$id',
edittype='upload photo by camera   '   ");


?><SCRIPT LANGUAGE="JavaScript">
<!--
	alert("เรียบร้อย");
//-->
</SCRIPT>