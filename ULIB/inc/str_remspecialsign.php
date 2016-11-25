<?php 
function str_remspecialsign($word,$replacewith="") {
	
	$word=str_replace('&',$replacewith,$word);
	$word=str_replace('+',$replacewith,$word);
	$word=str_replace('-',$replacewith,$word);
	$word=str_replace('*',$replacewith,$word);
	$word=str_replace('/',$replacewith,$word);
	$word=str_replace('\\',$replacewith,$word);
	$word=str_replace('=',$replacewith,$word);
	$word=str_replace('_',$replacewith,$word);
	$word=str_replace('-',$replacewith,$word);
	$word=str_replace(')',$replacewith,$word);
	$word=str_replace('(',$replacewith,$word);
	$word=str_replace(']',$replacewith,$word);
	$word=str_replace('[',$replacewith,$word);
	$word=str_replace('{',$replacewith,$word);
	$word=str_replace('}',$replacewith,$word);
	$word=str_replace('|',$replacewith,$word);
	$word=str_replace('!',$replacewith,$word);
	$word=str_replace('@',$replacewith,$word);
	$word=str_replace('#',$replacewith,$word);
	$word=str_replace('$',$replacewith,$word);
	$word=str_replace('%',$replacewith,$word);
	$word=str_replace('^',$replacewith,$word);
	$word=str_replace(',',$replacewith,$word);
	$word=str_replace('.',$replacewith,$word);
	$word=str_replace('<',$replacewith,$word);
	$word=str_replace('>',$replacewith,$word);
	$word=str_replace('?',$replacewith,$word);
	$word=str_replace(':',$replacewith,$word);
	$word=str_replace(';',$replacewith,$word);
	$word=str_replace('\'',$replacewith,$word);
	$word=str_replace('"',$replacewith,$word);
	  $word = preg_replace('/[\x{80}-\x{A0}'. // Non-printable ISO-8859-1 + NBSP
        '\x{01}-\x{1F}'. //Non-printable ASCII characters
        '\x{AD}'. // Soft-hyphen
        '\x{2000}-\x{200F}'. // Various space characters
        '\x{2028}-\x{202F}'. // Bidirectional text overrides
        '\x{205F}-\x{206F}'. // Various text hinting characters
        '\x{FEFF}'. // Byte order mark
        '\x{FF01}-\x{FF60}'. // Full-width latin
        '\x{FFF9}-\x{FFFD}'. // Replacement characters
        '\x{0}]/u', // NULL byte
        $replacewith, $word);
	  $word = preg_replace('/[\x{AAAA}-\x{FFFD}]/u', '', $word);

	  
//	$word=ereg_replace('[^ฯ-ฺเ-ํ๐-๙a-zA-Z0-9ก-ฮ "]', "", $word);
	//$word=ereg_replace('[^เ-์ะ-ู๐-๙a-zA-Z0-9ก-ฮ "]', "", $word);

	  //$word = preg_replace('/[\x{AV}]]/u', "4", $word);

	return $word;
}
?>