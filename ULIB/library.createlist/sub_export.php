<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="createlist";
mn_lib();

if ($createexport=="yes") {
	$s=tmq("select * from createlist_rule where pid='$main' order by ordr");
	$sq="";
	while ($r=tmq_fetch_array($s)) {
		//printr($r);
		//if ($r[]
		$sqldecis="";
		$r[val]=stripslashes($r[val]);
		$r[val]=stripslashes($r[val]);
		$r[val]=addslashes($r[val]);
		if ($r[decis]=="Exact match") {
			$sqldecis=" = \"$r[val]\" ";
		}
		if ($r[decis]=="Match (anywhere)") {
			$sqldecis=" like \"%$r[val]%\" ";
		}
		if ($r[decis]=="Begin with") {
			$sqldecis=" like \"$r[val]%\" ";
		}
		if ($r[decis]=="End with") {
			$sqldecis=" like \"%$r[val]\" ";
		}
		if ($r[decis]=="Like (match any case)") {
			$sqldecis=" like \"$r[val]\" ";
		}
		$sq.=" $r[bool] `$r[tagid]` $sqldecis  ";
	}

	$sqall="select ID from media where 1 $sq ";
	//itemrule
	$s=tmq("select * from createlist_itemrule where pid='$main' and idlist<>'' order by ordr ");
	if (tnr($s)>0) {
		while ($r=tfa($s)) {
		$sqall.=" $r[decis] (id in ($r[idlist]))";
		$sq.="  $r[decis] (id in ($r[idlist])) ";
		}
	}

	//echo "[$sqall]";// die;

	tmq("delete from createlist_result where pid='$main' ");
	$s=tmq($sqall);
	while ($r=tmq_fetch_array($s)) {
		tmq("insert into createlist_result set pid='$main', mid='$r[ID]' ");
	}
}

$tbname="createlist_result";

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
	<TD class=table_head><B><?php  echo getlang("ผลของการ Createlist:::l::Result list  for:");
	$s=tmq("select * from createlist_main where id='$main' ");
	$s=tmq_fetch_array($s);
	?></B> </td><td class=table_td><?php 
	echo $s[name];
	?></TD>
</TR>
<TR>
	<TD class=table_head><B><?php  echo getlang("จำนวนทรัพยากร:::l::Bib. count:");
	?></B> </td><td class=table_td><?php 
	$s=tmq("select * from createlist_result where pid='$main' ");
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
	tmq("update createlist_main set cache_dt='$now', cache_bib='$c_bib', cache_item='$c_item' where id='$main' ");
	?></TD>
</TR>
</TABLE><BR>
<CENTER>

<A HREF="export.php?exportmode=marc&main=<?php  echo $main?>" class=a_btn><?php  echo getlang("ส่งออกเป็น MARC::l::Export as MARC")?></A> :: 
<A HREF="export.php?exportmode=full&main=<?php  echo $main?>" class=a_btn><?php  echo getlang("HTML แบบเต็ม::l::Full html")?></A> :: 
<A HREF="export.php?exportmode=brieve&main=<?php  echo $main?>" class=a_btn><?php  echo getlang("HTML แบบย่อ::l::Brieve HTML")?></A> :: 
<A HREF="export.php?exportmode=shorted&main=<?php  echo $main?>" class=a_btn><?php  echo getlang("HTML สังเขป::l::very brieve HTML ")?></A> :: 
<A HREF="export.php?exportmode=csv&main=<?php  echo $main?>" class=a_btn><?php  echo getlang("CSV::l::CSV")?></A> :: 
<A HREF="export.php?exportmode=csvreadable&main=<?php  echo $main?>" class=a_btn><?php  echo getlang("CSV เฉพาะเนื้อหา::l::Readable CSV")?></A> :: 
<A HREF="export.php?exportmode=csv&main=<?php  echo $main?>&encodemode=th" class='a_btn smaller'><?php  echo getlang("CSV::l::CSV")?>-th</A> :: 
<A HREF="export.php?exportmode=csvreadable&main=<?php  echo $main?>&encodemode=th" class='a_btn smaller'><?php  echo getlang("CSV เฉพาะเนื้อหา::l::Readable CSV")?>-th</A><BR>
<?php  echo getlang("ส่งออก Item ::l::Export Item.");?> <a href="exportxls_i.php?main=<?php  echo $main?>" class=a_btn>CSV</a><br />

<BR><?php  echo getlang("คลิกขวา เลือก save link as::l::Right click choose 'save link as..'"); ?>
</CENTER>

<?php 

fixform_tablelister($tbname," pid='$main' ",$dsp,"no","no","no","main=$main",$c,"",$o);

if ($createexport=="yes") {
	echo "<BR>";
	html_dialog("ข้อมูลด้านเทคนิค","$sq");
}


foot();
?>