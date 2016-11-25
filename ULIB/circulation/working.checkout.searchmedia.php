<?php 
;
     include("../inc/config.inc.php"); 
	 html_start();
	 include("inc.php");
	 include("working.inchead.php");

?>
<TABLE class=table_border width=100% align=center>
<FORM METHOD=POST ACTION="working.checkout.searchmedia.php">
	<INPUT TYPE="hidden" NAME="memberbarcode" ID="memberbarcode" value="<?php  echo $memberbarcode?>">
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
	<INPUT TYPE="submit" value=" OK "> <A HREF="working.checkout.searchmedia.php?memberbarcode=<?php  echo $memberbarcode;?>"><?php echo getlang("แสดงทั้งหมด::l::Show all")?></A></TD>
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
	global $memberbarcode;
	global $dcrs;
	global $dcrURL;
	$s="";
	$s.="<TABLE width=100%>
	<TR>
		<TD class=table_head><nobr>".getlang("ชื่อเรื่อง::l::Title")."</nobr></TD>
		<TD class=table_head>".marc_gettitle($wh[mid])."</TD>
	</TR>
	<TR>
		<TD class=table_head><nobr>Call Number</nobr></TD>
		<TD class=table_td>".marc_getcalln($wh[mid])."</TD>
	</TR>
	";
	$s.="<TR>
		<TD colspan=2 align=right>";
		$md=tmq("select * from media_mid where pid='$wh[mid]' ");
		$s.="<TABLE width=88%>";
			$s.="<TR>
			<TD class=table_head>Barcode</TD>
			<TD class=table_head>".getlang("ประเภทวัสดุ::l::Resource Type")."</TD>
			</TR>";
		while ($mdr=tmq_fetch_array($md)) {
			$iscout=tmq("select id from checkout where mediaId='$mdr[bcode]' ");
			$s.="<TR>
			<TD class=table_td>";
			if (tmq_num_rows($iscout)==0) {
				$s.="<A HREF='main.checkout.php?memberbarcode=$memberbarcode&mediabarcode=$mdr[bcode]' target=main>$mdr[bcode] (".getlang("คลิกเพื่อยืม::l::Click to use").")</A>";
				if ($mdr[status]!="") {
					$s.= " (".getlang("สถานะ::l::status").'='."".get_mid_status($mdr[status]).")";
				}
			} else {
				$s.="$mdr[bcode]  (".getlang("ยืมออกไปแล้ว::l::Checked out").")";
			}
			$s.="</TD>
			<TD class=table_td width=40%>";
			
						$s.= "<img border=0 width=18 height=18 src='";
	if ($mdr[status]=="reservmat") {
		$usecode="(".get_media_type("reservmat").")";
		$imgtype="";
	} else {
		$usecode="";
		$imgtype="$mdr[RESOURCE_TYPE]";
	}
	if (file_exists("$dcrs/_tmp/mediatype/$imgtype.png")==true) {
		$s.= "$dcrURL/_tmp/mediatype/$imgtype.png";
	} else {
		$s.= "$dcrURL/_tmp/mediatype.png";
	}
	$s.= "' alt='".getlang($rectype[name])."' align=absmiddle> ";
			$s.=get_media_type($mdr[RESOURCE_TYPE])." $usecode</TD>
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

$o[tablewidth]="100%";

fixform_tablelister($tbname," $limit ",$dsp,"no","no","no","memberbarcode=$memberbarcode&mediabarcode=$mediabarcode&kw=$kw&kwtype=$kwtype&mediatype=$mediatype",$c,"",$o,"*,REPLACE(bcode, ',', '') as bcode2 ","having bcode2 <> '' ");

?>