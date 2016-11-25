<?php 
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
$tmp=mn_lib();
pagesection("จัดการตัวเลือกการนำเข้าข้อมูลที่ไม่มีรูปแบบ::l::No format Setting");

$tbname="marc_noformat";


$c[1][text]="หมายเลขแท็ก::l::Tag Number";
$c[1][field]="desttag";
$c[1][fieldtype]="text";
$c[1][descr]="XXX";
$c[1][defval]="";

$c[2][text]="รูปแบบ::l::Template";
$c[2][field]="tp";
$c[2][fieldtype]="longtext";
$c[2][descr]="[data] for data";
$c[2][defval]="";

$c[3][text]="คำที่ค้นหา::l::Scan for keyword";
$c[3][field]="kw";
$c[3][fieldtype]="longtext";
$c[3][descr]="[tab] for tab, ending with | for (seperator)";
$c[3][defval]="";


//dsp


$dsp[1][text]="หมายเลขแท็ก::l::Tag Number";
$dsp[1][field]="desttag";
$dsp[1][width]="20%";

$dsp[2][text]="คำที่ค้นหา::l::Scan for keyword";
$dsp[2][field]="kw";
$dsp[2][width]="60%";


fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c," desttag ",$o);
?><center><a href="parsemarc.php" ><?php  echo getlang("กลับ::l::Back");?></a></center><?php 
foot(); 
?>