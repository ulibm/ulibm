<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="importer_mem";
        mn_lib();
			pagesection(getlang("นำเข้าข้อมูลสมาชิก::l::Import Member Records"));
$fpath=$dcrs."/_input/import/$file";
//echo $fpath;
if (!file_exists($fpath)) {
	?><CENTER><?php  echo getlang("หาไฟล์ที่ท่านเลือกไม่พบ กรุณา <A HREF='index.php'>คลิกที่นี่</A> เพื่อกลับไปเลือกไฟล์อีกครั้ง::l::Your choosed file not found <A HREF='index.php'>please click here</A> to continue"); ?></CENTER><?php 
		die;
}
?>
<BR>
<CENTER><?php  echo getlang("ด้านล่างเป็นรายการตัวอย่างการดึงข้อมูลจากไฟล์ที่เลือก ด้วยรายละเอียดที่คุณกรอก <BR>
หากมีข้อผิดพลาดหรือต้องการแก้ไข กรุณาคลิก Back::l::Following data was extracted from your file with your entered information<BR>
if need to edit or recorrect some value  click Back"); ?>
</CENTER><BR><TABLE align=center width=550>
<?php 
$sep_rec=stripslashes($sep_rec);
//echo("\$sep_rec=\"$sep_rec\";");
barcodeval_set("importer_mem-mem_type",$mem_type);
barcodeval_set("importer_mem-libsite",$libsite);
barcodeval_set("importer_mem-to_room",$to_room);
barcodeval_set("importer_mem-sep_rec",$sep_rec);
barcodeval_set("importer_mem-sep_field",$sep_field);
barcodeval_set("importer_mem-cover_field",$cover_field);
barcodeval_set("importer_mem-file",$file);
eval("\$sep_rec=\"$sep_rec\";");
//echo ("\$sep_rec=$sep_rec;");
eval("\$sep_field=\"$sep_field\";");
eval("\$cover_field=\"$cover_field\";");
//echo("\$cover_field=\"$cover_field\";");

// Note that !== did not exist until 4.0.0-RC2

$reclist=fso_file_importmelt($fpath,10,50000,$sep_rec,$sep_field,$cover_field);

$reclistcount=count($reclist);
if (count($reclist)<=2) {
	echo "Cannot find any record from your specification";
	die;
}

?> 

</TABLE>
<BR>
<TABLE width=770 align=center border=0 cellpadding=1 cellspacing=1  bgcolor=000000>
<TR  bgcolor=f2f2f2>
	<TD></TD>
<?php 
$fieldcount=count($reclist[1]);
if ($fieldcount>30) {
	$fieldcount=30;
}
for ($i=0;$i<=$fieldcount;$i++) {
	echo "<TD align=center><B>data$i</B></TD>";
}
?>
</TR>
<?php 
for ($i=0;$i<=$reclistcount;$i++) {
?>
<TR  bgcolor=ffffff>
	<TD></TD>
<?php 
for ($j=0;$j<=count($reclist[$i]);$j++) {
	echo "<TD><nobr>".trim($reclist[$i][$j],$cover_field)."</nobr></TD>";
}
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
</TABLE><CENTER><BR><B><?php  echo getlang("หมายเหตุ::l::Note"); ?>.</B> <BR>
<?php  echo getlang("1. เฉพาะ 30 ฟิลด์แรกเท่านั้นที่จะทำการดึงเข้าฐานข้อมูลเพื่อการนำเข้าข้อมูล::l::1. Only first 30 fields will import to import process"); ?>,<BR>
<?php  echo getlang("2. ในการนำเข้าข้อมูลแต่ละครั้ง จะทำการนำเข้าเพียง 50,000 รายการ.::l::2. Only first 5,000 records will be import to import process"); ?>
<BR></CENTER>
<?php 
foot();
?>