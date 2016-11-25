<?php 
    include("../inc/config.inc.php"); 
html_start();
function localerr($wh,$showmore="") {
global $dcrURL;
	echo "<B style='color:red; font-size:12' class=smaller>";
	echo getlang($wh);
	echo "</B>";
	if ($showmore!="") {
		$s=tmq("Select * from member where UserAdminName like '$showmore%' limit 20");
      while ($r=tfa($s)) {
         echo " <a href='$dcrURL"."library.member/detail.php?id=$r[UserAdminID]' target=_blank class=smaller2>".stripslashes($r[UserAdminName])."[$r[UserAdminID]]</a>";
      }
	}
	die;
}

	$bcchk=addslashes($name);
	$bcchk=str_replace('  ',' ',$bcchk);
	$bcchk=str_replace(';','',$bcchk);
	$bcchk=trim($bcchk);

	///echo "[$bcchk!=$bc]";
	if ($bcchk!=$bc) {
		//localerr("ห้ามกรอกเครื่องหมายพิเศษเป็นรหัสบาร์โค้ด::l::Do not use special character");
	}
	if ($bcchk=="") {
		localerr("กรุณากรอกชื่อ::l::Name cannot be empty");
	}

	$c=tmq("Select id from member where UserAdminName like '$bcchk%' ");
	if (tnr($c)!=0) {
		localerr("มีชื่อซ้ำในฐานข้อมูล::l::Duplicate name found",$bcchk);
	}

	echo "<B style='color:darkgreen; font-size: 10px;' class=smaller>";
	echo getlang("ไม่พบชื่อสมาชิกซ้ำซ้อน [$bcchk]::l::No duplicate name found [$bcchk]");
	echo "</B>";

?>