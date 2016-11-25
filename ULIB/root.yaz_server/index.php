<?php 
include("../inc/config.inc.php");
head();
mn_root("yaz_sv");

$tbname="yaz_sv";


$c[2][text]="ชื่อ::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="หมายเหตุ::l::Note";
$c[3][field]="descr";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="เซิร์ฟเวอร์::l::Server";
$c[4][field]="server";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="พอร์ท::l::Port";
$c[5][field]="port";
$c[5][fieldtype]="text";
$c[5][descr]="";
$c[5][defval]="";

$c[6][text]="กลุ่ม::l::Group";
$c[6][field]="group1";
$c[6][fieldtype]="text";
$c[6][descr]="";
$c[6][defval]="";

$c[7][text]="ล็อกอิน::l::Login";
$c[7][field]="login";
$c[7][fieldtype]="text";
$c[7][descr]="";
$c[7][defval]="";

$c[8][text]="รหัสผ่าน::l::Password";
$c[8][field]="pwd";
$c[8][fieldtype]="text";
$c[8][descr]="";
$c[8][defval]="";

$c[9][text]="ฐานข้อมูล::l::Database";
$c[9][field]="db";
$c[9][fieldtype]="text";
$c[9][descr]="";
$c[9][defval]="";

$c[10][text]="แสดง::l::Show";
$c[10][field]="isshow";
$c[10][fieldtype]="list:YES,NO";
$c[10][descr]="";
$c[10][defval]="YES";

$c[10][text]="เรียงลำดับ::l::Order";
$c[10][field]="ordr";
$c[10][fieldtype]="number";
$c[10][descr]="";
$c[10][defval]="0";

//dsp


$dsp[2][text]="ชื่อ::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="30%";

$dsp[3][text]="หมายเหตุ::l::Note";
$dsp[3][field]="descr";
$dsp[3][width]="30%";

$dsp[4][text]="เซิร์ฟเวอร์::l::Server";
$dsp[4][field]="server";
$dsp[4][width]="30%";

$dsp[10][text]="แสดง::l::Show";
$dsp[10][field]="isshow";
$dsp[10][width]="30%";


fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"ordr");

foot();
?>