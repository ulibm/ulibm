<?php 
function ymd_mkdt($XXdat,$XXmon,$XXyea) {
	$res= mktime(0, 0, 0, $XXmon, $XXdat, $XXyea);
	if ($res==false) {
		 die("ymd_mkdt error (mktime(0, 0, 0, $XXmon, $XXdat, $XXyea);)<br>" . getlang("กำหนดวันที่ไม่ถูกต้อง::l::Invalid date"));
	} 
	return $res;
}
?>