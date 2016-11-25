<?php 
include("../inc/config.inc.php");
head();
mn_root("membercustomfield");
$tbname="member_customfield";


$c[2][text]="Name::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="แสดงฟิลด์นี้หรือไม่::l::Show this field";
$c[3][field]="isshow";
$c[3][fieldtype]="list:yes,no";
$c[3][descr]="";
$c[3][defval]="yes";

$c[4][text]="ค่าเริ่มต้น::l::default val";
$c[4][field]="defval";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="Field ID.";
$c[5][field]="fid";
$c[5][fieldtype]="readonlytext";
$c[5][descr]="";
$c[5][defval]="";
/*
$c[6][text]="ประเภทฟิลด์::l::Field type";
$c[6][field]="ftype";
$c[6][fieldtype]="list:yesno,text";
$c[6][descr]="";
$c[6][defval]="text";
*/
//dsp


$dsp[2][text]="Name::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="30%";

$dsp[3][text]="แสดงฟิลด์นี้หรือไม่::l::Show this field";
$dsp[3][field]="isshow";
$dsp[3][filter]="switchsingle";
$dsp[3][width]="30%";

$dsp[5][text]="Field ID.";
$dsp[5][field]="fid";
$dsp[5][width]="30%";

/*
$dsp[6][text]="Ftype::l::Ftype";
$dsp[6][field]="ftype";
$dsp[6][width]="30%";
*/
fixform_tablelister($tbname," 1 ",$dsp,"no","yes","no","mi=$mi",$c);


foot();
?>