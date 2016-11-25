<?php 
//include ("../inc/config.inc.php");include ("./inc.php");

$chkmem=tmq("select * from member where UserAdminID='".$dat["AA"]."' ");
if (tmq_num_rows($chkmem)==0) {
	//mem not found
	$resp="64".
		"YYYY          ".
		"001".
		"$siptime".
	 "0000"."0000"."0000"."0000"."0000"."0000".
		"AO".barcodeval_get("sipsetting-institutionID").$limiter.
		"AA".$dat["AA"].$limiter.
		"AEPatron ID: ".$dat["AA"].$limiter.
		"BLN$limiter".
		"BG$maxdue$limiter".
		"BHTHB$limiter".
		"BV0.00$limiter".
		"AFCannot find your record.$limiter".
		"AGCannot find your record.$limiter"
	;
} else {
	//memfound
	$chkmem=tmq_fetch_array($chkmem);

	//how many max
	$maxdue=tmq("SELECT *  FROM member_type where type='$chkmem[type]' ");
	$maxdue=tmq_fetch_array($maxdue);
	$maxfine=floor($maxdue[maxfine]);
	$maxdue=floor($maxdue[limithold]);
	//bg is for Gabriel@Wiserf

	$currentdut="select * from checkout where hold='".$dat["AA"]."' and allow='yes' and returned='no'  ";
	$currentdut=tmq($currentdut);
	$currentdut=tmq_num_rows($currentdut);
	$currentdut=floor($currentdut);
	$maxdue=$maxdue-$currentdut;

	if (trim($chkmem[Password])==trim($dat["AD"])) {
		$LOGIN="Y";
	} else {
		$LOGIN="N";
	}
	$todate=GregorianToJD2(date('n'), date('j'), date('Y')+543);
	$mbdate=GregorianToJD2($chkmem[mon], $chkmem[dat], $chkmem[yea]);
	$memname=get_member_name($dat["AA"]);
	$memname=strip_tags($memname);
	$memname=iconvutf($memname);

	$fines=tmq("SELECT *  FROM fine where memberId='".$dat["AA"]."' and isdone='no'");
	$sumfine=0;
	$_cfines=tmq_num_rows($fines);
	while ($row2=tmq_fetch_array($fines)) {
		$sumfine=$sumfine+$row2[fine];
	}
	if ($sumfine>=$maxfine) {
		$maxdue=0;
	}
	$_chold=0;
	$_coverdue=0;
	///////////////
	$sql="select * from checkout where hold='".$dat["AA"]."' and allow='yes' and returned='no'  ";
	$result=tmq($sql);
	$Num=tmq_num_rows($result);

	while ($row2=tmq_fetch_array($result)) {
		$edat=$row2[edat];
		$emon=$row2[emon];
		$eyea=$row2[eyea];
		$mediaId=$row2[mediaId];
		$tmpdecis=getduedecis($mediaId, date("j"), date("n"), date("Y"));
		$_chold++;
		if ($tmpdecis > 0) {
			$_coverdue++;
		}
	}
	///////////////
	//$fines=tmq_fetch_array($fines);
	$sumfine=number_format($sumfine,2);
	if ($chkmem[yea]!==0 || $mbdate >= $todate) {
		//echo "สมาชิกยังไม่หมดอายุ";
		$PATRON=$dat["AA"];
		$resp="64".
		"              ".
		"001".
		"$siptime".
		 str_fixw($_chold,4).str_fixw($_coverdue,4)."0000".str_fixw($_cfines,4)."0000"."0000".
		"AO".barcodeval_get("sipsetting-institutionID").$limiter.
		"AA".$dat["AA"].$limiter.
		"AE".$memname.$limiter.
		"BLY$limiter".
		"BG$maxdue$limiter".
		"BHTHB$limiter".
		"BV$sumfine$limiter".
		"AF$limiter".
		"AF$limiter".
		"AG$limiter".
		"CQ$LOGIN".$limiter
;	} else {

	// expired
	$resp="64".
		"YYYY          ".
		"001".
		"$siptime".
		 "0000"."0000"."0000"."0000"."0000"."0000".
		"AO".barcodeval_get("sipsetting-institutionID").$limiter.
		"AA".$dat["AA"].$limiter.
		"AE".$memname.$limiter.
		"BLN$limiter".
		"BG0$limiter".
		"BHTHB$limiter".
		"BV$sumfine$limiter".
		"AFMembership Expired.$limiter".
		"AGMembership Expired.$limiter".
		"CQ$LOGIN".$limiter
	;
	}
}
//64              00125521122    193541000000000000000000000000AO1901|AA0001|AE\8872\8863|BLY|BHUSD|BV0.00|AF|AG|
local_sput($resp);
?>