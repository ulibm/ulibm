<?php 
;
        include ("../inc/config.inc.php");
head();
include("./_REQPERM.php");
mn_lib();

$tbname="searchcloud";


$c[2][text]="Name::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="Isshow::l::Isshow";
$c[3][field]="isshow";
$c[3][fieldtype]="list:yes,no";
$c[3][descr]="นำไปแสดงหรือไม่::l::Show this cloud?";
$c[3][defval]="yes";

$c[4][text]="Cloud::l::Cloud";
$c[4][field]="cloud";
$c[4][fieldtype]="longtext";
$c[4][descr]="คั่นแต่ละข้อความด้วยการขึ้นบรรทัดใหม่";
$c[4][defval]="";

$c[5][text]="ค้นหาใน::l::At index";
$c[5][field]="fid";
$c[5][fieldtype]="foreign:-localdb-,index_ctrl,code,name";
$c[5][descr]="";
$c[5][defval]="";

$c[6][text]="แสดงเป็นลำดับที่::l::Display Order";
$c[6][field]="ordr";
$c[6][fieldtype]="number";
$c[6][descr]="";
$c[6][defval]="";

$c[7][text]="แสดงกี่ข้อความ::l::Cloud to display";
$c[7][field]="dspnum";
$c[7][fieldtype]="number";
$c[7][descr]="";
$c[7][defval]="10";
//dsp


$dsp[2][text]="Name::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="30%";

$dsp[3][text]="นำไปแสดงหรือไม่::l::Show?";
$dsp[3][field]="isshow";
$dsp[3][filter]="switchsingle";
$dsp[3][width]="30%";

$dsp[4][text]="Cloud::l::Cloud";
$dsp[4][field]="cloud";
$dsp[4][width]="30%";


fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c);

html_dialog("","ระบบนี้ใช้ในการจัดการหน้าเว็บแบบ webpage (แบบเดิม) เท่านั้น::l::This setting use in [webpage] (version 5.x) only");

foot();

?>