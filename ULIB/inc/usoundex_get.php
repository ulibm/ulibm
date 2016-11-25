<?php // พ
function usoundex_get($word) {
	$ctrl=usoundex_USOUNDEXCTRLARRAY();
	//echo "[$word]";
	//printr($ctrl);
	//$word=str_remspecialsign($word);
	foreach ($ctrl as $value) {
		$v=explode(":::",$value);
		//echo "<BR>Value: $v[0], $v[1] [$word]";
		$replaceval=$v[1];
		if ($replaceval=="") {
		 $replaceval="";
		}
		$word=preg_replace("/".$v[0]."/u",$replaceval, $word);
	}
	return trim($word);
}
?>