<?php  //พ
function usoundex_USOUNDEXCTRLARRAY() {
	global $_USOUNDEXCTRLARRAY;
	if (!isset($_USOUNDEXCTRLARRAY)) {
		$s=tmq("select * from usoundex  where 1 order by ordr");
		$_USOUNDEXCTRLARRAY=Array();
		while ($r=tmq_fetch_array($s)) {
			//if (strlen($r[word])>=3 && strlen($r[word])<10) {
			$_USOUNDEXCTRLARRAY[]=trim($r[search1]).":::".trim($r[replace1]);
		}
	}
	return $_USOUNDEXCTRLARRAY;

}
?>