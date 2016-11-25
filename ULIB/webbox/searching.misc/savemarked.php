<?php  
;
include("../../inc/config.inc.php");


if ($clear=='yes') {
	session_destroy();
	;
}
if (count($marksave)!=0) {
	foreach ($marksave as $value) {
		$_SESSION['marked'][]=$value;
		$HTTP_SESSION_VARS['marked'][]=$value;
	}

} 
//print_r($_SESSION);
$_SESSION['marked']=@array_unique($_SESSION['marked']);
if (count($_SESSION['marked'])!=0 && is_array($_SESSION['marked'])) {
?><style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style><body bgcolor=#E6EEFF ><FONT SIZE="2" COLOR="">&nbsp;<A HREF="exportmarked.php" target=S_RESULT style="color: #3300FF"><?php echo getlang("ส่งออกรายการที่บันทึกไว้::l::Export Marked Items"); ?></A>(<?php echo count($_SESSION['marked']);?>). / <A HREF="savemarked.php?clear=yes" style="color:#3366FF"><?php echo getlang("ลบทั้งหมด::l::Clear"); ?> </A></FONT>
<?php  
	
}?>