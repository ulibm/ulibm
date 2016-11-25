<?php 
set_time_limit(0);
header("Content-Type: text/html; charset=utf-8");
ob_start();

include("../../inc/config.inc.php");
include("./_conf.php");
include("../enc.php");

$prevlang=$_SESSION['lang_control_val'];
$_SESSION['lang_control_val']="en";

		$itd=tmq("select * from media_mid where pid='$bibid' ");
		$itdok=0;
		$itdcheckedout=0;
		while ($itdr=tmq_fetch_array($itd)) {
					$itdchk=tmq("select id from checkout where mediaId='$itdr[bcode]' and allow='yes' and returned='no' ");
					if (tmq_num_rows($itdchk)==0) {
							$itdok++;
					} else {
							$itdcheckedout++;
					}
		}
		if (($itdok+$itdcheckedout)==0) {
			 $itdstr="str_noitemforservice";
		} else {
			if ($itdok==0 && $itdcheckedout!=0) {
			 $itdstr="str_allitemnotavai ($itdcheckedout str_item)"; 
			}
			if ($itdok!=0 && $itdcheckedout==0) {
			 $itdstr="str_allitemavai (str_has $itdok str_item)"; 
			}
			if ($itdok!=0 && $itdcheckedout!=0) {
			 $itdstr="str_has $itdok str_avaiable4serv str_and $itdcheckedout ไอเทมถูกยืม (str_has ".($itdok+$itdcheckedout)." str_item)"; 
			}
		}
		$itdstr=trim($itdstr);
		echo $itdstr;
	
	$_SESSION['lang_control_val']=$prevlang;
	$tmp=ob_get_contents();
	ob_end_clean();

	echo myencode($tmp);

?>