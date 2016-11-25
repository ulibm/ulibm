<?php // พ
function html_htmlareajs() {
	global $dcr;
	global $dcrURL;
	global $_html_htmlareajsloaded;
	if ($_html_htmlareajsloaded!="yes") {
		$_html_htmlareajsloaded="yes";
		?><script type="text/javascript" src="<?php  echo $dcrURL; ?>/js/ckeditor/ckeditor.js"></script><?php 
	}
}
?>