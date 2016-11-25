<?php 
include("../inc/config.inc.php");
$o= shell_exec($dcrs."_sip/sipServerInitializer.sh");
echo shell_exec($dcrs."_sip/sipServerInitializer.sh > /dev/null 2>/dev/null &");

//echo "<pre>$o</pre>";
 // พ 
?>