<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		include("_REQPERM.php");
        mn_lib();
			pagesection(getlang("นำเข้าข้อมูลเพื่อบาร์โค้ด::l::Import data to Barcode-on-demand"));
$fpath=$dcrs."/_input/xpbc/$file";
//echo $fpath;
if (!file_exists($fpath)) {
	?><CENTER>หาไฟล์ที่ท่านเลือกไม่พบ กรุณา <A HREF="index.php">คลิกที่นี่</A> เพื่อกลับไปเลือกไฟล์อีกครั้ง</CENTER><?php 
		die;
}
?>
<BR>
<CENTER><?php  echo getlang("ด้านล่างเป็นรายการตัวอย่างการดึงข้อมูลจากไฟลดืที่เลือก ด้วยรายละเอียดที่คุณกรอก <BR>
หากมีข้อผิดพลาดหรือต้องการแก้ไข กรุณาคลิก Back::l::Following data was extracted from your file with your entered information<BR>
if need to edit or recorrect some value  click Back"); ?>
</CENTER><BR><TABLE align=center width=550>
<?php 
$sep_rec=stripslashes($sep_rec);
//echo("\$sep_rec=\"$sep_rec\";");
barcodeval_set("importer_xpbc-sep_rec",$sep_rec);
barcodeval_set("importer_xpbc-file",$file);
eval("\$sep_rec=\"$sep_rec\";");
//echo ("\$sep_rec=$sep_rec;");
//echo("\$cover_field=\"$cover_field\";");

// Note that !== did not exist until 4.0.0-RC2

$reclist=file_get_contents($fpath);
$reclist=explode($sep_rec,$reclist);
$reclistcount=count($reclist);
if (count($reclist)<=2) {
	echo "Cannot find any record from your specification";
	die;
}

if ($reclistcount>30) {
	$reclistcount=30;
}
?> 

</TABLE>
<BR>
<TABLE width=770 align=center border=0 cellpadding=1 cellspacing=1  bgcolor=000000>
<TR  bgcolor=f2f2f2>
	<TD></TD>
	<TD></TD>
</TR>
<?php 
for ($i=0;$i<=$reclistcount;$i++) {
?>
<TR  bgcolor=ffffff>
	<TD></TD>
<?php 
	echo "<TD><nobr>".trim($reclist[$i])."</nobr></TD>";
?>
</TR>
<?php 
}
?>
</TABLE>
<BR><BR><TABLE align=center>
<TR>
	<TD><INPUT TYPE="reset" value=" Back " onclick="self.location='step1.php?file=<?php  echo $file?>' "></TD>
	<TD><INPUT TYPE="reset" value=" Next " onclick="self.location='step3.php' "></TD>
</TR>
</TABLE><BR><CENTER> <?php 
echo getlang("มีรายการคำในไฟล์นี้จำนวน ::l::There are ");
echo number_format(count($reclist));?> <?php 
echo getlang(" คำ::l:: words in this file.");

?><BR>
<?php  echo getlang(" ในการนำเข้าข้อมูลแต่ละครั้ง จะทำการนำเข้าเพียง 5,000 รายการ.::l::Only first 5,000 records will be import to import process"); ?></CENTER><BR>
<?php 
foot();
?>