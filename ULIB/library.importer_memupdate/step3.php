<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="importer_memupdate";
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
<CENTER><?php  echo getlang("ระบบกำลังเริ่มทำการนำเข้าข้อมูล::l::Starting import data to import process"); ?> <BR>...
<BR>...<BR>...
</CENTER><BR><TABLE align=center width=550>
<?php 
$sep_rec=stripslashes($sep_rec);
//echo("\$sep_rec=\"$sep_rec\";");
$sep_rec=barcodeval_get("importer_memupdate-sep_rec");
$sep_field=barcodeval_get("importer_memupdate-sep_field");
$cover_field=barcodeval_get("importer_memupdate-cover_field");
$file=barcodeval_get("importer_memupdate-file");
$fpath=$dcrs."/_input/import/$file";
//echo $fpath;
if (!file_exists($fpath)) {
	?><CENTER><?php  echo getlang("หาไฟล์ที่ท่านเลือกไม่พบ กรุณา <A HREF='index.php'>คลิกที่นี่</A> เพื่อกลับไปเลือกไฟล์อีกครั้ง::l::Your choosed file not found <A HREF='index.php'>please click here</A> to continue"); ?></CENTER><?php 
		die;
}

/*
eval("\$sep_rec=\"$sep_rec\";");
eval("\$sep_field=\"$sep_field\";");
eval("\$cover_field=\"$cover_field\";");
*/
// Note that !== did not exist until 4.0.0-RC2
$Stime=time();

$reclist=fso_file_importmelt($fpath,5000,10000000,$sep_rec,$sep_field,$cover_field);

$reclistcount=count($reclist);
tmq("delete from importer_memupdate_tmp");
	for ($i=0;$i<=$reclistcount;$i++) {
		$fieldcount=count($reclist[$i]);
		if ($fieldcount>30) {
			$fieldcount=30;
		}
		$s="insert into importer_memupdate_tmp  set id='' ";
		for ($j=1;$j<=$fieldcount;$j++) {
			$tmp=$reclist[$i][($j-1)];
			$s.=" , data$j='".addslashes($tmp)."' ";
		}
		tmq( $s);

	}


$Etime=time();

?> 

</TABLE>
<BR><CENTER>
<?php  echo getlang("การนำเข้าเรียบร้อย นำเข้า ::l::Import successfull "); ?><?php  echo number_format($i);?> <?php  echo getlang("รายการ โดยใช้เวลา::l:: records in"); ?>  <?php  echo number_format(($Etime-$Stime));?> <?php  echo getlang("วินาที::l::second"); ?><BR>

</CENTER>
<BR><BR><TABLE align=center>
<TR>
	<TD><INPUT TYPE="reset" value=" Next " onclick="self.location='step4.php' "></TD>
</TR>
</TABLE>
<BR><?php 
foot();
?>