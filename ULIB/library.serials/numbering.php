<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="serial-numberingtype";
mn_lib();
$tbname="serials_numberingtype";

$c[11][text]="รหัส::l::Code";
$c[11][field]="code";
$c[11][fieldtype]="text";
$c[11][descr]="";
$c[11][defval]="";

$c[2][text]="Name::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="ชื่อฟิลด์ 1::l::Field 1 name";
$c[3][field]="field1";
$c[3][fieldtype]="text";
$c[3][descr]="ปล่อยว่าง หากไม่ต้องแสดง";
$c[3][defval]="";

$c[4][text]="ชื่อฟิลด์ 2::l::Field 2 name";
$c[4][field]="field2";
$c[4][fieldtype]="text";
$c[4][descr]="ปล่อยว่าง หากไม่ต้องแสดง";
$c[4][defval]="";

$c[5][text]="ชื่อฟิลด์ 3::l::Field 3 name";
$c[5][field]="field3";
$c[5][fieldtype]="text";
$c[5][descr]="ปล่อยว่าง หากไม่ต้องแสดง";
$c[5][defval]="";

$c[7][text]="การเรียงลำดับฟิลด์  2::l::Pattern of field 2";
$c[7][field]="field2e";
$c[7][fieldtype]="text";
$c[7][descr]="หากไม่ใช้ให้ปล่อยว่าง, -1 เพื่อใช้แบบเรียงลำดับ";
$c[7][defval]=",";

$c[8][text]="การเรียงลำดับฟิลด์  3::l::Pattern of field 3";
$c[8][field]="field3e";
$c[8][fieldtype]="text";
$c[8][descr]="หากไม่ใช้ให้ปล่อยว่าง, -1 เพื่อใช้แบบเรียงลำดับ";
$c[8][defval]=",";

$c[6][text]="MARC Frequency Code";
$c[6][field]="marccode";
$c[6][fieldtype]="text";
$c[6][descr]="";
$c[6][defval]="";

/*
$c[6][text]="เริ่มฟิลด์ 1 ด้วย::l::start field 1 with";
$c[6][field]="field1s";
$c[6][fieldtype]="number";
$c[6][descr]="";
$c[6][defval]="1";

$c[7][text]="เริ่มฟิลด์ 2 ด้วย::l::start field 2 with";
$c[7][field]="field2s";
$c[7][fieldtype]="number";
$c[7][descr]="";
$c[7][defval]="1";

$c[8][text]="เริ่มฟิลด์ 3 ด้วย::l::start field 3 with";
$c[8][field]="field3s";
$c[8][fieldtype]="number";
$c[8][descr]="";
$c[8][defval]="1";

$c[9][text]="เริ่มฟิลด์ 1 ใหม่เมื่อถึง::l::Rollover field 1 at";
$c[9][field]="field1r";
$c[9][fieldtype]="number";
$c[9][descr]="";
$c[9][defval]="99999";

$c[10][text]="เริ่มฟิลด์ 2 ใหม่เมื่อถึง::l::Rollover field 2 at";
$c[10][field]="field2r";
$c[10][fieldtype]="number";
$c[10][descr]="";
$c[10][defval]="99999";

$c[11][text]="เริ่มฟิลด์ 3 ใหม่เมื่อถึง::l::Rollover field 3 at";
$c[11][field]="field3r";
$c[11][fieldtype]="number";
$c[11][descr]="";
$c[11][defval]="99999";
*/

//dsp


$dsp[2][text]="Name::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="30%";


fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"",$o);

html_libmann("serial_marc_freqcode","yes");

foot();
?>