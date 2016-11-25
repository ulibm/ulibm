
<?php  $mediabarcode=trim($mediabarcode);?>
<FORM METHOD=POST ACTION="working.viewmember.php" target="working" onsubmit="return chkswitchform(this)">
<TABLE cellpadding=0 border=0 cellspacing=0 width=100% >
<script>
function chkswitchform(wh) {
       if (wh.mediabarcode.value=="<?php  echo getval("global","libraryswitch_hold-return");?>") {
        self.location='main.checkin.php'
        return false;
	}
	//wh.submitbtn.disabled=true;
	wh.mediabarcode.select();
	return true;
}    
</script>
<input type=hidden name="cirmode" value="checkout">
<input type=hidden name="memberbarcode" value="<?php  echo $memberbarcode;?>">
	<TR>
	<TD class=table_tr><?php  echo getlang("กรุณากรอกรหัสบาร์โค้ดวัสดุ::l::Please enter media's barcode")?></TD>
</TR>
<TR>
<TD class=table_td><INPUT TYPE="text" NAME="mediabarcode" ID="mediabarcode" style="width:100%; background-image:url(book-icon.png); background-repeat: no-repeat; padding-left: 22px;" AUTOCOMPLETE=off value="<?php  echo $mediabarcode;?>"><BR><INPUT TYPE="submit" value=" OK " ID='submitbtn' name='submitbtn'> <B class=smaller>

<?php  
	echo ymd_datestr(time(),"date");
	echo "<input type=hidden name='Fdat' value='".(date("j") )."'>";
	echo "<input type=hidden name='Fmon' value='".(date("n") )."'>";
	echo "<input type=hidden name='Fyea' value='".(date("Y") +543)."'>";
?></B></TD>
</TR><SCRIPT LANGUAGE="JavaScript">
<!--
	getobj('mediabarcode').focus();
	getobj('mediabarcode').select();
//-->
</SCRIPT>

</TABLE></FORM>
