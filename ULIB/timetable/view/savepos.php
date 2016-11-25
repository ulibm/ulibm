<?php  
;
include("../../inc/config.inc.php");
include("./_REQPERM.php");
loginchk_lib();
tmq("update rqroom_roomsub set js_x='$js_x', js_y='$js_y' where id='$subid' ");
// พ
?>