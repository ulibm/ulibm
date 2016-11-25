<?php 
;
     include("../inc/config.inc.php"); 
	 head();
	 $_REQPERM="webpace-suggestbook";
	 mn_lib();
pagesection(getlang("เืลือกวัสดุเข้า Showcase::l::Add Bib. to showcase"));

?>
<TABLE class=table_border width=780 align=center>
<FORM METHOD=POST ACTION="h_showcase.selectmedia.php">
<TR>
	<TD class=table_head colspan=2><?php  echo getlang("กรุณากรอกข้อมูลของไอเทมวัสดุเพื่อสืบค้น::l::Please enter some information to search");?></TD></TR>
<TR>
<TR>
	<TD class=table_head><?php  echo getlang("ทะเบียน/บาร์โค้ดของไอเทม::l::Tabean/barcode");?></TD>
	<TD class=table_td><INPUT TYPE="text" NAME="mediabarcode" ID="mediabarcode" value="<?php  echo $mediabarcode?>"</TD>
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
	<INPUT TYPE="submit" value=" OK "> <A HREF="h_showcase.selectmedia.php"><?php echo getlang("แสดงทั้งหมด::l::Show all")?></A></TD>
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
	$s="";
	$s.="<TABLE width=100%>
	<TR>
		<TD class=table_head><nobr>".getlang("ชื่อเรื่อง::l::Title")."</nobr></TD>
		<TD class=table_head>".marc_gettitle($wh[mid])."</TD>
	</TR>
	<TR>
		<TD class=table_td colspan=2 align=right><b>Call Number</b>: ".marc_getcalln($wh[mid])." ::
		 <b><a href='../dublin.php?ID=$wh[mid]' target=_blank>".getlang("ดูรายละเอียด::l::View in detail")."</a> ::
		  <a href='h_showcase.php?addthis=$wh[mid]' style='color:darkred;'>".getlang("เลือกรายการนี้::l::Select this media")."</a></b></TD>
	</TR>
	";
	
	$s.="<TR>
		<TD colspan=2 align=right>";
		$md=tmq("select * from media_mid where pid='$wh[mid]' ");
		$s.="<TABLE width=70%>";
			$s.="<TR>
			<TD class=table_head width=200>Barcode</TD>
			<TD class=table_head>".getlang("ประเภทวัสดุ::l::Resource Type")."</TD>
			</TR>";
		while ($mdr=tmq_fetch_array($md)) {
			$s.="<TR>
			<TD class=table_td>$mdr[bcode] </TD>
			<TD class=table_td>".get_media_type($mdr[RESOURCE_TYPE])."</TD>
			</TR>";
		}
		$s.="</TABLE><BR>";
	$s.="</TD>
	</TR>
	</TABLE>";
	
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
//echo "[$limit]";
	
$o[addlink][] = "h_showcase.php::".getlang("กลับไป Showcase::l::Back to Showcase")."::_self";

fixform_tablelister($tbname," $limit ",$dsp,"no","no","no","mediabarcode=$mediabarcode&kw=$kw&kwtype=$kwtype&mediatype=$mediatype",$c,"",$o);
//*,REPLACE(bcode, ',', '') as bcode2 

foot();
?>