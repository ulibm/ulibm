<?php 
$_REQPERM="acqxls2";
head();
loginchk();

?> <CENTER>
<A href="index.php">หน้าหลัก</A> :
<A href="search.php">ค้นหาข้อมูลทรัพยากร</A> : 
<A href="UPLOAD.php">นำเข้าไฟล์ Excel</A> 
<?php 
if ($pid!="") {
	?> : <A href="summary.php?pid=<?php  echo $pid?>">ข้อมูลสรุป</A> 
<?php 
}
?>

</CENTER>