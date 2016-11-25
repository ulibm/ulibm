<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="importer_memupdate";
        mn_lib();
			pagesection(getlang("อัพเดทข้อมูลสมาชิก::l::Update Member Records"));
//echo $fpath;
?><BR><CENTER><B><?php  echo getlang("กรุณาระบุรายละเอียดด้านล่างให้ครบ::l::Please specific information in the form"); ?></B></CENTER>
<BR>
<FORM METHOD=POST ACTION="step2.php">
<TABLE align=center width=550>
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

	
	</TD>
</TR>
</FORM>
</TABLE>
<BR><BR>
<?php  foot();
?>