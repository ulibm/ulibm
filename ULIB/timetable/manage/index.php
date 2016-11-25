<?php 
;
include("../../inc/config.inc.php");
include("./_REQPERM.php");
head();
mn_lib();

$localcatehead="yes";
//include("../persinfo/inc.head.php");
pagesection("กรุณาเลือกห้องที่จะจัดการ::l::Choose from options");
$tbname="rqroom_maintb";

$c[1][text]="ห้องที่ให้บริการ::l::Room name";
$c[1][field]="name";
$c[1][fieldtype]="text";
$c[1][descr]="";

$c[3][text]="Code";
$c[3][field]="code";
$c[3][fieldtype]="text";
$c[3][descr]="";

$c[2][text]="ข้อความเพิ่มเติม::l::Note";
$c[2][field]="descr";
$c[2][fieldtype]="longtext";
$c[2][descr]="";

$c[4][text]="เปิดให้จองหรือไม่::l::Open for request";
$c[4][field]="isshow";
$c[4][fieldtype]="list:Yes,No";
$c[4][descr]="";

$c[18][text]="เปิดให้จองแม้ไม่สร้างกิจกรรม::l::Auto Open without events";
$c[18][field]="isautoopen";
$c[18][fieldtype]="list:Yes,No";
$c[18][descr]="";

$c[5][text]="วันเริ่มให้บริการ::l::Start allow";
$c[5][field]="dtstart";
$c[5][fieldtype]="date";
$c[5][descr]="";

$c[6][text]="ให้บริการจนถึง::l::End";
$c[6][field]="dtend";
$c[6][fieldtype]="date";
$c[6][descr]="";

$c[11][text]="จองล่วงหน้าได้กี่วัน::l::จองล่วงหน้าได้กี่วัน";
$c[11][field]="day_preserv";
$c[11][fieldtype]="number";
$c[11][descr]=" กรอก 0 หากไม่ต้องการกำหนด";

$c[7][text]="สงวนเฉพาะสมาชิก::l::Only for member type";
$c[7][field]="grantonly1";
$c[7][fieldtype]="foreign:-localdb-,member_type,type,descr,allowblank";
$c[7][descr]=" หรือ ::l:: or ";

$c[8][text]="สงวนเฉพาะสมาชิก::l::Only for member type";
$c[8][field]="grantonly2";
$c[8][fieldtype]="foreign:-localdb-,member_type,type,descr,allowblank";
$c[8][descr]=" หรือ ::l:: or ";

$c[9][text]="สงวนเฉพาะสมาชิก::l::Only for member type";
$c[9][field]="grantonly3";
$c[9][fieldtype]="foreign:-localdb-,member_type,type,descr,allowblank";
$c[9][descr]=" หรือ ::l:: or ";

$c[10][text]="สงวนเฉพาะสมาชิก::l::Only for member type";
$c[10][field]="grantonly4";
$c[10][fieldtype]="foreign:-localdb-,member_type,type,descr,allowblank";
$c[10][descr]="   ";

$c[14][text]="ประเภทสมาชิกที่สร้างกิจกรรมได้::l::Only for member type can create event";
$c[14][field]="fullgrant1";
$c[14][fieldtype]="foreign:-localdb-,member_type,type,descr,allowblank";
$c[14][descr]="  หรือ ::l:: or  ";

$c[15][text]="ประเภทสมาชิกที่สร้างกิจกรรมได้::l::Only for member type can create event";
$c[15][field]="fullgrant2";
$c[15][fieldtype]="foreign:-localdb-,member_type,type,descr,allowblank";
$c[15][descr]="  หรือ ::l:: or  ";

$c[16][text]="ประเภทสมาชิกที่สร้างกิจกรรมได้::l::Only for member type can create event";
$c[16][field]="fullgrant3";
$c[16][fieldtype]="foreign:-localdb-,member_type,type,descr,allowblank";
$c[16][descr]="  หรือ ::l:: or  ";

$c[17][text]="ประเภทสมาชิกที่สร้างกิจกรรมได้::l::Only for member type can create event";
$c[17][field]="fullgrant4";
$c[17][fieldtype]="foreign:-localdb-,member_type,type,descr,allowblank";
$c[17][descr]="  ";


//

$dsp[1][text]="ห้องที่ให้บริการ::l::Room name";
$dsp[1][field]="name";
$dsp[1][width]="25%";


$dsp[4][text]="แก้ไขห้องย่อย";
$dsp[4][align]="center";
$dsp[4][field]="iscurrent";
$dsp[4][width]="25%";
$dsp[4][filter]="linkout:./edit-roomsubinfo.php?syeaid=[value-code]";

$dsp[6][text]="วันที่เปิดทำการ";
$dsp[6][align]="center";
$dsp[6][field]="iscurrent";
$dsp[6][width]="25%";
$dsp[6][filter]="linkout:./edit-repeatinfo.php?syeaid=[value-code]";


$dsp[3][text]="แก้ไขช่วงเวลา";
$dsp[3][align]="center";
$dsp[3][field]="iscurrent";
$dsp[3][width]="25%";
$dsp[3][filter]="linkout:./edit-periodinfo.php?syeaid=[value-code]";


$dsp[5][text]="แสดงหน้าหลัก";
$dsp[5][field]="isshow";
$dsp[5][width]="8%";


fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c);

foot();
?>