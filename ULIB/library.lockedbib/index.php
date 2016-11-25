<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="lockedbib";
$tmp=mn_lib();
pagesection($tmp);

$tbname="lock_bib";


$c=Array();

//dsp


$dsp[1][text]="Bib";
$dsp[1][field]="id";
$dsp[1][filter]="module:localbib";
$dsp[1][width]="20%";
function localbib($w) {
   $s="";
   $s=res_brief_dsp($w[bibid],true,true,false);
   return "$s";
}

$dsp[2][text]="Librarian";
$dsp[2][field]="id";
$dsp[2][filter]="module:locallib";
$dsp[2][width]="30%";
function locallib($w) {
   $s=get_library_name($w[loginid]);
   return "$s";
}

$dsp[3][text]="Date";
$dsp[3][field]="dt";
$dsp[3][filter]="datetime";
$dsp[3][width]="30%";


fixform_tablelister($tbname," 1 ",$dsp,"no","no","yes","mi=$mi",$c,"",$o);

foot(); 
?>