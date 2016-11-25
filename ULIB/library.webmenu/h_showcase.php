<?php 
;
     include("../inc/config.inc.php"); 
	 head();
	 $_REQPERM="webpace-suggestbook";
if (!library_gotpermission($_REQPERM)) {
	die();
}
	if ($deletereviewid!="") {
		tmq("delete from webpage_showcase where mid='$deletereviewid' ");
		if ($backtome=="indexbib") {
			redir("$dcrURL/dublin.php?ID=$deletereviewid");
			die;
		}
	}
	 mn_lib();


	 if ($addthis!="") {
	 		tmq("update media set webpageshowcase='yes' where ID='$addthis' ");
			$c=tmq("select * from index_db where mid='$addthis' ");
			if (tmq_num_rows($c)==0) {
				 index_reindex($addthis);
			} else {
				 tmq("update index_db set webpageshowcase='yes' where mid='$addthis' ");
			}
	 }
	 if ($removethis!="") {
	 	 tmq("update media set webpageshowcase='' where ID='$removethis' ");
	 	 tmq("update index_db set webpageshowcase='' where mid='$removethis' ");
	 }
	 pagesection(getlang("วัสดุที่เลือกแสดงใน Showcase แล้ว::l::Media already on Showcase"));

?>
<TABLE class=table_border width=780 align=center>
<FORM METHOD=POST ACTION="h_showcase.php">
<TR>
	<TD class=table_head colspan=2><?php  echo getlang("กรุณากรอกข้อมูลของไอเทมวัสดุเพื่อสืบค้น::l::Please enter some information to search");?></TD></TR>
<TR>
<TR>
	<TD class=table_head><?php  echo getlang("ทะเบียน/บาร์โค้ดของไอเทม::l::Tabean/barcode");?></TD>
	<TD class=table_td><INPUT TYPE="text" NAME="mediabarcode" ID="mediabarcode" value="<?php  echo $mediabarcode?>"></TD>
</TR>
<TR>
	<TD class=table_head><?php  echo getlang("Keyword");?> </TD>
	<TD class=table_td><INPUT TYPE="text" NAME="kw" ID="kw" value="<?php  echo $kw?>"> <?php  echo getlang("Field");?> 
	<?php 
	frm_genlist("kwtype","select * from index_ctrl order by name","fid","name","-localdb-","no",$kwtype);
	?></TD>
</TR>
<TR>
	<TD class=table_head><?php  echo getlang("ประเภทสื่อ::l::Media Type");?></TD>
	<TD class=table_td> <?php 
	frm_genlist("mediatype","select * from media_type order by name","code","name","-localdb-","yes",$mediatype);
	?></TD>
</TR>
<TR>
	<TD class=table_td colspan=2 align=center>
	<INPUT TYPE="submit" value=" OK ">
	 <A HREF="h_showcase.php"><?php echo getlang("แสดงทั้งหมด::l::Show all")?></A>
	 </TD>
</TR>
</FORM><SCRIPT LANGUAGE="JavaScript">
<!--
	getobj('mediabarcode').select();
//-->
</SCRIPT>
</TABLE>
<?php 
 //dsp


$dsp[1][text]="วัสดุ::l::Material Info";
$dsp[1][field]="mid";
$dsp[1][filter]="module:localmedia";
$dsp[1][width]="80%";


function localmedia($wh) {

 global $dcrURL;	
 
 $s="";
	$s.="<TABLE width=100%>
	<TR>
		<TD class=table_head width=200><nobr>".getlang("ชื่อเรื่อง::l::Title")."</nobr></TD>
		<TD class=table_head2 style='text-align:left'><B>".marc_gettitle($wh[mid])."</B></TD>
	</TR>
	<TR>
		<TD class=table_head><nobr>Call Number</nobr></TD>
		<TD class=table_td>".marc_getcalln($wh[mid]);
		$s.="</TD>
	</TR>
		<TR>
		<TD class=table_head><nobr>Contents</nobr></TD>
		<TD class=table_td>";
		$chr=tmq("select * from webpage_showcase where mid='$wh[mid]' ");
		if (tmq_num_rows($chr)!=0) {
			$s.=" <IMG SRC='../neoimg/reviewicon.png' WIDTH='20' HEIGHT='20' BORDER='0' align=absmiddle><FONT COLOR='#000066'> ".getlang("มี review แล้ว!::l::Got review!")."</FONT><BR>";
		}
		$s.="
		 <b> <a href='h_showcase.review.php?ID=$wh[mid]' > <IMG SRC='../neoimg/edit16.png' WIDTH='16' HEIGHT='16' BORDER='0' align=absmiddle> ".getlang("เขียน/แก้ review::l::Write/edit review")."</a></b>
		 : <b> <a href='h_showcase.php?removethis=$wh[mid]'> <IMG SRC='../neoimg/Delete.gif' WIDTH='16' HEIGHT='16' BORDER='0' align=absmiddle> ".getlang("ลบออกจาก Showcase::l::Remove from Showcase")."</a></b>
		 : <b> <a href='$dcrURL/dublin.php?ID=$wh[mid]' target=_blank> <IMG SRC='../neoimg/newwin.gif' WIDTH='16' HEIGHT='16' BORDER='0' align=absmiddle> ".getlang("ดู::l::View")."</a></b>
		 
		  </TD></TR></TABLE>	";

	
	return $s;
}

$tbname="index_db";

$limit=" 1 ";
if ($kw!="" && $kwtype!="") {
	$limit.=" and $kwtype like '%$kw%' ";
}
if ($mediatype!="") {
	$limit.=" and mdtype  like '%,$mediatype,%' ";
}
if ($mediabarcode!="") {
	$limit.=" and bcode  like '%,$mediabarcode,%' ";
}
	$limit.=" and webpageshowcase  = 'yes' ";
//echo "[$limit]";


$o[addlink][] = "h_showcase.selectmedia.php?FTCODE=$FTCODE::".getlang("เลือกวัสดุอื่นเข้า Showcase::l::Add other Bib. to showcase")."::_self";

fixform_tablelister($tbname," $limit ",$dsp,"no","no","no","mediabarcode=$mediabarcode&kw=$kw&kwtype=$kwtype&mediatype=$mediatype",$c,"",$o,"","");

	 
	 foot();
?>