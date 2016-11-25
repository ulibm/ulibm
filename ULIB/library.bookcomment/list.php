<?php 
;
        include ("../inc/config.inc.php");
head();
$_REQPERM="bookcomment-list";
mn_lib();

$localcatehead="yes";

pagesection(getlang("Bib ที่มีการคอมเมนท์::l::Commented Bib. "));
$tbname="webpage_bookcomment";



$dsp[6][text]="Comment/Report";
$dsp[6][field]="title";
$dsp[6][align]="center";
$dsp[6][filter]="module:local_score";
$dsp[6][width]="20%";

function local_score($wh) {
	$under=tmq("select * from webpage_bookcomment where allowed='no' and bibid='$wh[bibid]'");
	$s="";
	if (tmq_num_rows($under)!=0) {
		$s.="<B>".tmq_num_rows($under)."</B>/";
	}
	$all=tmq("select * from webpage_bookcomment where bibid='$wh[bibid]'");
	$del=tmq_num_rows(tmq("select id from webpage_bookcomment where bibid='$wh[bibid]' and reportdelete>0"));
	return "$s".tmq_num_rows($all)."/<B style='color:darkred'>$del</B>";
}

$dsp[2][text]="Bib";
$dsp[2][field]="bibid";
$dsp[2][width]="50%";
$dsp[2][filter]="module:localmdname";

function localmdname($wh) {
				 return "<A HREF='../dublin.php?ID=$wh[bibid]' target=_blank>".marc_gettitle($wh[bibid])."</A>";
}


$dsp[4][text]="รายละเอียด::l::Rated log";
$dsp[4][field]="title";
$dsp[4][align]="center";
$dsp[4][width]="10%";
$dsp[4][filter]="module:locallink";

function locallink($wh) {
				 return "<a href='../dublin.commentlog.php?ID=$wh[bibid]' target=_blank>".getlang("ดูรายละเอียด::l::Rated log")."</a> ";;
}

?><CENTER>

<A HREF="list.php?mode="><?php echo getlang("แสดงทั้งหมด::l::Show all")?></A> :: 
<A HREF="list.php?mode=no"><?php echo getlang("แสดงเฉพาะที่ยังไม่อนุญาต::l::Show unallowed")?></A>
</CENTER><?php 
if ($mode=="no") {
	$limit=" allowed='no' ";
} else {
	$limit=" 1 ";
}
fixform_tablelister($tbname," $limit ",$dsp,"no","no","no","mode=$mode",$c," cc desc ",$o,"*,count(id) as cc",""," group by bibid");

foot();

?>