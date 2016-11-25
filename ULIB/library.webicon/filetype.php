<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="webicon-filetype";
        $tmp=mn_lib();
$dir="neoimg/filetype/";
			pagesection(getlang($tmp));

		$purename=$_FILES['Filedata']['name'];
if ($purename!="") {
    $ext=explode('.',$purename);
    $ext=$ext[count($ext)-1];
    $ext=strtolower($ext);
		if ($ext!="gif" && $ext!="jpg" && $ext!="png" && $ext!="jpeg") {
			 die("extension not allowed ($ext)");
		}
		///$newname=date("Ymd_His")."_".($_FILES['Filedata']['name']);
		$newname=randid().".".$ext;
		$uploadfile = $dcrs.$dir . $purename;
	 	filelogs("uploadlog","$dir-$purename");		
		
		if (move_uploaded_file($_FILES['Filedata']['tmp_name'], $uploadfile)) {
			//print "อัพโหลดไฟล์เรียบร้อย. ";
			html_dialog("Uploaded","$purename");
		} else {
			html_dialog("Upload Error","$purename");
		}
}		


if ($delete!="") {
	$delll="$delete";
	if ($delll!="" && (strpos($delll,"..")===false)) {
		@unlink($dcrs.$dir . "$delll");
	}

}
?><BR><TABLE align=center width=550>
<TR>
	<TD><?php 
// Note that !== did not exist until 4.0.0-RC2
//echo("$dcrs"."$dir");
$x=fso_listfile("$dcrs"."$dir");
//print_r($x);
$hits=count($x);
if ($startrow=="") {
	$startrow=0;
}
$perpage=getval("pagesplit","pagelength");
$url="$PHP_SELF?a=a";

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
	<TR  bgcolor=ffffff>
		<TD align=center><B><?php  echo number_format($p+$r_start+1);?></B></TD>
		<TD><?php  echo $x[$p];?>&nbsp;<A HREF="<?php echo $dcrURL?>/<?php  echo $dir;?>/<?php  echo $x[$p]?>" target=_blank><IMG SRC="../neoimg/View.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle style="border: 0px; width: 16; height: 16;" ></A></TD>
		<INPUT TYPE="hidden" name="marcinfo" value="<?php  echo ($rec);?>" ID='<?php  echo $urid;?>'>
		<INPUT TYPE="hidden" name="fromsv" value="<?php  echo ($s[name]);?>">
		<TD align=center><?php 
			if (strtolower($x[$p])!="no.jpg" && strtolower($x[$p])!="no.psd" ) {
				?><img src="<?php echo $dcrURL?>/<?php  echo $dir;?>/<?php  echo $x[$p]?>" border=0 width=16><?php 
				?><img src="<?php echo $dcrURL?>/<?php  echo $dir;?>/<?php  echo $x[$p]?>" border=0 width=32><?php 
				?><img src="<?php echo $dcrURL?>/<?php  echo $dir;?>/<?php  echo $x[$p]?>" border=0 width=48><?php 
			}?>&nbsp;</TD>
		<TD align=center><B><?php 
			if (strtolower($x[$p])!="no.jpg" && strtolower($x[$p])!="no.psd" && strtolower($x[$p])!="default.png" ) {
				
				?><A HREF="<?php  echo $PHP_SELF;?>?startrow=<?php  echo $startrow?>&delete=<?php  echo $x[$p]?>" onclick="return confirm('<?php  echo getlang("กรุณายืนยัน::l::Please Confirm"); ?>')"><IMG SRC="../neoimg/Delete.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle ></A> <?php }?></B></TD>
	</TR>
<?php 
			}
        }
echo pageengine($page,$hits,$url);
?>
</TABLE>
<BR><BR>
<HR>
<?php  echo getlang("<B>หมายเหตุ</B> รายการดังกล่าวเป็นไฟล์ที่มีผู้นำไปไว้ที่โฟลเดอร์ $dir <BR>
ซึ่งไม่เกี่ยวกับตัวโปรแกรม ULibM และไม่อยู่ในความรับผิดชอบของทีมงานผู้พัฒนาฯ<BR>
ท่านสามารถคัดลอกไฟล์ไปยังโฟลเดอร์ดังกล่าวเอง หรือ ทำผ่านแบบฟอร์มที่เตรียมไว้ที่ด้านล่าง
::l::<B>Note</B> all files above is in folder $dir which uploaded by ULIB customers<BR>
which not in responsive by ULibM developer team.<BR>
Files can upload photos mannually or upload by the form below."); ?><hr noshade width=780>
<br />
</TD>
</TR>
</TABLE><BR>

<FORM METHOD=POST ACTION="<?php  echo $PHP_SELF?>" enctype="multipart/form-data">
<INPUT TYPE="hidden" NAME="uploadDir" value="yes">
<INPUT TYPE="hidden" NAME="redirback" value="yes">
	 <TABLE width=300 align=center>
			 <TR>
		<TD>
		
		<span ID="uploadbtn"><INPUT TYPE="file" NAME="Filedata" 
		onchange="submitchk(this)"
		onkeydown="return false;"></span></TD>
		<!-- <TD><INPUT TYPE="submit" value=" Upload "></TD> -->
	 </TR>
	 </TABLE>
	 </FORM>
<script type="text/javascript">
<!--
	function submitchk(wh) {
	if (wh.value=="") {
		return;
	}
	document.forms[0].submit();
}

//-->
</script>
<?php 
foot();
?>