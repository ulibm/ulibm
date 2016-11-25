<?php 
;
include("inc/config.inc.php");

	if ($lang_control_val=="") {
		$lang_control_val='th';
		ulibsess_register("lang_control_val");
	}
	if ($lang_control_set=='th') {
		$lang_control_val='th';
		ulibsess_register("lang_control_val");
		?><SCRIPT LANGUAGE="JavaScript">
		<!--
		alert("เปลี่ยนภาษาเป็นภาษาไทย\n\nจะเห็นผลการเปลี่ยนแปลงเมื่อมีการโหลดเพจครั้งต่อไป");
		//-->
		</SCRIPT><?php 
	}
	if ($lang_control_set=='en') {
		$lang_control_val='en';
		ulibsess_register("lang_control_val");
		?><SCRIPT LANGUAGE="JavaScript">
		<!--
		alert("Change Language to English.\n\nSetting will take effect after next page load.");
		//-->
		</SCRIPT><?php 
	}
	//print_r($_SESSION);

?>