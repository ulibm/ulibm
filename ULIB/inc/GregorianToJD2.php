<?php  //พ
function GregorianToJD2 ($month,$day,$year) {
	if ($month > 2) {
	   $month = $month - 3;
	} else {
	   $month = $month + 9;
	  $year = $year - 1;
	}
	$c = floor($year / 100);
	$ya = $year - (100 * $c);
	$j = floor((146097 * $c) / 4);
	$j += floor((1461 * $ya)/4);
	$j += floor(((153 * $month) + 2) / 5);
	$j += $day + 1721119;
	return $j;
}
?>