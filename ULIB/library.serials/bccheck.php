<?php 
    include("../inc/config.inc.php"); 
html_start();
/*?><style>
body {
	margin: 0px 0px 0px 0px;
	padding: 0px 0px 0px 0px;
}
</style><?php */
function localerr($wh) {
	echo "<B style='color:red; font-size:12' class=smaller>";
	echo getlang($wh);
	echo "</B>";
	die;
}

	$bcchk=str_remspecialsign($bc);
	$bcchk=str_replace(' ','',$bcchk);
	$bcchk=str_replace(';','',$bcchk);
	$bcchk=trim($bcchk);

	///echo "[$bcchk!=$bc]";
	if ($bcchk!=$bc) {
		localerr("ห้ามกรอกเครื่องหมายพิเศษเป็นรหัสบาร์โค้ด::l::Do not use special character");
	}
	if ($bcchk=="") {
		localerr("กรุณากรอกบาร์โค้ด::l::Barcode cannot be empty");
	}

	$c=tmq("select * from media_mid where bcode='$bcchk' and bcode<>'$forceskip' ");
	if (tmq_num_rows($c)!=0) {
		localerr("บาร์โค้ดนี้ถูกใช้ไปแล้ว::l::Barcode already registered");
	}

	echo "<B style='color:darkgreen; font-size: 10px;' class=smaller>";
	echo getlang("คุณสามารถใช้บาร์โค้ดนี้ได้ [$bcchk]::l::You can use this barcode [$bcchk]");
	echo "</B>";

?>