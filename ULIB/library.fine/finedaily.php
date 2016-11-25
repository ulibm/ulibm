<?php 
;
     include("../inc/config.inc.php");
	 head();
	 include("_REQPERM.php");
	 mn_lib();

	pagesection("รายงานการรับชำระค่าปรับ แยกตามสาขาห้องสมุด");

include("local_dispfinebylib.php");
include("local_fineform.php");

	local_dispfinebylib("$LIBSITE","ค่าปรับรายวันของ ".get_libsite_name($LIBSITE),$Fdat,$Fmon,$Fyea);


	 ?>
<BR>

<?php 
foot();
?>