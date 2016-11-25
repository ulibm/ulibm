<?php 
function form_pickdate_str($formname) {
	global $thaimonstr;
	eval("global $$formname"."_dat;
	global $$formname"."_mon;
	global $$formname"."_yea;

	global $$formname"."_hou;
	global $$formname"."_min;
	global $$formname"."_sec;

	\$dt_dat = $$formname"."_dat;
	\$dt_mon =  $$formname"."_mon;
	\$dt_yea =  $$formname"."_yea;

	\$dt_hou =  $$formname"."_hou;
	\$dt_min =  $$formname"."_min;
	\$dt_sec =  $$formname"."_sec;");

	$str="";
	if ($dt_dat=="") {
		$str.= " ทุกวัน ";
	} else {
		$str.= " วันที่ $dt_dat ";
	}
	if ($dt_mon=="") {
		$str.= " ทุกเดือน ";
	} else {
		$str.= " เดือน ".$thaimonstr[$dt_mon]." ";
	}
	if ($dt_yea=="") {
		$str.= " ทุกปี ";
	} else {
		$str.= " ปี $dt_yea ";
	}
	return $str;
}
?>