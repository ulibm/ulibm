<?php 
include ("$dcrs"."library.selfcheckio/ip_in_range.php");
// พ
$s=tmq("select * from selfcheckio where id='$id' ");
if (tnr($s)!=1) {
	html_dialog("error","selfcheckio id=$id not found"); die;
}
$s=tfa($s);
$LIBSITE=$s[libsite];
$_coengine="selfcheckio";

function local_gethtml($item) {
	global $s;
	$tmp=getlang(barcodeval_get("selfcheckio-html-$s[id]-$item"));
	$tmp=stripslashes($tmp);
	echo $tmp;
}
?>	<link rel="stylesheet" type="text/css" href="page.css.php?id=<?php  echo $s[id];?>" />
	<link rel="stylesheet" type="text/css" href="misc.css" />

<style>
body {
	background-image: none!important;
}
</style>