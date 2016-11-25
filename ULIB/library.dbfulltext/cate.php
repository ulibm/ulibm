<?php  //พ
;
     include("../inc/config.inc.php"); 
	 head();
	 include("_REQPERM.php");
	 mn_lib();
$tbname="media_fttype";


$c[2][text]="Code::l::Code";
$c[2][field]="code";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="Name::l::Name";
$c[3][field]="name";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="Note::l::Note";
$c[4][field]="note";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="";

//dsp



$dsp[3][text]="Name::l::Name";
$dsp[3][field]="name";
$dsp[3][width]="40%";

$dsp[4][text]="Note::l::Note";
$dsp[4][field]="note";
$dsp[4][width]="40%";


$o[undelete][field]="iscandel";
$o[undelete][value]="no";
$o[unedit][field]="iscandel";
$o[unedit][value]="no";

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"",$o);

foot();

?>