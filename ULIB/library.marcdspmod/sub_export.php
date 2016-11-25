<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="marcdspmod";
mn_lib();

if ($createexport=="yes") {
	$sqall= marcdspmod_getsql($main);
	

	tmq("delete from marcdspmod_result where pid='$main' ");
	$s=tmq($sqall);
	while ($r=tmq_fetch_array($s)) {
		tmq("insert into marcdspmod_result set pid='$main', mid='$r[ID]' ");
	}
}

$tbname="marcdspmod_result";

$c[7][text]="เรียงลำดับกฏ::l::Rule order #";
$c[7][field]="ordr";
$c[7][fieldtype]="number";
$c[7][descr]="";
$c[7][defval]="";

//dsp

$dsp[3][text]="ทรัพยากร::l::Material";
$dsp[3][field]="mid";
$dsp[3][filter]="module:local_bibid";
$dsp[3][width]="80%";

function local_bibid($wh) {
	$s= "<B  class=smaller>".marc_gettitle($wh[mid])."</B>/ ".marc_getauth($wh[mid])." / ".marc_getcalln($wh[mid])."";
	$tmp= "<TABLE>
		<TR valign=top>
			<TD>" .
		res_cov_dsp($wh[mid])
		."</TD>
			<TD><A HREF='../dublin.php?ID=$wh[mid]' target=_blank class=smaller>$s</A> ";
		$tmp.= "</TD>
		</TR>
		</TABLE>";
	return $tmp;
}

$o[addlink][] = "index.php::".getlang("กลับ::l::Back");;
?>
<BR><TABLE width=500 align=center class=table_border>
<TR>
	<TD class=table_head><B><?php  echo getlang("ผลของการ marcdspmod:::l::Result list  for:");
	$s=tmq("select * from marcdspmod_main where id='$main' ");
	$s=tmq_fetch_array($s);
	?></B> </td><td class=table_td><?php 
	echo $s[name];
	?></TD>
</TR>
<TR>
	<TD class=table_head><B><?php  echo getlang("จำนวนทรัพยากร:::l::Bib. count:");
	?></B> </td><td class=table_td><?php 
	$s=tmq("select * from marcdspmod_result where pid='$main' ");
	$c_bib=tmq_num_rows($s);
	echo number_format($c_bib);
	?></TD>
</TR>
<TR>
	<TD class=table_head><B><?php  echo getlang("จำนวน Items:::l::Bib. count:");
	?></B> </td><td class=table_td><?php 
	$scount=0;
	while ($sr=tmq_fetch_array($s)) {
		$sri=tmq("select * from media_mid where pid='$sr[mid]' ");
		$scount=$scount+tmq_num_rows($sri);
	}
	$c_item=$scount;
	echo number_format($scount);
	$now=time();
	tmq("update marcdspmod_main set cache_dt='$now', cache_bib='$c_bib', cache_item='$c_item' where id='$main' ");
	?></TD>
</TR>
</TABLE><BR>


<?php 

fixform_tablelister($tbname," pid='$main' ",$dsp,"no","no","no","main=$main",$c,"",$o);

if ($createexport=="yes") {
	echo "<BR>";
	html_dialog("ข้อมูลด้านเทคนิค","$sqall");
}


foot();
?>