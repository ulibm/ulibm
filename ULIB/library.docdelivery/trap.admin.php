<?php 
if (!library_gotpermission("docdelivery_manager")) {
	html_dialog("error"," Permission Denied");
	die();
}
pagesection("ระบบเอกสาร::l::Document Delivery System");

?>