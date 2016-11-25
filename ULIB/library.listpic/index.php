<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="listmempic";
        mn_lib();

			pagesection(getlang("ภาพสมาชิก::l::Member's Photo"));

	$local_pre=barcodeval_get("memberpic-local-prefix");
	$local_suf=barcodeval_get("memberpic-local-suffix");

if ($deleteall=="YES") {
	$x=fso_listfile("$dcrs/pic");
        for ($p = 0; $p <= count($x); $p++) {
			if ($x[$p]!="") {
				$delll=$x[$p];
				//echo $dcrs.'/pic/' . "$delll";
				if ($delll!="" && (strpos($delll,"..")===false) && $delll!='.' && $delll!="no.jpg" && $delll!="no.psd") {
					@unlink($dcrs.'/pic/' . "$delll");
				}
			}
		}
}

if ($CHANGEALLTOUPPER=="YES") {
	$x=fso_listfile("$dcrs/pic");
        for ($p = 0; $p <= count($x); $p++) {
			if ($x[$p]!="") {
				$delll=$x[$p];
				//echo $dcrs.'/pic/' . "$delll";
				if ($delll!="" && (strpos($delll,"..")===false) && $delll!='.' && $delll!="no.jpg" && $delll!="no.psd") {
					rename($dcrs.'/pic/' . "$delll",$dcrs.'/pic/' . strtoupper("$delll"));
				}
			}
		}
}

if ($CHANGEALLTOLOWER=="YES") {
	$x=fso_listfile("$dcrs/pic");
        for ($p = 0; $p <= count($x); $p++) {
			if ($x[$p]!="") {
				$delll=$x[$p];
				//echo $dcrs.'/pic/' . "$delll";
				if ($delll!="" && (strpos($delll,"..")===false) && $delll!='.' && $delll!="no.jpg" && $delll!="no.psd") {
					rename($dcrs.'/pic/' . "$delll",$dcrs.'/pic/' . strtolower("$delll"));
				}
			}
		}
}
if ($delete!="") {
	$delll="$delete";
	if ($delll!="" && (strpos($delll,"..")===false)) {
		@unlink($dcrs.'/pic/' . "$delll");
	}

}
?><BR><TABLE align=center width=550>
<TR>
	<TD><?php 
// Note that !== did not exist until 4.0.0-RC2
$x=fso_listfile("$dcrs/pic");
//print_r($x);
$hits=count($x);
if ($startrow=="") {
	$startrow=0;
}
$perpage=getval("pagesplit","pagelength");
$url="index.php?a=a";

$r_start=$startrow;
$r_end=$startrow+$perpage;



?> 
<TABLE width=770 align=center bgcolor=888888 cellpadding=1 cellspacing=1 border=0>
<TR  bgcolor=f2f2f2>
	<TD width=5% align=center><B><?php  echo getlang("ลำดับ::l::No."); ?></B></TD>
	<TD align=center><B><?php  echo getlang("ชื่อไฟล์::l::Filename"); ?></B></TD>
	<TD width=15% align=center><B>-</B></TD>
	<TD width=15% align=center><B><?php  echo getlang("ลบ::l::Delete"); ?></B></TD>
