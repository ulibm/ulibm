<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="importer_mem";
        mn_lib();
			pagesection(getlang("นำเข้าข้อมูลสมาชิก::l::Import Member Records"));
//echo $fpath;
?><BR><CENTER><B><?php  echo getlang("กรุณาระบุรายละเอียดด้านล่างให้ครบ::l::Please specific information in the form"); ?></B></CENTER>
<BR>
<TABLE align=center width=550>
<FORM METHOD=POST ACTION="step2.php">
<TR valign=top>
	<TD><?php  echo getlang("เมื่ออิมพอร์ทแล้ว จะให้สมาชิกอยู่ในห้องใด::l::Room to be store these member"); ?></TD>
	<TD><?php 
	form_room("to_room",$to_room,"yes");
	?></TD>
</TR><TR valign=top>
	<TD><?php  echo getlang("ประเภทสมาชิกที่จะกำหนดให้::l::Member type for these member"); ?></TD>
	<TD>
	<SELECT NAME="mem_type">
	<?php 
	$s=tmq("select * from member_type order by descr");
	while ($r=tmq_fetch_array($s)) {
		echo "<option value='$r[type]' >$r[descr]";
	}
	?>
	</SELECT><BR>
	</TD>
</TR>
<TR>
	<TD><?php  echo getlang("เป็นสมาชิกของห้องสมุดใด::l::Campus of these member"); ?></TD>
	<TD>
	<?php 
	frm_libsite("libsite");
	?></TD>
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
<INPUT TYPE="hidden" name=file value="<?php echo $file;?>">
<TR>
	<TD colspan=2 align=center><BR><INPUT TYPE="submit" value="  Next  "><BR>

<?php  echo getlang("* อาจจะดีกว่า หากท่านสร้างห้องว่าง ๆ ไว้รองรับสมาชิกที่ได้จากการ Import เพราะหากเกิดข้อผิดพลาด จะได้ลบรายการเหล่านั้นทิ้งได้อย่างง่ายดาย::l::It's good idea to create new room for this import process. If error or incorrect importing occourred you just delete all member in this room."); ?>
	
	</TD>
</TR>
</FORM>
</TABLE>
<BR><BR>
<?php  foot();
?>