<?php  //พ
include("../inc/config.inc.php");
head();
$_REQPERM="midstatus";
$tmp=mn_lib();
pagesection($tmp);
$tbname="media_mid_status";


$c[2][text]="Code::l::Code";
$c[2][field]="code";
$c[2][fieldtype]="readonlytext";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="Name::l::Name";
$c[3][field]="name";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[5][text]="Color";
$c[5][field]="col";
$c[5][fieldtype]="color";
$c[5][descr]="";
$c[5][defval]="";

$c[4][text]="Can checkout?";
$c[4][field]="iscancheckout";
$c[4][fieldtype]="list:yes,no";
$c[4][descr]="";
$c[4][defval]="";

$c[6][text]="Hide from user?";
$c[6][field]="ishide";
$c[6][fieldtype]="list:yes,no";
$c[6][descr]="";
$c[6][defval]="";

$c[7][text]="Status to Display";
$c[7][field]="setstatusdsp";
$c[7][fieldtype]="text";
$c[7][descr]="";
$c[7][defval]="";


//dsp


$dsp[2][text]="Code::l::Code";
$dsp[2][field]="code";
$dsp[2][width]="30%";

$dsp[3][text]="Name::l::Name";
$dsp[3][field]="name";
$dsp[3][width]="30%";

$dsp[5][text]="Color";
$dsp[5][field]="col";
$dsp[5][filter]="color";
$dsp[5][width]="10%";

$chk=tmq("select * from $tbname where code='';");
if (tnr($chk)!=1) {
   tmq("delete from $tbname where code='';");
   tmq("insert into $tbname set code='' , name='ปกติ::Normal',iscancheckout='yes'");
}

fixform_tablelister($tbname," 1 ",$dsp,"no","yes","no","mi=$mi",$c);

foot();
?>