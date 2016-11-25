<?php 
;
        include ("../inc/config.inc.php");
head();
$_REQPERM="webmenu_bibtag-taglist";
mn_lib();

$localcatehead="yes";

pagesection(getlang("แท็กทั้งหมด::l::All tags "));
$tbname="webpage_bibtag";



$dsp[6][text]="Tag";
$dsp[6][field]="title";
$dsp[6][align]="center";
$dsp[6][filter]="module:local_score";
$dsp[6][width]="20%";

$dsp[15][text]="อนุญาต::l::Granted";
$dsp[15][field]="title";
$dsp[15][align]="center";
$dsp[15][width]="10%";
$dsp[15][filter]="module:localisgrant";
function local_score($wh) {

	return $wh[word1];
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


function localisgrant($wh) {
	if ($wh[granted]=="yes") {
		 return "<img src='../neoimg/Green.gif'> ";;
	} else {
		 return "<img src='../neoimg/Seal.gif'> ";;
	}
}

?><CENTER>

<A HREF="taglist.php?mode=" class=a_btn><?php echo getlang("แสดงทั้งหมด::l::Show all")?> (<?php 
	echo tmq_num_rows(tmq("select id from $tbname "));
?>)</A> :: 
<A HREF="taglist.php?mode=no" class=a_btn><?php echo getlang("แสดงเฉพาะที่ยังไม่อนุญาต::l::Show unallowed")?> (<?php 
	echo tmq_num_rows(tmq("select id from $tbname where granted='no'  "));
?>)</A>
</CENTER><?php 
if ($mode=="no") {
	$limit=" granted='no' ";
} else {
	$limit=" 1 ";
}
fixform_tablelister($tbname," $limit ",$dsp,"no","no","no","mode=$mode",$c,"",$o);

foot();

?>