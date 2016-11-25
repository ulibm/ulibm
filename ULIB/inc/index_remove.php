<?php  // พ
function index_remove($mid) {
	global $_IS_ENABLE_AUTO_INDEXWORD;
	tmq("delete from index_db where mid='$mid' ");
	if ($_IS_ENABLE_AUTO_INDEXWORD=="yes") {
		tmq("delete from indexword where mid='$mid' ");
	}
	tmq("delete from index_db_subj where mid='$mid' ");
}
?>