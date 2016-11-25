<?php             include ("../../inc/config.inc.php");
				include("../_REQPERM.php");// พ
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
memid='$UserAdminID',
edittype='upload photo by camera    '   ");


?><SCRIPT LANGUAGE="JavaScript">
<!--
	self.close();
//-->
</SCRIPT>