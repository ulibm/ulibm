<?php 
function html_displayrqitem($mid,$place) {
	global $dcrURL;
	//echo "[$dcrURL]";
	$place=tmq("select * from media_place where code='$place' ");
	$place=tmq_fetch_array($place);
	if ($place[isrq]!="yes") {
		return;
	}
	$cmid=tmq("select * from checkout where mediaId='$mid' ");
	if (tmq_num_rows($cmid)!=0) {
		return;
	}
	$cmid=tmq("select * from request_list where itemid='$mid' ");
	if (tmq_num_rows($cmid)!=0) {
		return;
	}
	echo "<BR>&nbsp;<A target=_top  HREF='$dcrURL"."requestform.php?ID=$mid'><img align=absmiddle border=0 src='$dcrURL"."neoimg/Right16.gif'> ".getlang("ขอยืม::l::Request")."</A>";
}
?>