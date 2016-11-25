<?php // พ
function marc_getmidcalln($bcode) {
	global $marc_getmidcalln_place;
	if (!is_array($marc_getmidcalln_place)) {
		$marc_getmidcalln_place=tmq_dump2("media_place","code","collcode");
		//printr($marc_getmidcalln_place);
	}
	$s=tmq("select * from media_mid where bcode='$bcode' ",false);
	if (tmq_num_rows($s)==0) {
		return "Item not found (Barcode=$bcode)";
	}
	$s=tmq_fetch_array($s);
	//printr($s);
	//printr($marc_getmidcalln_place);
	
	if ($s[calln]!='') {
		$s=trim($marc_getmidcalln_place[$s[place]])." ".$s[calln];
		return trim($s);
	} else {
		$s[calln]=marc_getcalln($s[pid]);//trim($s[calln]);
      //printr($s);
		//$sret="".trim($marc_getmidcalln_place[$s[place]])." ".trim(marc_getcalln($s[pid]))."";
               $sret=$s[calln];
   	//echo "xxx";
		//echo $s;
		return trim($sret);
	}
}
?>