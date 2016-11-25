<?php 
	; 
ini_set("max_execution_time",600);
        include ("../inc/config.inc.php");
		head();
	$_REQPERM="importer_indexword";
	$tmp=mn_lib();
	pagesection($tmp);
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
//echo("\$sep_rec=\"$sep_rec\";");

$file=barcodeval_get("importer_indexword-file");
$sep_rec=barcodeval_get("importer_indexword-sep_rec");
$fpath=$dcrs."/_input/import/$file";
//echo $fpath;
if (!file_exists($fpath)) {
	?><CENTER><?php  echo getlang("หาไฟล์ที่ท่านเลือกไม่พบ กรุณา <A HREF='index.php'>คลิกที่นี่</A> เพื่อกลับไปเลือกไฟล์อีกครั้ง::l::Your choosed file not found <A HREF='index.php'>please click here</A> to continue"); ?></CENTER><?php 
		die;
}
$sep_rec=stripslashes($sep_rec);
eval("\$sep_rec=\"$sep_rec\";");

/*
eval("\$sep_rec=\"$sep_rec\";");
eval("\$sep_field=\"$sep_field\";");
eval("\$cover_field=\"$cover_field\";");
*/
// Note that !== did not exist until 4.0.0-RC2
$Stime=time();

$reclist=file_get_contents($fpath);
$reclist=explode($sep_rec,$reclist);
$reclistcount=count($reclist);
if (count($reclist)<=2) {
	echo "Cannot find any record from your specification";
	die;
}
$importdt=time();

$reclistcount=count($reclist);

if ($reclistcount>50000) {
	$reclistcount=50000;
}


	for ($i=0;$i<=$reclistcount;$i++) {
		$word=trim($reclist[$i]);
		if ($word!="") {
			indexword_insert("$word",$importdt,0,$importdt,"YES");
		}
	}


$Etime=time();

?> 

</TABLE>
<BR><CENTER><?php  echo getlang("การนำเข้าเรียบร้อย นำเข้า ::l::Import successfull "); ?><?php  echo number_format($i);?> <?php  echo getlang("รายการ โดยใช้เวลา::l:: records in"); ?>  <?php  echo number_format(($Etime-$Stime));?> <?php  echo getlang("วินาที::l::second"); ?><BR>

</CENTER>
<BR><BR><TABLE align=center>
<TR>
	<TD></TD>
</TR>
</TABLE>
<BR><?php 
foot();
?>