<?php  // พ
function index_markword($str) {
	global $_INDEXWORDDB;
	$str=str_replace(" ",'|',$str);
	index_init_INDEXWORDDB();
		foreach ($_INDEXWORDDB as $i ) {
			$str=str_replace("$i","|$i|",$str);
		}
		$str=str_replace2("||","|",$str,10);

	return $str;
}
?>