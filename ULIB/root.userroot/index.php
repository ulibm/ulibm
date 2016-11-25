<?php 
;
include("../inc/config.inc.php");
head();
$tmp=mn_root("useradmin");
pagesection($tmp);

$tbname="useradmin";

$c[1][text]="รหัสล็อกอิน::l::Loginid";
$c[1][field]="UserAdminID";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[1][defval]="LoginID";
$c[2][text]="ชื่อเจ้าหน้าที่::l::Name";
$c[2][field]="UserAdminName";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="UserName";
$c[3][text]="รหัสผ่าน::l::Password";
$c[3][field]="Password";
$c[3][fieldtype]="password";
$c[3][descr]="";
$c[3][defval]="123";

$dsp[1][text]="รหัสล็อกอิน::l::Loginid";
$dsp[1][field]="UserAdminID";
$dsp[1][width]="30%";
$dsp[2][text]="ชื่อเจ้าหน้าที่::l::Name";
$dsp[2][field]="UserAdminName";
$dsp[2][width]="70%";

if ($fftmode=="delete") {
	$chk=tmq("select * from $tbname");
	//echo tmq_num_rows($chk);
	if (tmq_num_rows($chk)==1) {
		$fftmode="";
		html_dialog("",getlang("ไม่อนุญาตให้ลบ Admin จนหมด::l::Cannot delete all Admin."));
	}
}
//echo "[$delable]";
fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"",$o);

foot();
?>