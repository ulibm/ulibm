<?php  //พ
function index_init_INDEXWORDDB() {
	global $_INDEXWORDDB;
	if (!isset($_INDEXWORDDB)) {
		$s=tmq("select * from indexword  where LENGTH(word)>5");
		$_INDEXWORDDB=Array();
		while ($r=tmq_fetch_array($s)) {
			//if (strlen($r[word])>=3 && strlen($r[word])<10) {
			$_INDEXWORDDB[]=trim($r[word]);
		}
	}
}
?>