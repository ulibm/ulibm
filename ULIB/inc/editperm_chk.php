<?php // พ
function editperm_chk($mid,$usrc="",$rulerpermission="webeditpagepermission") { 
	 $mid=urldecode($mid);
	 $mid=urldecode($mid);
	 $mid=urldecode($mid);
	 $mid=urlencode($mid);

	global $useradminid;
	if ($usrc=="") {
		$usrc=$useradminid;
	}
	if (loginchk_lib("check")==false) {
		return false;
	}
	$c=tmq("select * from library_editperm where classid='$mid' ",false);
	if (tmq_num_rows($c)==0) {
		return true;
	} else {
		$c=tmq_fetch_array($c);
		$pos = strpos("$c[editable]", ",$usrc,");
		if ($pos === false && $c[editable]!="") {
			$iseditpermmanager=library_gotpermission("$rulerpermission");
			if ($iseditpermmanager!=true) {
				return false;
			} else {
				return true;
			}
		} else {
			return true;
		}	
	}
}
?>