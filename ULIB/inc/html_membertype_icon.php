<?php  
function html_membertype_icon($type,$size=14) {
global $dcrURL;
	$s=tmq("select * from member_type where type='$type' ");
	$r=tmq_fetch_array($s);
	$col=$r[col];
	$name=getlang($r[descr]);
	if (trim($col)=="") {
	  $col="000000";
	}
	  $col=trim($col," #");
	  $col="#".$col;
		return "<img src='$dcrURL"."neoimg/membertype.png' TITLE='$name' style='display: inline; background-color: $col; margin-right: 2px;' border=0 width=$size height=$size>";
}
?>