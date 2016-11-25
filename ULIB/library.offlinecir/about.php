<?php 
	; 
		
        include ("../inc/config.inc.php");
		//head();
		html_start();
		include("_REQPERM.php");
		loginchk_lib();

		html_dialog("Information",getlang("ระบบสำหรับนำเข้าไฟล์ที่ได้จากการยืมคืนแบบ Offline Mode::l::Import functions for Circulation in offline mode"));
?>