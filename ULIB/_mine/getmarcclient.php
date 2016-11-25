<?php 
;
include("../inc/config.inc.php");
if ($TARGETID!="") {
	 statordr_add("sharemarc","$TARGETID");
	 stat_add("sharemarc_type","mined");
	 echo marc_export($TARGETID);
	die;	 // พ 
}
?>