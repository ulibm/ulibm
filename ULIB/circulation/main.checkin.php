<?php 
;
     include("../inc/config.inc.php"); 
	 html_start();
	 include("inc.php");
	 include("main.inc.head.php");

if ($firsttime=="yes") {
	sessionval_set("cir_checkinhist","");
}

	localloadmember("checkin");

?><BR>
<?php 
localheaddisplay("รับคืนวัสดุสารสนเทศ::l::Checkin items");
?>
<FORM METHOD=POST ACTION="working.checkin.php" target="working" onsubmit="return chkswitchform(this)">
<TABLE cellpadding=0 border=0 cellspacing=0 width=100% >
<script>
function chkswitchform(wh) {
       if (wh.mediabarcode.value=="<?php  echo getval("global","libraryswitch_hold-return");?>") {
        self.location='main.checkout.php'
        return false;
	}
	//wh.submitbtn.disabled=true;
	wh.mediabarcode.select();
	return true;
}    
</script>
<TR>
	<TD class=table_tr><?php  echo getlang("กรุณากรอกรหัสบาร์โค้ดวัสดุ::l::Please enter media's barcode")?></TD>
</TR>
<TR>
<TD class=table_td><INPUT TYPE="text" NAME="mediabarcode" ID="mediabarcode" style="width:100%; background-image:url(book-icon.png); background-repeat: no-repeat; padding-left: 22px;" AUTOCOMPLETE=off value="<?php echo $mediabarcode;?>" onfocus="this.select();"><BR><INPUT TYPE="submit" value=" OK " ID='submitbtn' name='submitbtn'> <B class=smaller>
<?php  if (library_gotpermission("iscanbackdate")==true) {?>
<select name = Fdat><?php 
for ($i=1; $i <= 31; $i++) {
$sl = "";
$focusbg = "";
if (date("j") == $i) { $sl="selected";} else {$focusbg=" style='background-color: #F8D181' ";}
echo "<option value='$i' $sl $focusbg>$i";
}
?></select>
<select name = Fmon><?php 
		for ($i=1; $i <= 12; $i++) {
			$sl = "";
			$focusbg = "";
			$sw=date("n");
			if ($sw == $i) { $sl="selected"; } else {$focusbg=" style='background-color: #F8D181' ";}
				echo "<option value='$i' $sl $focusbg> ";
				echo $thaimonstrbrief[$i];
			}
	?></select>
<select name = Fyea><?php 
		for ($i=$_MSTARTY; $i <= $_MENDY; $i++) {
			$sl = "";
			$focusbg = "";
			$sw=(date("Y") +543);
			//echo "$sw==$i";
			if ($sw == $i) { $sl="selected"; } else {$focusbg=" style='background-color: #F8D181' ";}
			echo "<option value='$i' $sl $focusbg>$i";
			}
	?></select>
<?php  } else {
	echo ymd_datestr(time(),"date");
	echo "<input type=hidden name='Fdat' value='".(date("j") )."'>";
	echo "<input type=hidden name='Fmon' value='".(date("n") )."'>";
	echo "<input type=hidden name='Fyea' value='".(date("Y") +543)."'>";
}?>
</TD>
</TR><SCRIPT LANGUAGE="JavaScript">
<!--
	getobj('mediabarcode').focus();
	getobj('mediabarcode').select();
//-->
</SCRIPT>

</TABLE>
<input type=hidden name="cirmode" value="checkin">

</FORM>