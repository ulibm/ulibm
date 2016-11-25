<?php 
include("../inc/config.inc.php");
head();
include("./_REQPERM.php");
mn_lib();

$tbname="webboard_boardcate";


$c[2][text]="Name::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="ข้อความเพิ่มเติม::l::Description";
$c[3][field]="descr";
$c[3][fieldtype]="longtext";
$c[3][descr]="";
$c[3][defval]="";

$c[9][text]="แสดงให้ผู้ใช้เห็นหรือไม่::l::Show to user";
$c[9][field]="isshowtouser";
$c[9][fieldtype]="list:yes,no";
$c[9][descr]="";
$c[9][defval]="yes";

//dsp


$dsp[2][text]="Name::l::Name";
$dsp[2][field]="name";
$dsp[2][width]="30%";

$dsp[3][text]="ข้อความเพิ่มเติม::l::Description";
$dsp[3][field]="descr";
$dsp[3][width]="30%";

$dsp[9][text]="แสดงให้ผู้ใช้เห็นหรือไม่::l::Show to user";
$dsp[9][field]="isshowtouser";
$dsp[9][filter]="switchsingle";
$dsp[9][descr]="";

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c);
$tmpurl=$dcrURL."webboard/";
html_dialog("","URL = <a target=_blank href='$tmpurl'>$tmpurl</a>");

foot();
?>