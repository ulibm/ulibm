<?php // พ
function form_pickdt_len_get($formname) {
	////func(" form_pickdt_len_get($formname)");
	eval("global $$formname"."_day;
	global $$formname"."_hou;
	global $$formname"."_min;
	global $$formname"."_sec;

	\$dt_day = $$formname"."_day;
	\$dt_hou =  $$formname"."_hou;
	\$dt_min =  $$formname"."_min;
	\$dt_sec =  $$formname"."_sec;");

	$res=0;
	$res+=$dt_day*60*60*24;
	$res+=$dt_hou*60*60;
	$res+=$dt_min*60;
	$res+=$dt_sec;

	return $res;
}
?>