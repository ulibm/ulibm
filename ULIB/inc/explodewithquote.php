<?php // พ
function explodewithquote($str,$maxlen=10,$limiter=" ") {
	//$str=str_replace2('  ',' ',$str);
	$str=rem2space($str);
	//$str=str_replace("'",'"',$str);
	//echo $str;
	$result="";
	$replacemode=$limiter;
	$inquote=false;
	for ($i=0;$i<=strlen($str);$i++) {
		$currentchr=$str[$i];
		if ($currentchr=='"') {
			if ($inquote==true) {
				$inquote=false;
			} else {
				$inquote=true;
			}
			if ($inquote==true) {
				$replacemode='[SPLITERWASHERE]';
			} else {
				$replacemode=$limiter;
			}
		}
		if ($currentchr==$limiter) {
			$result.=$replacemode;
		} else {
			$result.=$currentchr;
		}
	}
	//echo "<BR>$result<BR>";
	$result=explode($limiter,$result);
	while (list($k,$v)=each($result)) {
		$v=stripslashes($v);
		$result[$k]=str_replace('[SPLITERWASHERE]',$limiter,$v);
		//$result[$k]=trim($result[$k],'"');
	}
   //printr($result);
	return $result;
}

?>