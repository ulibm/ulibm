<?php // พ
function member_isoverduing($mem) {
	$sql="select * from checkout where hold='$mem' and allow='yes' and returned='no'  ";
	$result=tmq($sql);
	$Num=tmq_num_rows($result);
	if ($Num == 0) {
		return "PASS";
	}
	while ($row2=tmq_fetch_array($result)) {
		$edat=$row2[edat];
		$emon=$row2[emon];
		$eyea=$row2[eyea];
		$mediaId=$row2[mediaId];
		$tmpdecis=getduedecis($mediaId, date("j"), date("n"), date("Y"));
		if ($tmpdecis > 0) {
			return "OVERDUEING";
		}
	}
	return "PASS";
}
?>