<?php 
$titlestr=getlang("เนื้อหา แยกตามสถานะ::l::Contents by status");
$authstr="";
if ($modulecheck2!="") {
	$s="select * from webpage_wiki_status where code='$modulecheck2' ";
	if ($ismanager!=true) {
		$s.=" and code<>'draft' and code<>'incomplete' ";
	}
	$s=tmq($s);
	if (tmq_num_rows($s)==1) {
		$s=tmq_fetch_array($s);
		if ($_ISULIBMASTER=="yes" && $s[code]=="logedinonly") {
			$s[name]="UUG เท่านั้น::l::UUG Only";
			$s[descr]="บทความที่สงวนไว้สำหรับสมาชิก UUG เท่านั้น::l::This article is for UUG Members only";
		}
		$titlestr.=" : ".getlang($s[name]);
		$_wlocal_specsub="yes";
		//echo "[$modulecheck2$_wlocal_specsub]";
	} else {
		$titlestr.=":".getlang("ไม่พบหมวด $modulecheck2::l::Status $modulecheck2 not found");
	}
}
?>