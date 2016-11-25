<?php 
;
        include ("../inc/config.inc.php");
head();
$_REQPERM="webmenu_memfavbook-list";
mn_lib();

$localcatehead="yes";

pagesection("ดูข้อมูล Bib. ที่มีผู้เพิ่มไว้ในรายการโปรด");
$tbname="webpage_memfavbook";





$dsp[2][text]="Bib";
$dsp[2][field]="title";
$dsp[2][width]="60%";
$dsp[2][filter]="module:localmdname";

function localmdname($wh) {
				 return "<A HREF='../dublin.php?ID=$wh[bibid]' target=_blank>".marc_gettitle($wh[bibid])."</A>";
}
$dsp[3][text]="สมาชิก::l::Member";
$dsp[3][field]="title";
$dsp[3][align]="center";
$dsp[3][width]="30%";
$dsp[3][filter]="module:localmemname";
function localmemname($wh) {
	 return get_member_name($wh[memid]);
}
include("inc.localmenu.php");

fixform_tablelister($tbname," 1 ",$dsp,"no","no","yes","mi=$mi",$c," dt desc ");

foot();

?>