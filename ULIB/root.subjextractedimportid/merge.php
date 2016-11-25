<?php 
    ;
	include ("../inc/config.inc.php");
	head();
	mn_root("subjextractedimportid");
	pagesection("รวมรายการย่อย ๆ เข้าด้วยกัน");
	?>

<BR><TABLE width=770 align=center>
<FORM METHOD=POST ACTION="mergeaction.php">
                                <TR>
                	<TD width=280><?php  echo getlang("รวมรายการที่มีข้อมูลน้อยกว่าหรือเท่ากับ::l::Merge import ID which contain item lesser or equal"); ?> </TD>
                	<TD> <INPUT TYPE="text" NAME="decisval" value=50></TD>
                </TR>
                <TR>
                	<TD><?php  echo getlang("ให้มาอยู่ในรายการที่ชื่อว่า::l::New import ID"); ?> </TD>
                	<TD> Merge:<INPUT TYPE="text" NAME="newname" value="รวมรายการ <?php  echo thaidatestr();?>" size=50></TD>
                </TR>
				<TR>
                	<TD colspan=2 align=center><INPUT TYPE="submit"></TD>
                </TR>
                </FORM>
                </TABLE><CENTER><BR><A HREF="media_type.php"><?php  echo getlang("กลับ::l::Back"); ?></A><BR></CENTER>
<?php 
foot();
?>