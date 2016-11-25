<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
	$_REQPERM="importer_bookitem";
	$tmp=mn_lib();
	pagesection($tmp);
//echo $fpath;
?><BR><CENTER><B><?php  echo getlang("กรุณาระบุรายละเอียดด้านล่างให้ครบ::l::Please specific information in the form"); ?></B></CENTER>
<BR>
<TABLE align=center width=550>
<FORM METHOD=POST ACTION="step2.php">

<TR>
	<TD><?php  echo getlang("ชุดการนำเข้าของวัสดุฯ::l::Material's Import ID"); ?></TD>
	<TD><SELECT NAME="importset">
	<?php 
  $sql1 ="SELECT distinct importid, count(id) as cc FROM media  group by importid"; 
$s=tmq($sql1);
while ($r=tmq_fetch_array($s)) {
	echo "<option value='$r[importid]'>$r[importid] (".number_format($r[cc]).") ";
}

	?></SELECT></TD>
</TR>
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
	<TD><?php  echo getlang("เป็นไอเทมของห้องสมุดใด::l::Campus of these Items"); ?></TD>
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
			<TD><?php  echo getlang("ประเภทไอเทม::l::Item's Type"); ?></B></TD>
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