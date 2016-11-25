<?php // พ
function form_pickdt_get($formname) {
	////func(" form_pickdt_get($formname)");
	//echo" [<I>$formname</I>] ";
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
	//echo "form_pickdt_get-mktime($dt_hou, $dt_min, $dt_sec, $dt_mon, $dt_dat, $dt_yea);";
	if (floor($dt_yea)==0) {
		return 0;
	}
	$res=@mktime($dt_hou, $dt_min, $dt_sec, $dt_mon, $dt_dat, $dt_yea);
	if ($res<=0) {
		$res=0;
	}
	//echo "[mktime($dt_hou, $dt_min, $dt_sec, $dt_mon, $dt_dat, $dt_yea)]";
	return $res;
}
?>