<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
	$_REQPERM="importer_ignoreword";
	$tmp=mn_lib();
			pagesection(getlang("นำเข้า Stop words::l:: Stop words Importer"));
//echo $fpath;
?><BR><CENTER><B><?php  echo getlang("กรุณาระบุรายละเอียดด้านล่างให้ครบ::l::Please specific information in the form"); ?></B></CENTER>
<BR>
<TABLE align=center width=550>
<FORM METHOD=POST ACTION="step2.php">
<TR>
	<TD><?php 
	echo getlang("แต่ละ Record แยกจากกันด้วย::l::Each record seperates with"); ?></TD>
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