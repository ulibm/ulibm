<?php // พ
function str_replace2($find,$replacewith,$str,$count=1) {
	//echo "$find,$replacewith,$str,$count";
	$a=explode($find,$str);
	$res="";
	$i=0;
	$count++;
	//print_r($a);
	if (is_array($a)) {
		foreach ($a as $key => $value) {
			$i++;
			if ($i>1) {
				if ($i<=$count) {
					$res=$res."".$replacewith;
				} else {
					$res=$res."".$find;
				}
			}
			$res=$res.$value;
		}
	}
	//echo "<PRE>$res</PRE>";
	return $res;
}
?>