<?php 
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
$tmp=mn_lib();
pagesection($tmp);

$tbname="oai_repocate";


$c[1][text]="ชื่อหมวดหมู่::l::Category name";
$c[1][field]="name";
$c[1][fieldtype]="text";
$c[1][descr]="";
$c[1][defval]="";

$c[3][text]="Code";
$c[3][field]="code";
$c[3][fieldtype]="text";
$c[3][descr]="*";
$c[3][defval]="";

//dsp


$dsp[2][text]="ชื่อหมวดหมู่::l::Category name";
$dsp[2][field]="name";
$dsp[2][filter]="module:localdsp";
$dsp[2][width]="50%";
function localdsp($w) {
	$s="";
	$s.="$w[name]<br>
	<font class=smaller>$w[code]</font>
	";

	return $s;
}
/*
$dsp[3][text]="URL";
$dsp[3][field]="url";
$dsp[3][width]="30%";*/

/*
$dsp[5][text]="เปิดใช้งาน::l::is active";
$dsp[5][field]="isactive";
$dsp[5][filter]="switchsingle";
$dsp[5][width]="10%";

$o[undelete][field]="type";
$o[undelete][value]="onlineregist";
$o[undeletearr][type]="temp";
//$o[unedit][field]="type";
//$o[unedit][value]="onlineregist";
*/
$o[addlink][] = "index.php::".getlang("กลับ::l::Back")."::";

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"",$o);

foot(); 
?>