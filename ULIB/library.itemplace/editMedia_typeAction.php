<?php 
;
include("../inc/config.inc.php");
$_REQPERM="itemplace";
html_start();
$tmp=mn_lib();// พ

$sql="update media_place set code='$code', name='$name'  , isrq='$isrq'  , collcode='$collcode' 
where code='$mid'";
       tmq( $sql);
	redir("media_type.php");

?>