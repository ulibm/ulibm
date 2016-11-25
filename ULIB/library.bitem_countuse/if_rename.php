<?php 
	; 
		
        include ("../inc/config.inc.php");
				html_start();
loginchk_lib();
 if (!library_gotpermission("bitem_countuse_manage")) { die("no permission") ; }

	$s=tmq("select * from countuse_name where countuse='$qnid' ");

	if (tmq_num_rows($s) ==0 )  {
		$name="[".getlang("ยังไม่ได้ตั้งชื่อ::l::Name not set")."]";
	} else {
		$s=tmq_fetch_array($s);
		$name=$s[name];
	}
?><style>
body {
	background-color: #F4F4F4;
}
</style><TABLE width=100% align=center>
<FORM METHOD=POST ACTION="if_renameaction.php">
<INPUT TYPE="hidden" name=qnid value="<?php echo $qnid;?>">
<TR>
	<TD align=center><B><?php  echo getlang("กรุณาใส่ชื่อ::l::Please enter name "); ?></B> </TD>
	<TD align=left><B><INPUT TYPE="text" NAME="name" ID=ITEMID value="<?php  echo $name;?>" size=40> 
	</TD>
</TR>
<TR>
	<TD align=center><B><?php  echo getlang("จัดการไอเทมที่ใด::l::Which shelf  "); ?></B> </TD>
	<TD align=left><B>
	<?php 
	frm_itemplace("shelf",$s[shelf]);
	?>
	<INPUT TYPE="submit" value="SUBMIT"> 
	</TD>
</TR>
<SCRIPT LANGUAGE="JavaScript">
<!--
getobj('ITEMID').select();
//-->
</SCRIPT>
</FORM>


</TABLE>