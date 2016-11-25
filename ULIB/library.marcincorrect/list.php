<?php 
;
        include ("../inc/config.inc.php");
head();
$_REQPERM="marcincorrect-list";
mn_lib();

$localcatehead="yes";

pagesection("ดูข้อมูล รายการบรรณานุกรมที่มีผู้แจ้งว่าผิดพลาด");
$tbname="webpage_incorrectbib";



$c=Array();

$dsp[2][text]="Bib";
$dsp[2][field]="title";
$dsp[2][width]="30%";
$dsp[2][filter]="module:localmdname";

function localmdname($wh) {
				 return marc_gettitle($wh[bibid]);
}
$dsp[3][text]="ผู้รายงาน::l::Submiter";
$dsp[3][field]="title";
$dsp[3][width]="30%";
$dsp[3][filter]="module:localmemname";
function localmemname($wh) {
				 return "<table cellpadding=3 cellspacing=1 bgcolor=66666><tr><td bgcolor=f2f2f2>$wh[text]</td></tr></table>
				 ".get_member_name($wh[memid]);
}

$dsp[4][text]="ดูรายการ::l::View Bib";
$dsp[4][field]="title";
$dsp[4][align]="center";
$dsp[4][width]="10%";
$dsp[4][filter]="module:locallink";

function locallink($wh) {
				 return "<a href='../dublin.php?ID=$wh[bibid]' target=_blank>".getlang("ดูรายการ::l::View Bib")."</a> ";;
}

$dsp[5][text]="แก้ไข::l::Edit Bib";
$dsp[5][field]="title";
$dsp[5][align]="center";
$dsp[5][width]="10%";
$dsp[5][filter]="module:locallinke";

 $iscanedit=library_gotpermission("DBbook");
function locallinke($wh) {
				 global $iscanedit;
				 if ($iscanedit=="yes") {
				 return "<a href='../library.book/addDBbook.php?IDEDIT=$wh[bibid]' target=_blank>".getlang("แก้ไข::l::Edit")."</a> ";;
				 }else {
				 return "-";
				 }
}


fixform_tablelister($tbname," 1 ",$dsp,"no","no","yes","mi=$mi",$c," dt ");

foot();

?>