<?php 
    ;
	include("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	mn_lib();
function local_menu($text,$url,$descr) {
   global $dcr;
	?><table width = "550" align=center border = "0" cellspacing = "0" cellpadding = "0">
		<tr>
			<td rowspan = "2">
				&nbsp;</td>
			<td width = "525">
				<font face = "MS Sans Serif, Microsoft Sans Serif" size = "2"><a class = stupidmenu href = "<?php  echo $url;?>">
				<font size = "5" class = stupidmenu><?php  echo getlang($text);?></font></a></font></td>
		</tr>
		<tr>
			<td width = "525">
				<font face = "MS Sans Serif, Microsoft Sans Serif" size = "2"><?php  echo getlang($descr);?></font></td>
		</tr>
		<tr>
			<td colspan = "2" height = "2">
				<font size = "2" face = "MS Sans Serif, Microsoft Sans Serif">
				<img src = "/<?php echo "$dcr"; ?>/images/spacer.gif" width = "1" height = "5"></font></td>
		</tr>
	</table>
<?php 
}
?><BR><?php 
	local_menu("ส่งออก Marc ทั้งหมดในฐานข้อมูล::l::Export all records in database","all.php","ส่งออกข้อมูลวัสดุสารสนเทศทุกระเบียนในฐานข้อมูล::l::Export all records in database");
	local_menu("ส่งออก Marc ตามชุดข้อมูลที่ Import::l::Export by Import ID","importid.php","");
	local_menu("ตามประเภทวัสดุ ที่ระบุใน Leader/06::l::Export by Leader/06","rectypeleader.php","");
	local_menu("ตามประเภทวัสดุ ที่ระบุใน Item::l::Export by material type in it's items","rectypeitem.php","");
	local_menu("ส่งออกตามช่วงของหมายเลข Bib.::l::Export by Bib.ID range","bibrange.php","");



if ($lib_marcexport_items!="") {
	barcodeval_set("lib_marcexport_items","$lib_marcexport_items");
	barcodeval_set("lib_marcexport_encoding","$lib_marcexport_encoding");
}
?><BR><FORM METHOD=POST ACTION="mn.php">
<TABLE width=450 align=center class=table_border>
	<TR>
	<TD class=table_head><?php  echo getlang("Export Item ด้วยหรือไม่?::l::Export Items?");?></TD>
	<TD class=table_td>
<?php 
//printr($_POST);
$ise=barcodeval_get("lib_marcexport_items");?>
	<label><INPUT TYPE="radio" NAME="lib_marcexport_items" value="yes"
	<?php  if ($ise=="yes") { echo " checked ";}	?>
	><?php  echo getlang("ส่งออก::l::Yes");?></label>
	<label><INPUT TYPE="radio" NAME="lib_marcexport_items" value="no" 	
	<?php  if ($ise=="no") { echo " checked ";}	?>
><?php  echo getlang("ไม่ส่งออก::l::No");?></label>
	
	</TD>
</TR>
<TR>
	<TD class=table_head><?php  echo getlang("Encoding");?></TD>
	<TD class=table_td>
<?php 
//printr($_POST);
$lib_marcexport_encoding=barcodeval_get("lib_marcexport_encoding");?>
	<label>
	<?php 
form_quickedit("lib_marcexport_encoding",$lib_marcexport_encoding,"list:systemdefault,tis620,utf8");
?>	
	</TD>
</TR>
	<TR>
	<TD class=table_td>&nbsp;
	</TD>
	<TD class=table_td> <INPUT TYPE="submit" value=" Save " ></TD>
</TR>
</TABLE>
</FORM>

<?php 
					foot();
					?>