<?php 
include_once("../inc/config.inc.php");
html_start();
include_once("./inc.php");
	sessionval_set("bcoutlist","");
// พ
local_gethtml("out_scanmemberbc");

?>