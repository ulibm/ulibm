<?php 
	; 
		
        include ("../inc/config.inc.php");
		//head();
		//html_start();// พ
		include("_REQPERM.php");
		loginchk_lib();
       // mn_lib();

	   header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=file.csv");
header("Pragma: no-cache");
header("Expires: 0");
   echo "\xEF\xBB\xBF"; //UTF-8 BOM
   
$s=tmq("select * from bibana");
echo "BibID,Title,checkoutcount,checkoutperiod,use inside lib,webactivity
";
while ($r=tfa($s)) {
	echo $r[bibid].",";
	echo str_replace(","," ",marc_gettitle($r[bibid])).",";
	echo $r[checkoutcount].",";
	echo $r[checkoutperiod].",";
	echo $r[usedbook].",";
	echo $r[webactivity].",";
echo "
";
}
?>