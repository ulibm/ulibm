<?php 
	; // พ
		
        include ("../inc/config.inc.php");
        loginchk_root();
				if ($result!=base64_decode($result2)) {
					 die();
				}
					barcodeval_set("activateulib-refcode",$result);
					barcodeval_set("activateulib-status","registered");					
?><script>
top.location="index.php";
</script>