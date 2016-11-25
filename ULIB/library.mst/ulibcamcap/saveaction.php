<?php             include ("../../inc/config.inc.php");
				include("../_REQPERM.php");
					loginchk_lib();
		$suff=barcodeval_get("memberpic-local-suffix");
		$pref=barcodeval_get("memberpic-local-prefix");
		$target="$dcrs/pic/$pref$id$suff";
		//echo "[$target]";// พ
     @copy("./file/temp$useradminid.jpg", $target); 
	@unlink("./file/temp$useradminid.jpg");
?><SCRIPT LANGUAGE="JavaScript">
<!--
	self.close();
//-->
</SCRIPT>