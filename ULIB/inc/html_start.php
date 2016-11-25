<?php 
function html_start($isbody="yes") {
	global $html_start_evelcall;
	global $html_start_title;
   global $_ISULIBHAVESTER;
	global $dcr;
	global $dcrs;
	global $dcrURL;
	if ($html_start_evelcall=="yes") {
		return;
	}
	$html_start_evelcall="yes";
	$html_start_title=getval("global","TITLE BAR");
	if ($html_start_title=="") {
		$html_start_title="ระบบห้องสมุดอัตโนมัติ ULibM";
	}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<!-- ULibM 6.2 Hexagram.UTF8 -->
<TITLE><?php  echo $html_start_title; ?></TITLE>
<?php 
//$html_start_title="";	
//<script language="javascript" src="< ? echo $dcrURL? >js/reflection.js" type="text/javascript"></script>
?>
<link rel="shortcut icon" type="image/x-icon" href="<?php  echo $dcrURL?>neoimg/ulibfavicon.png" />
<link rel="icon" type="image/x-icon" href="<?php  echo $dcrURL?>neoimg/ulibfavicon.png" />
<?php 
echo stripslashes(barcodeval_get("webpage-o-pagemetadata"));	
?>
<script language="javascript" src="<?php  echo $dcrURL?>js/dom-drag.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?php  echo $dcrURL?>css/css.php" />
<SCRIPT LANGUAGE="JavaScript" src="<?php  echo $dcrURL?>js/ajaxroutine.js"></SCRIPT>
<meta name="viewport" content="width=1024, initial-scale=1">

<!-- uGreyBox -->
<SCRIPT LANGUAGE="JavaScript" src="<?php  echo $dcrURL?>js/common.php"></SCRIPT>
<script type="text/javascript" src="<?php  echo $dcrURL?>js/ugreybox/js.php"></script> 
<link rel="stylesheet" type="text/css" href="<?php  echo $dcrURL?>js/ugreybox/css.php" />
<?php
   if ($_ISULIBHAVESTER=="yes") {
   include($dcrs."_havester/dec.php");
   } 
?>
<!-- intro.js -->
<link href="<?php  echo $dcrURL?>js/intro/introjs.css" rel="stylesheet">
<script type="text/javascript" src="<?php  echo $dcrURL?>js/intro/intro.js"></script>
<?php
addons_module("html_start_insidehead");

?>
</HEAD>
<?php 
	if ($isbody=="yes") {
		?><BODY>
		<div class="ulibpage-wrap">
		<?php
	}
}
?>