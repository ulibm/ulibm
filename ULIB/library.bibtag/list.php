<?php 
;
        include ("../inc/config.inc.php");
head();
$_REQPERM="webmenu_bibtag-list";
mn_lib();

$localcatehead="yes";

pagesection(getlang("Bib ที่มีการแท็ก::l::Tagged Bib. "));
$tbname="webpage_bibtag";



$dsp[6][text]="Tag";
$dsp[6][field]="title";
$dsp[6][align]="center";
$dsp[6][filter]="module:local_score";
$dsp[6][width]="10%";

function local_score($wh) {
	$under=tmq("select * from webpage_bibtag where granted='no' and bibid='$wh[bibid]'");
	$s="";
	if (tmq_num_rows($under)!=0) {
		$s.="<B>".tmq_num_rows($under)."</B>/";
	}
	$all=tmq("select * from webpage_bibtag where bibid='$wh[bibid]'");
	return "$s".tmq_num_rows($all);
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
				 return "<a href='../dublin.bibtag.hist.php?ID=$wh[bibid]' target=_blank>".getlang("ดูรายละเอียด::l::Rated log")."</a> ";;
}

?><CENTER>

<A HREF="list.php?mode="><?php echo getlang("แสดงทั้งหมด::l::Show all")?></A> :: 
<A HREF="list.php?mode=no"><?php echo getlang("แสดงเฉพาะที่ยังไม่อนุญาต::l::Show unallowed")?></A>
</CENTER><?php 
if ($mode=="no") {
	$limit=" granted='no' ";
} else {
	$limit=" 1 ";
}
fixform_tablelister($tbname," $limit ",$dsp,"no","no","no","mode=$mode",$c," cc desc ",$o,"*,count(id) as cc",""," group by bibid");

foot();

?>