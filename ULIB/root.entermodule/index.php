<?php 
include("../inc/config.inc.php");
head();
$tmp=mn_root("entermodule");
pagesection($tmp);

$tbname="library";


$c[2][text]="รหัสล็อกอิน::l::Loginid";
$c[2][field]="UserAdminID";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="loginid";

$c[3][text]="Password::l::Password";
$c[3][field]="Password";
$c[3][fieldtype]="password";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="ประจำห้องสมุดสาขา::l::On campus";
$c[4][field]="libsite";
$c[4][fieldtype]="foreign:-localdb-,library_site,code,name";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="ชื่อเจ้าหน้าที่::l::Librarian's Name";
$c[5][field]="UserAdminName";
$c[5][fieldtype]="text";
$c[5][descr]="";
$c[5][defval]="";

$c[6][text]="โน๊ตย่อ::l::Note";
$c[6][field]="descr";
$c[6][fieldtype]="text";
$c[6][descr]="";
$c[6][defval]="";

$c[7][text]="ล็อกอินอัตโนมัติโดยไอพี::l::Autologin by IP";
$c[7][field]="ipautologin";
$c[7][fieldtype]="text";
$c[7][descr]="";
$c[7][defval]="0.0.0.0";

$c[9][text]="เมนูเริ่มต้น::l::Default Menu";
$c[9][field]="defmenu";
$c[9][fieldtype]="special_libmenu";
$c[9][descr]="<BR>กรุณาแน่ใจว่าได้ให้สิทธิ์นี้ในการอนุญาตแล้ว::l::<BR>Make sure that this permission is allowed";
$c[9][defval]="";

$c[8][text]="ภาษาเริ่มต้น::l::Default language";
$c[8][field]="autolang";
$c[8][fieldtype]="list:th,en";
$c[8][descr]="";
$c[8][defval]="th";

$c[10][text]="อนุญาตให้ล็อกอิน::l::Allow to login";
$c[10][field]="isallowlogin";
$c[10][fieldtype]="list:YES,NO";
$c[10][descr]="";
$c[10][defval]="YES";

$c[11][text]="อนุญาตให้ใช้งานได้ทุกระบบ::l::Allow All Function";
$c[11][field]="isallowall";
$c[11][fieldtype]="list:YES,NO";
$c[11][descr]="";
$c[11][defval]="NO";

//dsp


$dsp[2][text]="รหัสล็อกอิน::l::Loginid";
$dsp[2][field]="UserAdminID";
$dsp[2][width]="15%";

$dsp[4][text]="ประจำห้องสมุดสาขา::l::On campus";
$dsp[4][field]="libsite";
$dsp[4][width]="25%";
$dsp[4][filter]="foreign:-localdb-,library_site,code,name";

$dsp[5][text]="ชื่อเจ้าหน้าที่::l::Librarian's Name";
$dsp[5][field]="UserAdminName";
$dsp[5][width]="20%";

$dsp[6][text]="การอนุญาต::l::Permission";
$dsp[6][field]="descr";
$dsp[6][align]="center";
$dsp[6][filter]="module:local_perm";//"linkout:./permission.php?ID=[value-UserAdminID]";
$dsp[6][width]="250%";
function local_perm($wh) {
	$cc=tmq("select * from library_entermodule where loginid='$wh[UserAdminID]' ");
	if (tnr($cc)==0) {
		return  "<B style='color:#919191'>".getlang("ไม่พบประวัติ::l::No logs")."</B>";
	} else {
		$s="<a href='./view.php?ID=$wh[UserAdminID]'>".getlang("ดูประวัติ::l::View logs")." (".tnr($cc).")</a>";
		return $s;
	}
}

fixform_tablelister($tbname," 1 ",$dsp,"no","no","no","mi=$mi",$c);

foot();
?>