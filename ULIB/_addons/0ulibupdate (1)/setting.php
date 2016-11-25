<?php 
include("../../inc/config.inc.php");
include("info.php");
head();
include("../chkpermission.php");
include("../menu.php");
include("func.php");

pagesection("Updatable list");

$tbname="addonsdb_0ulibupdate";


$c[1][text]="รหัส::l::Code";
$c[1][field]="code";
$c[1][fieldtype]="text";
$c[1][descr]="relative path";
$c[1][defval]="";

$c[2][text]="Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="Descr";
$c[3][field]="descr";
$c[3][fieldtype]="longtext";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="Isshow";
$c[4][field]="isshow";
$c[4][fieldtype]="list:yes,no";
$c[4][descr]="";
$c[4][defval]="yes";

//dsp


$dsp[1][text]="รหัส::l::Code";
$dsp[1][field]="code";
$dsp[1][width]="20%";

$dsp[2][text]="Name";
$dsp[2][field]="name";
$dsp[2][width]="20%";

$dsp[3][text]="Descr";
$dsp[3][field]="descr";
$dsp[3][width]="30%";


$dsp[4][text]="Isshow";
$dsp[4][field]="isshow";
$dsp[4][filter]="switchsingle";
$dsp[4][width]="10%";


fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c," code asc ",$o);

foot(); 
?>