<?php 
    ;
	include ("../inc/config.inc.php");
	head();// พ
	$_REQPERM="ignoreword";
	$tmp=mn_lib();
	pagesection($tmp);
$tbname="ignoreword";


$c[2][text]="Word";
$c[2][field]="word";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[6][text]="Word";
$c[6][field]="importdt";
$c[6][fieldtype]="addcontrol";
$c[6][descr]="";
$c[6][defval]="";



//dsp


$dsp[2][text]="Words:";
$dsp[2][field]="word";
$dsp[2][width]="70%";



fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c);

		foot();   
	   ?>