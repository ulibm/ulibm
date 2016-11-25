<?php  
	; 
        include ("../inc/config.inc.php");
		if (barcodeval_get("answerpoint_isenable")!="yes") {
			html_dialog("","this module disabled");
			die;
		}
		head();
        mn_web("answerpoint");
?>
<TABLE cellpadding=0 cellspacing=0 border=0 width="<?php echo $_TBWIDTH?>" align=center>
<TR valign=top>
	<TD width=200><?php  include("menu.php");?></TD>
<FORM METHOD=POST ACTION="addaction.php"  enctype="multipart/form-data">
		<TD align=center><BR>
		<?php  
		if ($_memid=="") {
			echo getlang("การตั้งคำถาม จะต้องล็อกอินเข้าระบบก่อน::l::Please login before open a question.");
			echo "<BR><A HREF='../member/index.php?backto=".urlencode("$dcrURL/answerpoint/add.php")."'>".getlang("ล็อกอินที่นี่::l::Login here")."</A>";
		} else {
			echo html_dialog("",barcodeval_get("answerpoint_agreement"));
			?><BR>
			<TABLE width=100% class=table_border>
			<TR>
				<TD class=table_head><?php echo getlang("หัวข้อคำถาม::l::Topic");?></TD>
				<TD class=table_td><INPUT TYPE="text" NAME="title" size=55></TD>
			</TR>
			<TR>
				<TD class=table_head><?php echo getlang("ข้อความคำถาม::l::Detail");?></TD>
				<TD class=table_td><TEXTAREA NAME="text" ROWS="10" COLS="60"></TEXTAREA></TD>
			</TR>
			<TR>
				<TD class=table_td align=center colspan=2><B><?php echo getlang("ภาพประกอบ 1::l::Attatch Image 1");?>: </B><input type=file name='img01'></TD>
			</TR>
			<TR>
				<TD class=table_td align=center colspan=2><B><?php echo getlang("ภาพประกอบ 2::l:: Attatch Image 2");?>: </B><input type=file name='img02'><BR>
				*.JPG only</TD>
			</TR>
			<TR>
				<TD class=table_td align=center colspan=2><INPUT TYPE="submit" value=" Submit "></TD>
			</TR>
			</TABLE>
			<?php  
		}
		?>
		</TD>

</FORM></TR>
</TABLE>
<?php  
				foot();
?>