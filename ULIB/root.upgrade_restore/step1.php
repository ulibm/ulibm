<?php 
set_time_limit(600);
	; 
		$ui_passwd=stripslashes($ui_passwd);
        include ("../inc/config.inc.php");
		head();
        mn_root("upgrade_restore");
			pagesection(getlang("Restore database"));
			filelogs("RESTOREBACKUP","$file");
//echo $fpath;
$i=0;
$buff="";
$handle = fopen("$dcrs/_output/$file", "rb");
$expact="#%%";
while (!feof($handle)) {
  $buff .= fread($handle, 1);
  $decus=substr($buff,-3);
  if ($decus==$expact) {
	  $buff=trim($buff,$expact);
	tmq($buff);
	$i++;
	$buff="";
  }
}
?><CENTER>
<?php  echo getlang("เรียบร้อย ดำเนินการจำนวน $i รายการ::l::DONE,  ecexcuted  $i  times"); ?></CENTER><BR><BR>
<?php  foot();
?>