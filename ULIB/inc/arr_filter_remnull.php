<?php // พ
function arr_filter_remnull($a) {
	if (!is_array($a)) {
		return Array();
	}
	if (!function_exists("local_arr_filter_remnull")) {
		function local_arr_filter_remnull($a) {
			//echo "[".ord($a[0])."-".strlen($a)."] ** ";
			return $a!="" && $a!=ord(0);
		}
	}
	@reset($a);
	//echo "[$a]";
	return array_filter($a, "local_arr_filter_remnull");
}
?>