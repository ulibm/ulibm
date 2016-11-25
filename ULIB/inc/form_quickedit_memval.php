<?php // พ
function form_quickedit_memval() {

tl("form_quickedit_memval","select","*");
tl("form_quickedit_memval","from","member_customfield");
tl("form_quickedit_memval","where","1");
tl("form_quickedit_memval","order","fid","ASC");

	$cust=tl("form_quickedit_memval","e");
	while ($custr=tfa($cust)) {
		eval("global \$_POST;");
		eval("global \$$custr[fid];");
		eval("\$_POST[$custr[fid]]=\$$custr[fid];");
		if ($custr[ftype]=="date") {
			eval("\$$custr[fid]=form_pickdt_get('$custr[fid]');");
			eval("\$_POST[$custr[fid]]=form_pickdt_get('$custr[fid]');");
		}
		$tmpchk=substr($custr[ftype],0,10);
		if ($tmpchk=="multilist:") {
			eval("\$$custr[fid]=@implode(',',\$$custr[fid]);");
			eval("\$_POST[$custr[fid]]=\$$custr[fid];");
			//echo("\$_POST[$custr[fid]]=\$$custr[fid];");die;
			//echo("\$_POST[$custr[fid]]=\$$custr[fid];");
		}
	}
}
?>