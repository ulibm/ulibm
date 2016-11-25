<?php // พ
function frm_globalupload_updatetemp($newid,$updatestr) {
	global $useradminid;
	global $dcrs;
	if ($newid=="") {
		die("frm_globalupload_updatetemp() error empty newid");
	}
	$curkey="tempolary-for-$useradminid";
	tmq("update globalupload set keyid='$newid' where keyid='$curkey' ");
	$updatestr=str_replace("/tempolary-for-$useradminid/","/$newid/",$updatestr);
	$sourcepath="$dcrs/_globalupload/$curkey/";
	$newpath="$dcrs/_globalupload/$newid/";
	@rename($sourcepath,$newpath);
	return addslashes($updatestr);
}
?>