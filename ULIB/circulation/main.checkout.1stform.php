
<FORM METHOD=POST ACTION="main.checkout.php" target="_self" onsubmit="return chkswitchform(this)">
<TABLE cellpadding=0 border=0 cellspacing=0 width=100% >
<script>
function chkswitchform(wh) {
       if (wh.memberbarcode.value=="<?php  echo getval("global","libraryswitch_hold-return");?>") {
        self.location='main.checkin.php'
        return false;
	}
	wh.memberbarcode.select();
	return true;
}    
</script>
<TR>
	<TD class=table_tr><?php  echo getlang("กรุณากรอกรหัสบาร์โค้ดผู้ยืม::l::Please enter borrower's barcode")?></TD>
</TR>
<TR>
	<TD class=table_td><INPUT TYPE="text" NAME="memberbarcode" ID="memberbarcode" style="width:100%; background-image:url(user-icon.png); background-repeat: no-repeat; padding-left: 22px;" AUTOCOMPLETE=off
	value="<?php echo $memberbarcode ?>"
	><BR><INPUT TYPE="submit" value=" OK "> <B class=smaller><?php  echo getlang("ตัวเลือก::l::Options");?>:
	<A HREF="working.checkout.searchuser.php" target="working" class=smaller><?php  echo getlang("ค้นหาสมาชิก::l::Search User");?></A>
	</B></TD>
</TR><SCRIPT LANGUAGE="JavaScript">
<!--
	getobj('memberbarcode').focus();
	getobj('memberbarcode').select();
//-->
</SCRIPT>

</TABLE></FORM>
