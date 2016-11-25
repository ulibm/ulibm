<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="noitemstrbymarctype";
$tmp=mn_lib();

$tbname="noitemstrbymarctype";

pagesection($tmp);

$c[1][text]="รหัส::l::Code";
$c[1][field]="code";
$c[1][fieldtype]="text";
$c[1][descr]="Leader/07";
$c[1][defval]="";
//$c[1][unediton]="delable,NO";

$c[2][text]="ข้อความ::l::Text";
$c[2][field]="str";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="ข้อความในหน้าแสดงบรรณานุกรม::l::String at Bib. page";
$c[3][field]="strforlist";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

//dsp


$dsp[1][text]="รหัส::l::Code";
$dsp[1][field]="code";
$dsp[1][width]="10%";

$dsp[2][text]="ข้อความ::l::String";
$dsp[2][field]="str";
$dsp[2][width]="30%";

$dsp[3][text]="ข้อความในหน้าแสดงบรรณานุกรม::l::String at Bib. page";
$dsp[3][field]="strforlist";
$dsp[3][width]="30%";


fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"",$o);
foot();
?>