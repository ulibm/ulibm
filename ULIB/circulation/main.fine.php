<?php 
;
     include("../inc/config.inc.php"); 
	 html_start();
	 include("inc.php");
	 include("main.inc.head.php");
	if ($loadremotefine!="yes") {
		localloadmember("fine");
	} else {
		localloadmember($memberbarcode,"yes");
	}

   
?><BR>
<?php 
localheaddisplay("จัดการค่าปรับ::l::Manage Fines","#800000");
?>
<FORM METHOD=POST ACTION="working.fine.php" target="working" onsubmit="return chkswitchform(this)" NAME=mainfineform ID=mainfineform>
<TABLE cellpadding=0 border=0 cellspacing=0 width=100% >
<script>
function chkswitchform(wh) {
    if (wh.memberbarcode.value=="<?php  echo getval("global","libraryswitch_hold-return");?>") {
        self.location='main.checkout.php'
        return false;
	}
	//wh.submitbtn.disabled=true;
	wh.memberbarcode.select();
	return true;
}    
</script>
<TR>
	<TD class=table_tr><?php  echo getlang("กรุณากรอกรหัสบาร์โค้ดสมาชิก::l::Please enter member's barcode")?></TD>
</TR>
<TR>
<TD class=table_td><INPUT TYPE="text" NAME="memberbarcode" ID="memberbarcode" style="width:100%; background-image:url(user-icon.png); background-repeat: no-repeat; padding-left: 22px;" AUTOCOMPLETE=off value="<?php  echo $memberbarcode?>" onclick="this.select();"><BR><INPUT TYPE="submit" value=" OK " ID='submitbtn' name='submitbtn'>  <B class=smaller><?php  echo getlang("ตัวเลือก::l::Options");?>:
	<A HREF="working.fine.searchuser.php" target="working" class=smaller><?php  echo getlang("ค้นหาสมาชิก::l::Search User");?></A>
</TD>
</TR><SCRIPT LANGUAGE="JavaScript">
<!--
<?php 
if ($submitnow=="yes" && $memberbarcode!="") {
?> getobj('mainfineform').submit();
<?php 
} else {
?>
	getobj('memberbarcode').select();
<?php 
}	
?>
//-->
</SCRIPT>

</TABLE>
<input type=hidden name="cirmode" value="checkin">
<input type=hidden name="skipalertfine" value="<?php  echo $skipalertfine; ?>">

</FORM>
