<?php // พ
function percent_cal($max,$me) {
	//echo " percent_cal($max,$me)";
	if (round($me)==0) {
		return 0;
	}
	if (round($max)==0) {
		return 0;
	}
	$percent=round(($me*100)/$max,2);
	return $percent;
}
?>