<?php // พ
function marc_getcalln($wh,$sepper = "") {
	$tag=getval("MARCdsp","callnum");
	$tags=explode(",",$tag);
	$s=tmq("select * from media where ID='$wh' ");
	$s=tmq_fetch_array($s);
	$str="";
	while (list($key, $val) = each($tags)) {
		//echo "[$tags=($key, $val)".$s[$val]."]";
		$eachsub=explodenewline($s[$val]);
		$eachsub=arr_filter_remnull($eachsub);
		//printr($eachsub);
		while (list($key2, $val2) = each($eachsub)) {
			//echo "[".$val2."=".substr($val2,2)."]";
			$str="$str$sepper" . substr($val2,2);
			if (substr($val2,2)!="") {
			   //echo "marc_getcalln got from tag $val2 ($str)";
			   return dspmarc($str,$sepper);;
			}
		}
	}
	//echo "[$str]";
	$res=dspmarc($str,$sepper);
		//echo "[$res]";
	return $res;
}
?>