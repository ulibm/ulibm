<?php 
	; // พ
		
        include ("../inc/config.inc.php");
        loginchk_root();
				if ($result!=base64_decode($result2)) {
					 die();
				}
					barcodeval_set("activateulib-refcode","");
					barcodeval_set("activateulib-status","");					
?><script>
top.location="index.php";
</script>