</TR>
<?php 
        for ($p = $startrow; $p <= $r_end; $p++) {
			if ($x[$p]!="") {
			?>	
	<TR  bgcolor=ffffff class=table_dr>
		<TD align=center><B><?php  echo number_format($p+$r_start+1);?></B></TD>
		<TD><?php  echo $x[$p];?>&nbsp;<A HREF="<?php echo $dcrURL?>/pic/<?php  echo $x[$p]?>" target=_blank><IMG SRC="../neoimg/View.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle style="border: 0px; width: 16; height: 16;" ></A>
		<?php 
		html_photofilter("pic/".$x[$p],"",true)
		?></TD>
		<INPUT TYPE="hidden" name="marcinfo" value="<?php  echo ($rec);?>" ID='<?php  echo $urid;?>'>
		<INPUT TYPE="hidden" name="fromsv" value="<?php  echo ($s[name]);?>">
		<TD align=center><?php 
			if (strtolower($x[$p])!="no.jpg" && strtolower($x[$p])!="no.psd" ) {
				$forcheck=substr($x[$p],strlen($local_pre),strlen($x[$p])-(strlen($local_pre)+strlen($local_suf)));
				//echo "[$forcheck]";
				$forchecks=tmq("select * from member where UserAdminID='$forcheck' ");
				if (tmq_num_rows($forchecks)!=1) {
					?><B style="color: red;" class=smaller2>Please check member barcode=<?php  echo $forcheck?></B><?php 
				}
			}?>&nbsp;</TD>
		<TD align=center><B><?php 
			if (strtolower($x[$p])!="no.jpg" && strtolower($x[$p])!="no.psd" ) {
				
				?><A HREF="index.php?startrow=<?php  echo $startrow?>&delete=<?php  echo $x[$p]?>" onclick="return confirm('<?php  echo getlang("กรุณายืนยัน::l::Please Confirm"); ?>')"><IMG SRC="../neoimg/Delete.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle ></A> <?php }?></B></TD>
	</TR>
<?php 
			}
        }
echo pageengine($page,$hits,$url);
?>
</TABLE>
<BR><BR>
<HR>
<?php  echo getlang("<B>หมายเหตุ</B> รายการดังกล่าวเป็นไฟล์ที่มีผู้นำไปไว้ที่โฟลเดอร์ /pic/ <BR>
ซึ่งไม่เกี่ยวกับตัวโปรแกรม ULIBm และไม่อยู่ในความรับผิดชอบของทีมงานผู้พัฒนาฯ<BR>
ท่านสามารถคัดลอกไฟล์ไปยังโฟลเดอร์ดังกล่าวเอง หรือ <A HREF='UPLOADv2.php'>ทำผ่านแบบฟอร์มที่เตรียมไว้</A><BR>
ไฟล์ชื่อ no.jpg เป็นไฟล์มาตรฐานสำหรับผู้ที่ไม่มีรูป ไม่สามารถลบได้ แต่ สามารถอัพโหลดทับด้วยไฟล์ใหม่ได้
::l::<B>Note</B> all files above is in folder /pic/ which uploaded by ULIB customers<BR>
which not in responsive by ULIB developer team.<BR>
Files can upload photos mannually or upload by <A HREF='UPLOADv2.php'>provided form</A>.<BR>
File name no.jpg is a default file for member who not has own photo , this file cannot be delete but replaceable."); ?><hr noshade width=780>
<a href="index.php?deleteall=YES" onclick="return confirm('Please Confirm')" style="color:red">
<?php 
 echo getlang("คลิกที่นี่เพื่อลบไฟล์ทั้งหมด::l::Click here to delete all photo");
?>
</a><br />
<a href="index.big.php" style="color:darkred">
<?php 
 echo getlang("คลิกที่นี่เพื่อแสดงเฉพาะภาพที่มีขนาดใหญ่กว่าปกติ::l::Click here see too big photo");
?>
</a><br />
<a href="index.php?CHANGEALLTOUPPER=YES" style="color:darkred">
<?php 
 echo getlang("เปลี่ยนชื่อไฟล์ทั้งหมดเป็นตัวอักษรพิมพ์<u>ใหญ่</u>::l::Change all file name to <u>UPPERCASE</u>");
?>
</a><br />
<a href="index.php?CHANGEALLTOLOWER=YES" style="color:darkred">
<?php 
 echo getlang("เปลี่ยนชื่อไฟล์ทั้งหมดเป็นตัวอักษรพิมพ์<u>เล็ก</u>::l::Change all file name to <u>LOWERCASE</u>");
?>
</a>
</TD>
</TR>
</TABLE><BR><?php 
foot();
?>