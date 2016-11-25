<?php  //พc
;
include("../inc/config.inc.php");

$_REQPERM="bibstream";
head();
mn_lib();
$kw=trim($kw);
if ($kw!="") {
?><center><iframe src="<?php  echo getval("SYSCONFIG","ulibbibstreamurl");?>/run/index.php?refcode=<?php  echo barcodeval_get("activateulib-refcode")?>&baseu=<?php  echo urlencode($dcrURL);?>&instantsearchkw=<?php  echo $kw?>&instantsearch=yes" width=<?php  echo $_TBWIDTH?> height=3000 frameborder=no></iframe></center>
<?php 
	foot();
	die;
}
?>
<center><iframe src="<?php  echo getval("SYSCONFIG","ulibbibstreamurl");?>/cli/index.php?refcode=<?php  echo barcodeval_get("activateulib-refcode")?>&baseu=<?php  echo urlencode($dcrURL);?>" width=<?php  echo $_TBWIDTH?> height=3000 frameborder=no></iframe></center>
<?php 

foot();  
?>