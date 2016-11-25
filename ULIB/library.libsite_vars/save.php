<?php 
;
include("../inc/config.inc.php");
html_start();
$_REQPERM="libsite_vars";
$tmp=mn_lib();
// พ
//print_r($_POST);

$s=tmq("select * from libsite_vars order by name");
while ($r=tmq_fetch_array($s)) {
	eval("\$value=\$VAR_$r[code];");
	//echo "$r[code]=$value<BR>";
	if ($value!="") {
		tmq("delete from libsite_vars_vars where libsite='$libsite' and varitem  ='$r[code]' ");
		tmq("insert into libsite_vars_vars set libsite ='$libsite' , varitem  ='$r[code]' , value='$value'" );
	} 
}
redir("permission.php?libsite=$libsite");
?>