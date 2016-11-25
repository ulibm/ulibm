<?php 
	; 
		
        include ("../inc/config.inc.php");
				html_start();
loginchk_lib();
?><style>
body {
	background-color: #F4F4F4;
}
</style>
<?php 
$msg="";
$c=tmq("select * from countuse_name where countuse='$qnid' ");
	if (tmq_num_rows($c)!=1) {
		$msg.= "<FONT COLOR=darkred><B>";
		$msg.= getlang("รายการคีย์ข้อมูล $qnid ยังไม่ได้ตั้งชื่อและยังไม่ได้เลือกชั้นที่จะทำงานด้วย <A class=a_btn HREF='if_rename.php?qnid=$qnid'>กรุณาคลิกที่นี่เพื่อตั้งชื่อและเลือกชั้น</A>::l::Counting set $qnid doesn't set name or shelf , <A class=a_btn HREF='if_rename.php?qnid=$qnid'>please click here to set</A>.");
		$msg.= "</B></FONT>";

		echo $msg;
		die;
	} 
	$c=tmq_fetch_array($c);

if ($itemid!="") {
	$msg.=getlang("บาร์โค้ดที่สแกน=::l::Scanned barcode="). "[$itemid]<HR noshade>";
	$s=tmq("select * from media_mid where bcode='$itemid' ");
	if (tmq_num_rows($s)!=1) {
		$msg.= "<FONT COLOR=darkred><B>";
		$msg.= getlang("ไม่พบบาร์โค้ดนี้ กรุณาแยกเพื่อลงทะเบียน::l::Barcode not found please register this item.");
		$msg.= "</B></FONT>";
	} else {
		$s=tmq_fetch_array($s);
		if ($s[place]!=$c[shelf]) {
			$cname=get_itemplace_name($c[shelf]);
			$csname=get_itemplace_name($s[place]);
			$msg.= "<FONT COLOR=darkred><B>";
			$msg.= getlang("ไอเทมนี้ ไม่ได้อยู่ในชั้น $cname แต่อยู่ใน $csname กรุณาแยกไอเทม [ไอเทมนี้ จะไม่ถูกนับ]::l::This item should placed at $csname not $cname , please re-check item.<BR>[This item not been counted]");
			$msg.= "</B></FONT>";

			//echo $msg;
			$msg.="<HR>";
			$msg.= html_displaymedia($s[pid]);
		} else {
			if ($s[$qnid]=='YES') {
			$msg.= "<FONT COLOR=orange><B>";
			$msg.="".getlang("บาร์โค้ดนี้ ถูกสแกนไปแล้ว::l::This barcode already scanned.");
			$msg.= "</B></FONT>";
			}
			$msg.="<HR>";
			$msg.= html_displaymedia($s[pid]);
			tmq("update media_mid set $qnid ='YES' where bcode='$itemid' ");
		}
	}
}

?><TABLE width=100% align=center>
<FORM METHOD=POST ACTION="if.php">
<INPUT TYPE="hidden" name=qnid value="<?php echo $qnid;?>">
<TR>
	<TD align=center><B><?php  echo getlang("สแกนบาร์โค้ด::l::Scan item's barcode "); ?></B> </TD>
	<TD align=center><B><INPUT TYPE="text" NAME="itemid" ID=ITEMID> <INPUT TYPE="submit" value="SUBMIT"> 
[<?php 
echo getlang("นับแล้ว::l::Counted ");
echo " ";
echo tmq_num_rows(tmq("select id from media_mid where $qnid='YES'"));	
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
	<TD colspan=2>
<?php 
echo $msg;
//print_r($_GET);
?>
</TD>
</TR>

</TABLE>