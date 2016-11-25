<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		include("_REQPERM.php");
        mn_lib();
			pagesection(getlang("นำเข้าข้อมูลเพื่อบาร์โค้ด::l::Import data to Barcode-on-demand"));
//echo $fpath;
?><BR><CENTER><B><?php  echo getlang("กรุณาระบุรายละเอียดด้านล่างให้ครบ::l::Please specific following information"); ?></B></CENTER>
<BR>
<TABLE align=center width=550>
<FORM METHOD=POST ACTION="step2.php">
<TR>
	<TD><?php  echo getlang("บาร์โค้ดแต่ละตัวแยกจากกันด้วย::l::Each records seperated by"); ?></TD>
	<TD>
	<INPUT TYPE="text" NAME="sep_rec" value='\n'></TD>
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