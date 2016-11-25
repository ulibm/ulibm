<?php // พ
function tmq_dump2($tb,$k,$v ,$bl="",$DB = "") {
	////func(" tmq_dump($tb,$k,$v ,$bl)");
	if ($DB=="") {
		$tmqfunc="tmq";
		$OSDB="";
	} else {
		$tmqfunc="aliceos_tmqs";
		$OSDB=$DB;
	}
	//echo"*[$tmqfunc]*";

	if ($tmqfunc=="tmq") {
		$s_local=tmq("select * from $tb  $bl",false);
	}
	if ($tmqfunc=="aliceos_tmqs") {
		$s_local=tmq("select * from $tb  $bl",false,$OSDB);
	}
	$pos = strrpos($v, ",");
	if (is_bool($pos) && !$pos) {
		while ($r=tmq_fetch_array($s_local)) {
			$tmp[$r["$k"]]=$r[$v];
		}
	} else {
		$v=explode(",",$v);
		while ($r=tmq_fetch_array($s_local)) {
			foreach ($v as $key => $value) {
				$tmp[$r["$k"]][$key]=$r[$value];
			}
		}
	}
	////func(" tmq_dump finished");

	return $tmp;
}
?>