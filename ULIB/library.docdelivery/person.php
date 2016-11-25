<?php 
include("../inc/config.inc.php");
include("trap.admin.php");
html_start();

$s=tmq("select * from library");
while ($r=tfa($s)) {
	$chk=tmq("select * from docdelivery_person where loginid='$r[UserAdminID]' ");
	if (tnr($chk)==0) {
		tmq("insert into docdelivery_person set loginid='$r[UserAdminID]' ");
	}
}
$s=tmq("select * from docdelivery_person");
while ($r=tfa($s)) {
	$chk=tmq("select * from library where UserAdminID='$r[loginid]' ");
	if (tnr($chk)==0) {
		tmq("delete from docdelivery_person where loginid='$r[loginid]' ");
	}
}

$tbname="docdelivery_person";

$c[2][text]="ล็อกอินบุคลากร::l::Loginid";
$c[2][field]="loginid";
$c[2][fieldtype]="readonlytext";
$c[2][descr]="";
$c[2][defval]="";


$c[4][text]="ฝ่าย::l::Office";
$c[4][field]="office";
$c[4][fieldtype]="foreign:-localdb-,docdelivery_office,id,name";
$c[4][descr]="";
$c[4][defval]="";

//dsp


$dsp[1][text]="เจ้าหน้าที่::l::Librarian";
$dsp[1][field]="name";
$dsp[1][filter]="module:local_officer";
$dsp[1][width]="50%";
function local_officer($wh) {
	//printr($wh);
	return html_library_name($wh[loginid]);
}

$dsp[2][text]="ชื่อฝ่าย::l::Office";
$dsp[2][filter]="module:local_office";
$dsp[2][field]="ordr";
$dsp[2][width]="30%";
function local_office($wh) {
	//printr($wh);
	$s=tmq("select * from docdelivery_office where id='$wh[office]' ",false);
	$s=tfa($s);
	$s=getlang($s[name]);
	if ($s=="") {
		$s="<i>".getlang("ไม่ได้ระบุฝ่าย::l::Unspecified")."</i>";
	}
	return $s;
}

$_TBWIDTH="100%";
fixform_tablelister($tbname," 1 ",$dsp,"no","yes","no","mi=$mi",$c,"loginid",$o,"","");

?>