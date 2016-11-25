<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
	$_REQPERM="importer_book";
	$tmp=mn_lib();
	pagesection($tmp);
//echo $fpath;
?><BR><CENTER><B><?php  echo getlang("กรุณาระบุรายละเอียดด้านล่างให้ครบ::l::Please specific information in the form"); ?></B></CENTER>
<BR>
<TABLE align=center width=550>
<FORM METHOD=POST ACTION="step2.php">

<TR>
	<TD><?php  echo getlang("แต่ละ Record แยกจากกันด้วย::l::Each record seperates with"); ?></TD>
	<TD>
	<INPUT TYPE="text" NAME="sep_rec" value='\n'></TD>
</TR>
<TR>
	<TD><?php  echo getlang("ครอบแต่ละฟิลด์ด้วยอักขระใด::l::Cover fields with"); ?></TD>
	<TD>
	<INPUT TYPE="text" NAME="cover_field" value='"'></TD>
</TR>
<TR>
	<TD><?php  echo getlang("แต่ละเขตข้อมูลแยกจากกันด้วยอักขระใด::l::Seperates fields with"); ?></TD>
	<TD>
	<INPUT TYPE="text" NAME="sep_field" value=','></TD>
</TR>


<TR>
	<TD><?php  echo getlang("มีบาร์โค้ดวัสดุฯรวมอยู่ด้วยหรือไม่ (พบมากในฐานข้อมูลแบบเก่า)::l::Item's barcode included?  (Commonly in old style databases)"); ?></TD>
	<TD>
	<INPUT TYPE="checkbox" NAME="isbc" style="border: 0px;"></TD>
</TR>

<TR bgcolor=f2f2f2>
	<TD colspan=2><?php  echo getlang("หากมีบาร์โค้ดวัสดุฯรวมอยู่ด้วย โปรแกรมจะสร้าง Item ให้อัตโนมัติ ตามรายละเอียดด้านล่าง::l::If item's barcode included, this import program will create media's items automatically with following data."); ?></TD>
</TR>
<TR>
	<TD><?php  echo getlang("เป็นวัสดุฯของห้องสมุดใด::l::Campus of these Material"); ?></TD>
	<TD>
	<?php 
	frm_libsite("libsite");
	?></TD>
</TR>


<TR valign=top>

<TD><?php  echo getlang("เปลี่ยนสถานะเป็น::l::Item's  Status "); ?></B> </TD>
			<TD><SELECT NAME="status">
<?php 
	echo "<option value=''>ปกติ ";
$s=tmq("select * from media_mid_status order by name");
while ($r=tmq_fetch_array($s)) {
	echo "<option value='$r[code]'>$r[name] ($r[code]) ";
}
?> 
			</SELECT></TD>
		</TR>

	<TR>
			<TD><?php  echo getlang("เปลี่ยนสถานที่จัดเก็บ::l::Item's  Shelf"); ?></B></TD>
			<TD><?php frm_itemplace("itemplace","NONE","NO");
?></TD>
	</TR>

	<TR>
			<TD><?php  echo getlang("ประเภทวัสดุฯ::l::Item's Type"); ?></B></TD>
			<TD><?php frm_restype("itemtype","","NO");?></TD>
	</TR>

<TR>
	<TD><?php  echo getlang("บาร์โค้ดแต่ละตัวแยกจากกันด้วยอักขระใด::l::Each barcode seperates with"); ?></TD>
	<TD>
	<INPUT TYPE="text" NAME="bcsep_field" value='/'></TD>
</TR>



<INPUT TYPE="hidden" name=file value="<?php echo $file;?>">
<TR>
	<TD colspan=2 align=center><BR><INPUT TYPE="submit" value="  Next  "><BR>


	</TD>
</TR>
</FORM>
</TABLE>
<BR><BR>
<?php  foot();
?>