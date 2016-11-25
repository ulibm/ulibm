<?php 
    ;
            include("../inc/config.inc.php");
            if (empty($ID)) {
				 html_dialog("","กรุณาตรวจสอบ::l::Please re-correct ");
			}
tmq("delete from request_list where itemid='$ID' ");
				redir("mainadmin.php");
        ?>