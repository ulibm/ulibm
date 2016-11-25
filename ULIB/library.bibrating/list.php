<?php 
;
        include ("../inc/config.inc.php");
head();
$_REQPERM="webmenu_bibrating-list";
mn_lib();

$localcatehead="yes";

pagesection(getlang("Bib ที่มีผู้ให้คะแนน::l::Ratied Bib. "));
$tbname="webpage_bibrating_sum";



$dsp[6][text]="คะแนน::l::Score";
$dsp[6][field]="title";
$dsp[6][align]="center";
$dsp[6][filter]="module:local_score";
$dsp[6][width]="10%";

function local_score($wh) {
	return number_format($wh[votescore],2)."/$wh[votecount]";
}

$dsp[2][text]="Bib";
$dsp[2][field]="bibid";
$dsp[2][width]="50%";
$dsp[2][filter]="module:localmdname";

function localmdname($wh) {
				 return marc_gettitle($wh[bibid]);
}


$dsp[4][text]="รายละเอียด::l::Rated log";
$dsp[4][field]="title";
$dsp[4][align]="center";
$dsp[4][width]="10%";
$dsp[4][filter]="module:locallink";

function locallink($wh) {
				 return "<a href='../dublin.bibrating.hist.php?ID=$wh[bibid]' target=_blank>".getlang("ดูรายละเอียด::l::Rated log")."</a> ";;
}


fixform_tablelister($tbname," 1 ",$dsp,"no","no","no","mi=$mi",$c," votescore desc ");

foot();

?>