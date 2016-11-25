<?php 
;
     include("../inc/config.inc.php"); 
	 html_start();
	 include("inc.php");
	 include("working.inchead.php");

	pagesection("วัสดุสารสนเทศสูญหาย/ชำรุด::l::Material Damage/Lost");

/////////////////////

?><TABLE width=780 align=center class=table_border>
<FORM METHOD=POST ACTION="working.lost2.php">
	<TR>
	<TD class=table_head><?php  echo getlang("ใส่บาร์โค้ดวัสดุสารสนเทศ::l::Enter Material's barcode");?></TD>
	<TD class=table_td><INPUT TYPE="text" NAME="damagebarcode" ID=damagebarcode></TD>
</TR>
<SCRIPT LANGUAGE="JavaScript">
<!--
	getobj('damagebarcode').select();
//-->
</SCRIPT>
<TR>
	<TD class=table_td colspan=2 align=center><INPUT TYPE="submit" value="  OK  "></TD>
</TR>
</FORM>
</TABLE>