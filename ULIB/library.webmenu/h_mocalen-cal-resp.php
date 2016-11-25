<?php 
;
        include ("../inc/config.inc.php");
head();
$_REQPERM="mocal-cal";
mn_lib();

$localcatehead="yes";

pagesection("ข้อมูลการคอมเมนท์ ปฏิทินกิจกรรม");
$tbname="webpage_mocalen_resp";



$dsp[2][text]="เนื้อหา::l::Text";
$dsp[2][field]="text";
$dsp[2][width]="30%";

$dsp[4][text]="วันที่::l::Date";
$dsp[4][field]="dt";
$dsp[4][align]="center";
$dsp[4][filter]="date";
$dsp[4][width]="20%";

$o[addlink][] = "h_mocalen-cal.php::Back";
fixform_tablelister($tbname," pid='$valid' ",$dsp,"no","no","yes","valid=$valid",$c," dt ",$o);

foot();

?>