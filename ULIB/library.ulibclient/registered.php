<?php 
include("../inc/config.inc.php");
head();
include("./_REQPERM.php");
mn_lib();

$tbname="ulibclient";

$c[2][text]="IP Address";
$c[2][field]="ip";
$c[2][fieldtype]="text";
$c[2][descr]=getlang(" IP ของเครื่องปัจจุบันคือ $IPADDR ::l:: Current IP is $IPADDR ");
$c[2][defval]=$IPADDR;

$c[3][text]="ผู้ลงทะเบียน::l::Register";
$c[3][field]="register";
$c[3][fieldtype]="autoofficer";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="วันที่ลงทะเบียน::l::Regist Date";
$c[4][field]="registdt";
$c[4][fieldtype]="autotime";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="Module::l::Module";
$c[5][field]="module";
$c[5][fieldtype]="foreign:-localdb-,ulibclient_module,code,name";
$c[5][descr]="";
$c[5][defval]="";

$c[6][text]="โน๊ตย่อ::l::Note";
$c[6][field]="descr";
$c[6][fieldtype]="text";
$c[6][descr]="";
$c[6][defval]="";

//dsp


$dsp[3][text]="IP Address";
$dsp[3][field]="ip";
$dsp[3][width]="15%";

$dsp[2][text]="Note";
$dsp[2][field]="descr";
$dsp[2][width]="25%";

$dsp[5][text]="Module::l::Module";
$dsp[5][field]="module";
$dsp[5][filter]="foreign:-localdb-,ulibclient_module,code,name";
$dsp[5][width]="30%";

$dsp[6][text]="เชื่อมต่อครั้งล่าสุด::l::Last access";
$dsp[6][field]="lastaccess";
$dsp[6][filter]="date";
$dsp[6][width]="15%";


fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c);



foot();
?>