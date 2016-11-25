<?php 
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();

$tbname="room";

$s=tmq("select * from room_cate where code='$pid' ");
if (tnr($s)==0) {
   $s=tmq("select * from room_cate where code='default' ");
   $pid="default";
}
$s=tfa($s);
html_dialog("",getlang("กำลังจัดการ::l::Managing").": ".getlang($s[name]));
?><center><a href="index.php" class=a_btn><?php  echo getlang("กลับ::l::Back");?></a></center><?php 
$c[2][text]="Name::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="ซ่อน::l::Hide";
$c[3][field]="ishide";
$c[3][fieldtype]="list:no,yes";
$c[3][descr]="";
$c[3][defval]="no";

$c[4][text]="กลุ่ม::l::Group";
$c[4][field]="pid";
$c[4][fieldtype]="foreign:-localdb-,room_cate,code,name";
$c[4][descr]="";
$c[4][defval]=$pid;

//dsp


$dsp[2][text]="Name::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="70%";

$dsp[3][text]="ซ่อน::l::Hide";
$dsp[3][field]="ishide";
$dsp[3][filter]="switchsingle";
$dsp[3][width]="20%";

$o[undelete][field]="editable";
$o[undelete][value]="NO";

$limit=" pid='$pid' ";
if ($pid=="default") {
   $limit.=" or pid not in (select code from room_cate) ";
}
fixform_tablelister($tbname," $limit ",$dsp,"yes","yes","yes","mi=$mi&pid=$pid",$c,"",$o);

foot();
?>