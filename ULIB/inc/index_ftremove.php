<?php // พ
function index_ftremove($wh) {

	global $_detatchbibfrombibacc;
	global $dcrs;
	if ($_detatchbibfrombibacc=="yes") {
		return; 
	}
	$s=tmq("select * from media_ftitems where mid ='$wh' ");
	$midlist=Array();
	$mlist=Array();
	while ($mdtsr=tmq_fetch_array($s)) {
		//printr($mdtsr);
		$uploaddir ="$dcrs/_fulltext/$mdtsr[fttype]/$mdtsr[mid]/";
		
		@unlink($uploaddir.$mdtsr[filename]);
		@unlink($uploaddir."thumb.$mdtsr[filename]");
		//echo "$uploaddir";
	}
	//die;
	
	tmq("DELETE from media_ftitems where mid ='$wh' ");
	tmq("DELETE from webpage_bookcomment where bibid ='$wh' ");
	tmq("DELETE from webpage_showcase where mid ='$wh' ");
	tmq("DELETE from webpage_memfavbook where bibid ='$wh' ");
	tmq("DELETE from webpage_incorrectbib where bibid ='$wh' ");
	tmq("DELETE from webpage_bibtag where bibid ='$wh' ");
	tmq("DELETE from webpage_bibrating_sum where bibid ='$wh' ");
	tmq("DELETE from webpage_bibrating_log where bibid ='$wh' ");
}
?>