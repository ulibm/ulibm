<?php  
    ;
	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	mn_lib();
	
	$msg="";

if ($itemid!="") {
	$msg.=getlang("บาร์โค้ดที่สแกน=::l::Scanned barcode="). "[$itemid]<HR noshade>";
	$s=tmq("select * from media_mid where bcode='$itemid' ");
	if (tmq_num_rows($s)!=1) {
		$msg.= "<FONT COLOR=darkred><B>";
		$msg.= getlang("ไม่พบบาร์โค้ดนี้ กรุณาแยกเพื่อลงทะเบียน::l::Barcode not found please register this item.");
		$msg.= "</B></FONT>";
	} else {
		$s=tmq_fetch_array($s);
		$sql="update media_mid  set ismarked='YES' where bcode='$itemid' ";
		tmq($sql);

	}
}

?><BR><BR><TABLE width=100% align=center>
<FORM METHOD=POST ACTION="scanbc.php">
<INPUT TYPE="hidden" name=qnid value="<?php  echo $qnid;?>">
<TR>
	<TD align=center><B><?php echo getlang("สแกนบาร์โค้ด::l::Scan item's barcode "); ?></B> </TD>
	<TD align=center><B><INPUT TYPE="text" NAME="itemid" ID=ITEMID> <INPUT TYPE="submit" value="SUBMIT"> 
[<?php  
echo getlang("นับแล้ว::l::Counted ");
echo " ";
echo tmq_num_rows(tmq("select id from media_mid where ismarked='YES'"));	
?>]
	</TD>
</TR>
<SCRIPT LANGUAGE="JavaScript">
<!--
getobj('ITEMID').select();
//-->
</SCRIPT>
</FORM>
<TR>
	<TD colspan=2 align=center>
<?php  
echo $msg;
//print_r($_GET);
?>
</TD>
</TR>

</TABLE><BR>
<CENTER><A HREF="./media_type.php" class=a_btn><?php echo getlang("กลับ::l::Back");?></A></CENTER>
  <?php  
		foot();   
	   ?>