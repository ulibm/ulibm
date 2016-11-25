<?php // พ
function indexword_insert($word,$importdt,$mid=0,$importid='',$forceskip="NO") {
	global $_IS_ENABLE_AUTO_INDEXWORD;

	if ($_IS_ENABLE_AUTO_INDEXWORD!="yes" && $forceskip=="NO") {
		return;
	}
	//$word=substr($word,0,20);
	//$word=str_remspecialsign($word);
	//echo "[$word]<BR>";
	if (trim($word)=="") {
		return;
	}

	$tmp=tmq("select id from indexword where word1='".addslashes($word)."' ");
	$tmp=tmq_num_rows($tmp);
	if ($tmp==0) {
		tmq("insert delayed into indexword set word1='".addslashes($word)."',usoundex='".usoundex_get($word)."' ,importdt='$importdt',mid='$mid',importid='$importid' ");
	}
}
?>