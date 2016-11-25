<?php 
function lang_control() {
	global $lang_control_set;
	global $_SESSION;
	//$lang_control_set=urld($lang_control_set);
	if ($_SESSION['lang_control_val']=="") {
		$_SESSION['lang_control_val']='th';
	}
	if ($lang_control_set=='th') {
		$_SESSION['lang_control_val']='th';
		?><SCRIPT LANGUAGE="JavaScript">
		<!--
		alert("เปลี่ยนภาษาเป็นภาษาไทย");
		//-->
		</SCRIPT><?php 
	}
	if ($lang_control_set=='en') {
		$_SESSION['lang_control_val']='en';
		?><SCRIPT LANGUAGE="JavaScript">
		<!--
		alert("Change Language to English.");
		//-->
		</SCRIPT><?php 
	}
}
?>