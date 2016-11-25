<?php 
	; 
		
        include ("../inc/config.inc.php");// พ
		//head();
		//html_start();
		include("_REQPERM.php");
		loginchk_lib();
		html_start();
       // mn_lib();

?><iframe style="width: 100%; height: 100%;" 
src="<?php  echo barcodeval_get("automated-url");?>library.automated/sv/setjobs.php?refcode=<?php  echo barcodeval_get("activateulib-refcode")?>&refurl=<?php  echo urlencode($dcrURL);?>"
></iframe>