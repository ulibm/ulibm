<?php 
	; 
		// พ
        include ("../inc/config.inc.php");
		//head();
		//html_start();
		include("_REQPERM.php");
		loginchk_lib();
       // mn_lib();

	   header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=file.csv");
header("Pragma: no-cache");
header("Expires: 0");

$s=tmq("select * from memana");
echo "Barcode,Prefix,name,checkoutcount,checkoutperiod,finecount,fineamount,webactivity,Entrance
";
while ($r=tfa($s)) {
	$m=tmq("select * from member where UserAdminID='$r[memid]' ");
	$m=tfa($m);
	echo $r[memid].",";
	echo $m[prefix].",";
	echo $m[UserAdminName].",";
	echo $r[checkoutcount].",";
	echo $r[checkoutperiod].",";
	echo $r[finecount].",";
	echo $r[fineamount].",";
	echo $r[webactivity].",";
	echo $r[mscount]."";
echo "
";
}
?>