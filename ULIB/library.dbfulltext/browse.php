<?php 
;
     include("../inc/config.inc.php"); 
	 head();
	 include("_REQPERM.php");
	 mn_lib();

	 if ($FTCODE=="") {
	 		die("no FTCODE");
	 }
	 
	 pagesection(getlang("วัสดุที่มี Content แล้ว::l::Media with contents"));

?>
<TABLE class=table_border width=780 align=center>
<FORM METHOD=POST ACTION="browse.php">
	<INPUT TYPE="hidden" NAME="FTCODE" ID="FTCODE" value="<?php  echo $FTCODE?>">
<TR>
	<TD class=table_head colspan=2><?php  echo getlang("กรุณากรอกข้อมูลของไอเทมวัสดุเพื่อสืบค้น::l::Please enter some information to search");?></TD></TR>
<TR>
<TR>
	<TD class=table_head><?php  echo getlang("กำลังดูเฉพาะ Bib. ที่มี Content ประเภท::l::Displaying Bib. with content type");?></TD>
	<TD class=table_td><SELECT NAME="jumpftcate"  style="font-size: 24" onchange="self.location='browse.php?FTCODE='+this.value">
	<?php 
	$s=tmq("select * from media_fttype where code='$FTCODE' ");
	$s=tmq_fetch_array($s);
	echo "<OPTION VALUE='$s[code]' SELECTED>".getlang($s[name])."</OPTION>";
		$sall1=tmq("select * from media_fttype where code<>'$FTCODE' order by name ");
	while ($sall1r=tmq_fetch_array($sall1)) {
		echo "<OPTION VALUE='$sall1r[code]' >".getlang($sall1r[name]);
	}

	?>
		
		
	</SELECT>
	</TD>
</TR>
<TR>
	<TD class=table_head><?php  echo getlang("ทะเบียน/บาร์โค้ดของไอเทม::l::Tabean/barcode");?></TD>
	<TD class=table_td><INPUT TYPE="text" NAME="mediabarcode" ID="mediabarcode" value="<?php  echo $mediabarcode?>"></TD>
</TR>
<TR>
	<TD class=table_head><?php  echo getlang("Keyword");?> </TD>
	<TD class=table_td><INPUT TYPE="text" NAME="kw" ID="kw" value="<?php  echo $kw?>"> <?php  echo getlang("Field");?> 
	<?php 
	frm_genlist("kwtype","select * from index_ctrl order by ordr","fid","name","-localdb-","no",$kwtype);
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
	 <A class=a_btn HREF="browse.php?FTCODE=<?php  echo $FTCODE;?>"><?php echo getlang("แสดงทั้งหมด::l::Show all")?></A>

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
 global $FTCODE;
 global $dcrURL;	
 
 $s="";
	$s.="<TABLE width=100%>
	<TR>
		<TD class=table_head width=200><nobr>".getlang("ชื่อเรื่อง::l::Title")."</nobr></TD>
		<TD class=table_head>".marc_gettitle($wh[mid])."</TD>
	</TR>
	<TR>
		<TD class=table_head><nobr>Call Number</nobr></TD>
		<TD class=table_td>".marc_getcalln($wh[mid])."</TD>
	</TR>
		<TR>
		<TD class=table_head><nobr>Contents</nobr></TD>
		<TD class=table_td><b>";		
		$md=tmq("select id from media_ftitems where mid='$wh[mid]' ");
		$s.=tmq_num_rows($md);
		$s.="</b>  <b> <a class=a_btn href='mediacontent.php?FTCODE=$FTCODE&mid=$wh[mid]'>".getlang("จัดการเนื้อหา::l::Manage Contents")."</a></b>
		<b> <a class=a_btn href='$dcrURL/dublin.php?ID=$wh[mid]' target=_blank>".getlang("ดู::l::View")."</a></b>
		 
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


$limit.=" and ulibnote  like '%,$FTCODE,%' ";
//echo "[$limit]";

	$s=tmq("select * from media_fttype where code='$FTCODE' ");
	$s=tmq_fetch_array($s);
	$s= getlang($s[name]);

$o[addlink][] = "selectmedia.php?FTCODE=$FTCODE::".getlang("เพิ่ม Content ให้วัสดุอื่น::l::Add content to other Bib.")."::_self";
$o[addlink][] = "index.php::".getlang("กลับรายการประเภท Content::l::Select Content type")."::_self";


fixform_tablelister($tbname," $limit ",$dsp,"no","no","no","webpageshowcase=$webpageshowcase&FTCODE=$FTCODE&mediabarcode=$mediabarcode&kw=$kw&kwtype=$kwtype&mediatype=$mediatype",$c,"",$o,"","");

	 
	 foot();
?>