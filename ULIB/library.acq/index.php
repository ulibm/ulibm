<?php 
	; 
		
        include ("../inc/config.inc.php");
		if ($save=="yes") {
			barcodeval_set($item,$contents);	
			redir($dcrURL."library/mainadmin.php");
		} else {
		head();
		include("_REQPERM.php");
        mn_lib();
?>
<TABLE width=780 align=center class=table_border>
<FORM METHOD=POST ACTION="index.php">

<TR>
	<TD class=table_head><?php  echo getlang("แก้ไขข้อความ::l::Edit text");?></TD>
</TR>
<TR>
	<TD><INPUT TYPE="submit" value=' <?php  echo getlang("บันทึก::l::Save");?> '> 
	<A HREF="../library/mainadmin.php"><B><?php  echo getlang("กลับ::l::Back");?></B></A>
</TD>
</TR>

<INPUT TYPE="hidden" name=save value="yes">
<INPUT TYPE="hidden" name=item value="<?php  echo $item;?>">
<TR class=table_td>
	<TD><TEXTAREA NAME="contents" ROWS="25" COLS="80"><?php 

echo (barcodeval_get ("$item"));
?></TEXTAREA></TD>
</TR>

<TR>
	<TD><INPUT TYPE="submit" value=' <?php  echo getlang("บันทึก::l::Save");?> '> <A HREF="../library/mainadmin.php"><B><?php  echo getlang("กลับ::l::Back");?></B></A>
</TD>
</FORM>
</TR>

</TABLE><?php 
		}
		foot();
?>