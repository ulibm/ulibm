<?php 
;
        include ("../inc/config.inc.php");
head();
$_REQPERM="webmenu_memfavbook-list";
mn_lib();

$localcatehead="yes";

pagesection("Bib. ในรายการโปรด (เรียงตามจำนวนสมาชิกที่เพิ่ม)");
$tbname="webpage_memfavbook";





$dsp[2][text]="Bib";
$dsp[2][field]="title";
$dsp[2][width]="60%";
$dsp[2][filter]="module:localmdname";

function localmdname($wh) {
				 return "<A HREF='../dublin.php?ID=$wh[bibid]' target=_blank>".marc_gettitle($wh[bibid])."</A>";
}
$dsp[3][text]="สมาชิกที่เพิ่ม::l::Member Added";
$dsp[3][field]="title";
$dsp[3][align]="center";
$dsp[3][width]="30%";
$dsp[3][filter]="module:localmemname";
function localmemname($wh) {
	$res="";
	$s=tmq("select * from webpage_memfavbook where bibid='$wh[bibid]' order by dt desc ");
	while ($r=tmq_fetch_array($s)) {
		$res.="".get_member_name($r[memid])."<BR>";
	}
	 return $res;
}
include("inc.localmenu.php");
fixform_tablelister($tbname," 1 ",$dsp,"no","no","no","mi=$mi",$c," cc desc ",$o,"*,count(id) as cc",""," group by bibid");

foot();

?>