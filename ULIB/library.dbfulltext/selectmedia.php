<?php 
;
     include("../inc/config.inc.php"); 
	 head();
	 include("_REQPERM.php");
	 mn_lib();
pagesection(getlang("เลือกวัสดุ เพื่อเพิ่ม Content::l::Choose Bib. to add contents"));

?>
<TABLE class=table_border width=780 align=center>
<FORM METHOD=POST ACTION="selectmedia.php">
	<INPUT TYPE="hidden" NAME="FTCODE" ID="FTCODE" value="<?php  echo $FTCODE?>">
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
	<INPUT TYPE="submit" value=" OK "> <A class=a_btn HREF="selectmedia.php?FTCODE=<?php  echo $FTCODE;?>"><?php echo getlang("แสดงทั้งหมด::l::Show all")?></A>
		 <?php 
	 if (getval("_SETTING","form_at_hp")=="webpage") {
	 		?>	<br />
<A class=a_btn HREF="selectmedia.php?FTCODE=<?php  echo $FTCODE;?>&webpageshowcase=yes"><?php echo getlang("รายการที่อยู่ใน Showcase (หน้าเว็บ)::l::in Showcase (homepage)")?></A><?php 
	 }
	 
	 ?>
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
	$pos = strpos($wh[ulibnote], "$FTCODE");
	$bgcolor="";
	$addstr="";
	if ($pos === false) {
	} else {
		$bgcolor=" style='background-color:#FDEDDF; '";
		$addstr="<FONT style='font-weight: normal; '>(".getlang("มีแล้ว::l::Already got").")</FONT>";
	}
	$s="";
	$s.="<TABLE width=100%>
	<TR>
		<TD class=table_head width=100><nobr>".getlang("ชื่อเรื่อง::l::Title")."</nobr></TD>
		<TD class=table_head  $bgcolor width=500>".marc_gettitle($wh[mid])." $addstr</TD>
	</TR>
	<TR>
		<TD class=table_td colspan=2 align=right ><b>Call Number</b>: ".marc_getcalln($wh[mid])." ::
		 <b><a class=a_btn href='../dublin.php?ID=$wh[mid]' target=_blank>".getlang("ดูรายละเอียด::l::View in detail")."</a> ::
		  <a href='mediacontent.php?FTCODE=$FTCODE&mid=$wh[mid]' style='color:darkred;' class=a_btn>".getlang("เลือกรายการนี้::l::Select this media")."</a></b></TD>
	</TR>
	";
	
	$s.="<TR>
		<TD colspan=2 align=right>";
		$md=tmq("select * from media_mid where pid='$wh[mid]' ");
		$s.="<TABLE width=70%>";
			$s.="<TR>
			<TD class=table_head2 width=200>Barcode</TD>
			<TD class=table_head2>".getlang("ประเภทวัสดุ::l::Resource Type")."</TD>
			</TR>";
		while ($mdr=tmq_fetch_array($md)) {
			$s.="<TR>
			<TD class=table_td>$mdr[bcode] </TD>
			<TD class=table_td>".get_media_type($mdr[RESOURCE_TYPE])."</TD>
			</TR>";
		}
		$s.="</TABLE>";
	$s.="</TD>
	</TR>
	</TABLE>";
	
	return $s;
}

$tbname="index_db";

//$limit=" ulibnote not like '%,$FTCODE,%'  ";
$limit=' 1 ';
if ($kw!="" && $kwtype!="") {
	$limit.=" and $kwtype like '%$kw%' ";
}
if ($mediatype!="") {
	$limit.=" and mdtype  like '%,$mediatype,%' ";
}
if ($mediabarcode!="") {
	$limit.=" and bcode  like '%,$mediabarcode,%' ";
}
if ($webpageshowcase!="") {
	$limit.=" and webpageshowcase  = 'yes' ";
}	

//echo "[$limit]";
	$s=tmq("select * from media_fttype where code='$FTCODE' ");
	$s=tmq_fetch_array($s);
	$s= getlang($s[name]);
$tmpstyle=" style='color: #1F2D4E; font-size: 17px' ";	
$o[addlink][] = "browse.php?FTCODE=$FTCODE::".getlang("กลับไปรายการ <B $tmpstyle>$s</B>::l::Back to <B $tmpstyle>$s</B> list")."::_self";
$o[addlink][] = "index.php::".getlang("จัดการ Content ประเภทอื่น::l::Manage other Content type")."::_self";


fixform_tablelister($tbname," $limit ",$dsp,"no","no","no","FTCODE=$FTCODE&mediabarcode=$mediabarcode&kw=$kw&kwtype=$kwtype&mediatype=$mediatype",$c,"",$o);
//*,REPLACE(bcode, ',', '') as bcode2 

foot();
?>