<?php 
$_REQPERM="acqxls_main";
head();
mn_lib();
?> <CENTER>
<?php if (library_gotpermission("acqxls_main")) { ?>
<A href="index.php" class=a_btn>หน้าหลัก</A> :
<?php  } ?>
<?php if (library_gotpermission("acqxls_search")) { ?>
<A href="search.php" class=a_btn>ค้นหาข้อมูลทรัพยากร</A> : 
<?php  } ?>
<?php if (library_gotpermission("acqxls_import")) { ?>
<A href="UPLOAD.php" class=a_btn>นำเข้าไฟล์ Excel</A> 
<?php  } ?>
<?php 
if (library_gotpermission("acqxls_summary") && $pid!="") {
	?> : <A href="summary.php?pid=<?php  echo $pid?>" class=a_btn>ข้อมูลสรุป</A> 
<?php 
}
?>

</CENTER>