<?php  
;
include("../inc/config.inc.php");
include("./_REQPERM.php");
loginchk_lib();// พ
tmq("update media_place_shelf set mappos='$js_x,$js_y' where id='$subid' ",true);
?>