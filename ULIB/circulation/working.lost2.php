<?php 
;
     include("../inc/config.inc.php"); 
	 html_start();
	 include("inc.php");
	 include("working.inchead.php");

	$c=tmq("select * from media_mid where bcode='$damagebarcode' ");
	if (tmq_num_rows($c)==0) {
		echo "<CENTER><BR>";
		html_dialog("","ไม่พบบาร์โค้ดที่ระบุ");
		echo "<A HREF='working.lost.php'>".getlang("กลับ::l::Back")."</A></CENTER>";
		die;
	}
	$c=tmq_fetch_array($c);
	//printr($c);
?>
<TABLE width=780 align=center class=table_border>
<FORM METHOD=POST ACTION="working.lostaction.php">
<TR>
	<TD class=table_head width=200>Title</TD>
	<TD class=table_td><?php  echo marc_gettitle($c[pid]);?></TD>
</TR>
<TR>
<INPUT TYPE="hidden" NAME="damagebarcode" value="<?php  echo $damagebarcode;?>">
	<TD class=table_head width=200>Barcode</TD>
	<TD class=table_td><?php  echo $damagebarcode;?></TD>
</TR>
<TR>
	<TD class=table_head width=200><?php  echo getlang("สถานะปัจจุบัน::l::Current Status");?></TD>
	<TD class=table_td><?php  
if ($c[status]=="") {
	echo " - ";
} else {
	$tmp=tmq("select * from media_mid_status where code='$c[status]' ");
	$tmp=tmq_fetch_array($tmp);
	echo getlang($tmp[name]);
	echo " ($c[status])";
	echo " - ";
	if ($tmp[iscancheckout]=="no") {
		echo getlang("ยืมออกไม่ได้::l::Cannot checkout");
	} else {
		echo getlang("ยืมออกได้::l::Can checkout");
	}
}
?></TD>
</TR>
<TR>
	<TD class=table_head width=200><?php  echo getlang("กำหนดสถานะเป็น::l::Set Status to");?></TD>
	<TD class=table_td><?php  frm_genlist("newstatus","select * from media_mid_status where code<>'$c[status]' order by code","code","name","","yes","lost");?></TD>
</TR>
<TR>
	<TD class=table_head colspan=2>Checkout Information</TD>
</TR>
<?php 
$co=tmq("select * from checkout where mediaId='$damagebarcode' ");
if (tmq_num_rows($co)==0) {
	?><INPUT TYPE="hidden" NAME="includefine" value="no">
<TR>
	<TD class=table_td colspan=2 align=center><?php  echo getlang("ยังไม่ถูกยืมออก::l::Not checked out");?></TD>
</TR>
	<?php 
} else {
		$co=tmq_fetch_array($co);
		localloadmember($co[hold],"yes");
	?>
<TR><INPUT TYPE="hidden" NAME="memberbarcode" value="<?php  echo $co[hold];?>">
	<TD class=table_head ><?php  echo getlang("ถูกยืมออกโดย::l::checked out by");?></TD>
	<TD class=table_td ><?php  echo get_member_name($co[hold]);?></TD>
</TR>
<TR>
	<TD class=table_head ><?php  echo getlang("เพิ่มค่าปรับ::l::Add fine");?></TD>
	<TD class=table_td ><INPUT TYPE="checkbox" NAME="includefine" value='yes' checked style="border:0"> <?php  echo getlang("ลบออกจากรายการยืม และเพิ่มค่าปรับ::l::Remove checkout information, and add fine to user");?></TD>
</TR>
<TR>
	<TD class=table_head ><?php  echo getlang("ชื่อ::l::Topic");?></TD>
	<TD class=table_td ><INPUT TYPE="text" NAME="fine_topic" size=50 value="LOST: <?php  echo addslashes(marc_gettitle($c[pid]));?>"></TD>
</TR>
<TR>
	<TD class=table_head ><?php  echo getlang("ค่าปรับ::l::Fine");?></TD>
	<TD class=table_td ><INPUT TYPE="text" NAME="fine_fine" ID="fine_fine" value="<?php echo ($c[price])?>"></TD>
</TR>
<SCRIPT LANGUAGE="JavaScript">
<!--
	getobj('fine_fine').select();
//-->
</SCRIPT>
	<?php }
?>
<TR>
	<TD class=table_td colspan=2 align=center><INPUT TYPE="submit" value="  OK  "></TD>
</TR>
</FORM>
</TABLE>