<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="membertype";
$tmp=mn_lib();
pagesection($tmp);

$tbname="member_type";


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

$c[6][text]="เน้นสี::l::Indicate color";
$c[6][field]="col";
$c[6][fieldtype]="color";
$c[6][descr]="";
$c[6][defval]="000000";
//dsp


$dsp[1][text]="รหัส::l::Code";
$dsp[1][field]="type";
$dsp[1][filter]="module:localtype";
$dsp[1][width]="20%";
function localtype($w) {
   return html_membertype_icon($w[type]).$w[type];
}

$dsp[2][text]="ชื่อประเภทสมาชิก::l::Type name";
$dsp[2][field]="descr";
$dsp[2][width]="30%";

$dsp[3][text]="ยืมวัสดุสารสนเทศได้(ชิ้น)::l::Max material item can hold";
$dsp[3][field]="limithold";
$dsp[3][width]="30%";

$dsp[5][text]="ค่าปรับสุงสุด::l::Max Fine";
$dsp[5][field]="maxfine";
$dsp[5][width]="10%";

$dsp[4][text]="จองห้อง::l::request  room";
$dsp[4][field]="grant_room";
$dsp[4][filter]="switchsingle";
$dsp[4][width]="30%";

$o[undelete][field]="type";
$o[undelete][value]="onlineregist";
$o[undeletearr][type]="temp";
//$o[unedit][field]="type";
//$o[unedit][value]="onlineregist";

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"",$o);

foot(); 
?>