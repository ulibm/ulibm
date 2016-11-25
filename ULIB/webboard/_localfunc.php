<?php 
include($dcrs."webboard/inc/viewtopicrow.php");
include($dcrs."webboard/inc/viewpost.php");
include($dcrs."webboard/inc/local_getfilesize.php");
include($dcrs."webboard/inc/pathgen.php");
include($dcrs."webboard/inc/viewpostminimum.php");
// พ
if (strtolower(barcodeval_get("webboard-isenable"))!="yes") {
   head();
   mn_web("webboard");
   html_dialog("Denied","Webboard disabled by setting");
   foot();
   die;
}
?>