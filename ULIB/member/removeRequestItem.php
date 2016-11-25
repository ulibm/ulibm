<?php 
    ;
            include("../inc/config.inc.php");
            if (empty($ID)) {
				 html_dialog("","กรุณาตรวจสอบ::l::Please re-correct ");
			}
                tmq("update checkout set request='' where id=$ID");
				redir("mainadmin.php");
        ?>