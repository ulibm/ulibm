<?php 
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();

$tbname="acq_setbudget";


$c[2][text]="งบประมาณ::l::Budget";
$c[2][field]="budget";
$c[2][fieldtype]="foreign:-localdb-,acq_budgettype,code,name";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="Major::l::Major";
$c[3][field]="major";
$c[3][fieldtype]="foreign:-localdb-,major,name,name,allowblank";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="Yea::l::Yea";
$c[4][field]="yea";
$c[4][fieldtype]="year";
$c[4][descr]="";
$c[4][defval]="0";

$c[5][text]="Val::l::Val";
$c[5][field]="val";
$c[5][fieldtype]="text";
$c[5][descr]="";
$c[5][defval]="0";

//dsp


$dsp[2][text]="งบประมาณ::l::Budget";
$dsp[2][field]="budget";
$dsp[2][filter]="foreign:-localdb-,acq_budgettype,code,name";
$dsp[2][width]="30%";

$dsp[3][text]="Major::l::Major";
$dsp[3][field]="major";
$dsp[3][width]="30%";

$dsp[4][text]="Yea::l::Yea";
$dsp[4][field]="yea";
$dsp[4][width]="30%";

$dsp[5][text]="Val::l::Val";
$dsp[5][field]="val";
$dsp[5][width]="30%";


fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c);

foot();
?>