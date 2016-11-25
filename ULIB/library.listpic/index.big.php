<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="listmempic";
        mn_lib();

			pagesection(getlang("ภาพที่มีขนาดใหญ่กว่าปกติ::l::too big photo"));
			
if ($resizedown=="YES") {
	$x=fso_listfile("$dcrs/pic",30);
        for ($p = 0; $p <= count($x); $p++) {
			if ($x[$p]!="") {
				$delll=$x[$p];
				//echo $dcrs.'/pic/' . "$delll";
				if ($delll!="" && (strpos($delll,"..")===false) && $delll!='.' && $delll!="no.jpg" && $delll!="no.psd") {
        $ext=explode('.',$delll);
        $ext=$ext[count($ext)-1];
        $ext=strtolower($ext);
					fso_image_fixsize($dcrs.'/pic/' . "$delll",$ext,200);
				}
			}
		}
}

?><BR><TABLE align=center width=550>
<TR>
	<TD><?php 
// Note that !== did not exist until 4.0.0-RC2
$x=fso_listfile("$dcrs/pic",30);
//print_r($x);
$hits=count($x);
if ($startrow=="") {
	$startrow=0;
}
$perpage=getval("pagesplit","pagelength");
$url="index.big.php?a=a";

$r_start=$startrow;
$r_end=$startrow+$perpage;



?> 
<TABLE width=770 align=center bgcolor=888888 cellpadding=1 cellspacing=1 border=0>
<TR  bgcolor=f2f2f2>
	<TD width=5% align=center><B><?php  echo getlang("ลำดับ::l::No."); ?></B></TD>
	<TD align=center><B><?php  echo getlang("ชื่อไฟล์::l::Filename"); ?></B></TD>
	<TD width=15% align=center><B><?php  echo getlang("ลบ::l::Delete"); ?></B></TD>
</TR>
<?php 
  for ($p = $startrow; $p <= $r_end; $p++) {
			if ($x[$p]!="") {
			?>	
	<TR  bgcolor=ffffff>
		<TD align=center><B><?php  echo number_format($p+$r_start+1);?></B></TD>
		<TD><?php  echo $x[$p];?>&nbsp;<A HREF="<?php echo $dcrURL?>/pic/<?php  echo $x[$p]?>" target=_blank><IMG SRC="../neoimg/View.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle style="border: 0px; width: 16; height: 16;" ></A></TD>
		<INPUT TYPE="hidden" name="marcinfo" value="<?php  echo ($rec);?>" ID='<?php  echo $urid;?>'>
		<INPUT TYPE="hidden" name="fromsv" value="<?php  echo ($s[name]);?>">
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
<?php 
echo getlang("แสดงเฉพาะไฟล์ที่ขนาดใหญ่กว่า 30kb::l::Only files size over 30kb.");
?>
<br />
<a href="index.big.php?resizedown=YES" style="color:darkred">
<?php 
 echo getlang("ปรับขนาดให้เล็กอัตโนมัติ::l::Automatically resize-down");
?>
</a><br />

<a href="index.php">
<?php 
 echo getlang("กลับ::l::Back");
?>
</a>
</TD>
</TR>
</TABLE><BR><?php 
foot();
?>