<?php 
function local_setarrive($id) {
	global $useradminid;
	global $LIBSITE;
	$s=tmq("select * from itemtransit_sub where id='$id' and status='new' ");
	$now=time();
	if (tnr($s)!=1) {
		html_dialog("Error","ไม่พบ ID=$id หรือรายการนี้ถูกบันทึกรับแล้ว");
		return;
	}
	$s=tfa($s);
	$smain=tmq("select * from itemtransit_main where id='$s[pid]' ");
	$smain=tfa($smain);
	if (strtolower($smain[isperm])=="yes") {
		if ($smain[dest]!=$LIBSITE) {
			html_dialog("Warning!","รายการนี้จะต้องถูกส่งไปที่ ".get_libsite_name($smain[dest])." แต่คุณอยู่ที่ ".get_libsite_name($LIBSITE));
		}
		$item=tmq("select * from media_mid where bcode='$s[bcode]' and bcode<>'' ");
		if (tnr($item)!=1) { die("barcode $s[bcode] not found");}
		$item=tfa($item);
		$map=tmq("select * from itemtransit_map where fromplace='$item[place]' and tocampus='$smain[dest]' ",false);
		if (tnr($map)!=1) {
			html_dialog("Error","ไม่มีการกำหนดกฏการย้ายทรัพยากรจาก ".get_itemplace_name($item[place])." ไปยัง " .get_libsite_name($smain[dest]));
			return;
		}
		$map=tfa($map);
		tmq("update media_mid set libsite='$smain[dest]',place='$map[setto]' where bcode='$s[bcode]' and bcode<>'' limit 1  ",false);
		tmq("update itemtransit_sub set status='done' where id='$id' ",false);
		html_dialog("Done","ย้ายทรัพยากรบาร์โค้ด $s[bcode] จาก ".get_itemplace_name($item[place])." ไปยัง " .get_libsite_name($smain[dest])." (".get_itemplace_name($map[setto]).") เรียบร้อย");
	} else {
		tmq("update itemtransit_sub set status='done' where id='$id' ",false);
		$item=tmq("select * from media_mid where bcode='$s[bcode]' and bcode<>'' ");
		if (tnr($item)!=1) { die("barcode $s[bcode] not found");}
		$item=tfa($item);
?><center><?php 
			res_brief_dsp($item[pid]);
			?></center><?php 
			html_dialog("Done","ลงรับเรียบร้อย");
	}
	tmq("insert into itemtransit_sub_status set pid='$id' , status='done', dt='$now',loginid='$useradminid'  ");

}
?>