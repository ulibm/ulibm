<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="viewstrdiff";
$tmp=mn_lib();
pagesection($tmp);

$tbname="viewdiffman_cate";

$deleteall=trim($deleteall);
if ($deleteall!="") {
	tmq("delete from viewdiffman where cate='$deleteall' ",false);
}
$c[1][text]="รหัส::l::Code";
$c[1][field]="type";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[1][defval]="student";

$c[2][text]="ชื่อประเภทสมาชิก::l::Type name";
$c[2][field]="descr";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="ยืมวัสดุสารสนเทศได้(ชิ้น)::l::Max material item can hold";
$c[3][field]="limithold";
$c[3][fieldtype]="number";
$c[3][descr]="";
$c[3][defval]="10";

$c[5][text]="ค่าปรับสูงสุดที่จะยืมวัสดุได้::l::Max fine can hold";
$c[5][field]="maxfine";
$c[5][fieldtype]="number";
$c[5][descr]="";
$c[5][defval]="20";

$c[4][text]="การอนุญาตให้จองห้อง::l::Allow request service room";
$c[4][field]="grant_room";
$c[4][fieldtype]="list:yes,no";
$c[4][descr]="";
$c[4][defval]="no";

//dsp

/*
$dsp[1][text]="รหัส::l::Code";
$dsp[1][field]="type";
$dsp[1][width]="20%";
*/

$dsp[2][text]="หมวดหมู่::l::Category";
$dsp[2][field]="name";
$dsp[2][filter]="module:local_name";
$dsp[2][width]="30%";
function local_name($wh) {
	return getlang($wh[name]);
}

$dsp[3][text]="จัดการ::l::Manage";
$dsp[3][field]="id";
$dsp[3][filter]="module:local_man";
$dsp[3][width]="30%";
function local_man($wh) {
	$cc=tmq("select count(id) as cc from viewdiffman where cate='$wh[code]' ");
	$cc=tfa($cc);
	$s="<a href=\"sub.php?pid=$wh[code]\" class=a_btn>".getlang("ดู::l::View")."</a> (".number_format($cc[cc]).") : <a href=\"index.php?deleteall=$wh[code]\" style='color:red' onclick=\"return confirm('Please Confirm');\" class=a_btn>".getlang("ลบทั้งหมด::l::Delete all")."</a> ";
		
	return $s;
}

fixform_tablelister($tbname," 1 ",$dsp,"no","no","no","mi=$mi",$c,"",$o);

foot(); 
?>