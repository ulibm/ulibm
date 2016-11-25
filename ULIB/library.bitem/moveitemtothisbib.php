<?php 
;
     include("../inc/config.inc.php"); 
	head();
	include("_REQPERM.php");
	mn_lib();
	 ?>
  <table width="<?php  echo $_TBWIDTH?>" align=center border="0" cellspacing="0" cellpadding="0">
    <tr valign="top"> 
      <td>
<?php pagesection(getlang("ย้ายไอเทมของ Bib อื่นมายัง Bib นี้::l::Move item from other Bib. to this Bib."));?>
</TD>
</TR>
</TABLE>
<TABLE width="770" border="0" cellspacing="1" cellpadding="3" align=center>
<TR>
	<TD><?php 
  res_brief_dsp($MID);	

if ($confirmmove!="") {
	$bcms=tmq("select * from media_mid where bcode='$confirmmove' ");
	if (tmq_num_rows($bcms)==0) {
		html_dialog("",getlang("ไม่พบบาร์โค้ด $bcm ::l::barcode $bcm not found.") ."<A class=a_btn HREF='moveitemtothisbib.php?MID=$MID&remotes_row=$remotes_row'>".getlang("ลองใหม่ ::l:: try again")."</A>");
	} else {
		tmq("update media_mid set pid='$MID' where bcode='$confirmmove' ",true);
		html_dialog("",getlang("ทำการย้ายบาร์โค้ด $confirmmove แล้ว::l:: Moved barcode $confirmmove"));
	}
}
	?></TD>
</TR>
</TABLE><CENTER>
<?php 
if ($bcm=="") {
?><BR>
<TABLE width=500 align=center class=table_border>
<FORM METHOD=POST ACTION="moveitemtothisbib.php">
<INPUT TYPE="hidden" NAME="MID" value="<?php  echo $MID;?>">
<INPUT TYPE="hidden" NAME="remotes_row" value="<?php  echo $remotes_row;?>">
	<TR>
	<TD class=table_head><?php  echo getlang("กรุณาสแกนบาร์โค้ดที่ต้องการย้ายมา::l::Please scan barcode you want to move to this Bib");?></TD>
</TR>
<TR>
	<TD class=table_td><INPUT TYPE="text" NAME="bcm" ID=BCM> <INPUT TYPE="submit" value=" OK "> <A HREF="./media_type.php?MID=<?php  echo $MID;?>&remotes_row=<?php echo $remotes_row?>"  class=a_btn><?php  echo getlang("กลับ::l::Back"); ?></A> 
</TD>
</TR><SCRIPT LANGUAGE="JavaScript">
<!--
	tmp=getobj("BCM");
tmp.focus();
tmp.select();
//-->
</SCRIPT>
</FORM>
</TABLE>
<?php 
} else {
	////verify and confirm
	$bcms=tmq("select * from media_mid where bcode='$bcm' ");
	if (tmq_num_rows($bcms)==0) {
		html_dialog("",getlang("ไม่พบบาร์โค้ด $bcm ::l::barcode $bcm not found.") ."<A class=a_btn HREF='moveitemtothisbib.php?MID=$MID&remotes_row=$remotes_row'>".getlang("ลองใหม่ ::l:: try again")."</A>");
	} else {
		$bcms=tmq_fetch_array($bcms);
		?>
<TABLE width=500 align=center class=table_border>
<TR>
	<TD class=table_head><?php  echo getlang("กรุณายืนยัน::l::Please confirm.");?></TD>
</TR>
<TR>
	<TD  class=table_td><?php  echo getlang("ย้ายไอเทม บาร์โค้ด: ::l::Move item: barcode") .$bcm;?></TD>
</TR>
<TR>
	<TD  class=table_td>
	<TABLE width=100%>
	<TR>
		<TD  class=table_td><?php  echo getlang("Bib. เดิม::l::Current Bib.");?></TD>
	</TR>
	<TR>
		<TD><?php 
  res_brief_dsp($bcms[pid]);	
	?></TD>
	</TR>
	</TABLE>
	</TD>
</TR>
<TR>
	<TD><?php 
echo "<B><A class=a_btn HREF='moveitemtothisbib.php?confirmmove=$bcm&MID=$MID&remotes_row=$remotes_row'>".getlang("ยืนยันการย้ายไอเทม ::l:: Confirm move item")."</A></B> : "	;
echo "<A class=a_btn HREF='moveitemtothisbib.php?MID=$MID&remotes_row=$remotes_row'>".getlang("ยกเลิก ::l:: Cancel")."</A> : "	;
echo " <A class=a_btn HREF='media_type.php?MID=$MID&remotes_row=$remotes_row'>".getlang("กลับ ::l:: Back")."</A>"	
	?></TD>
</TR>
</TABLE>		
		<?php 
	}
}
index_reindex($MID);
foot();
?>