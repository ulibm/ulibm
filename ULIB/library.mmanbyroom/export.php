<?php  //พ
	include ("../inc/config.inc.php");
	loginchk_lib("check");

	 header("Content-type: application/ms-download; charset=utf-8\n\n");
	 header("Content-Disposition: attachment; filename=\"ulibm-member-$mode-room-$roomid.csv\"\n"); 
   header("Pragma: no-cache");
   header("Expires: 0");
   echo "\xEF\xBB\xBF"; //UTF-8 BOM
 
	if ($roomid!="") {
		$s=tmq("select * from member where room='$roomid' ");
	}
	if ($libsiteid!="") {
		$s=tmq("select * from member where LIBSITE='$libsiteid' ");
	}
	if ($typid!="") {
		$s=tmq("select * from member where type='$libsiteid' ");
	}
	$custdb=tmq_dump("member_customfield","fid","name");
	$roomdb=tmq_dump("room","id","name");
	$major=tmq_dump("major","id","name");
	if ($mode=="report") {
		echo "MoneyOwned,CopyOwned,";
	}
	echo "Barcode,Name,email,descr,type,statusactive,address,address2,tel,prefi,ExpirationDate,room,major,countlogin,LibrarySite,credit,".iconvutf(getlang($custdb[cust01])).",".getlang($custdb[cust02]).",".getlang($custdb[cust03]).",".getlang($custdb[cust04]).",".getlang($custdb[cust05]).",$newline";
function local_str($wh) {
	return str_replace(',','_',$wh);
}
function local_row($wh) {
	global $newline;
	global $mode;
	global $roomdb;
	global $major;
	if ($mode=="report") {
		$copy=tmq("SELECT *  FROM checkout where hold ='$wh[UserAdminID]' and allow='yes' and returned='no' ");
		$copy=tmq_num_rows($copy);
		$copy2=tmq("SELECT *  FROM useinsidelib where memid ='$wh[UserAdminID]'  ");
		$copy2=tmq_num_rows($copy2);
		$copycount=floor($copy+$copy2);

		$fines=tmq("SELECT * FROM fine where memberId='$wh[UserAdminID]' and isdone='no' ");
		//$fines=tmq_num_rows(($fines));
			$finecount=0;
			while ($rqcountr=tmq_fetch_array($fines)) {
				$finecount=$finecount+floor($rqcountr[fine]);
			}

		if ($copycount==0&&$finecount==0) {
			return;
		} else {
			echo "$finecount,$copycount,";
		}
	}

	echo 
		'" '.local_str($wh[UserAdminID]).'"'.",".
		local_str($wh[UserAdminName]).",".
		local_str($wh[email]).",".
		local_str($wh[descr]).",".
		local_str($wh[type]).",".
		local_str($wh[statusactive]).",".
		local_str($wh[address]).",".
		local_str($wh[address2]).",".
		local_str($wh[tel]).",".
		local_str($wh[prefi]).",".
		"$wh[yea]-$wh[dat]-$wh[mon],".
		local_str($roomdb[$wh[room]]).",".
		local_str($major[$wh[major]]).",".
		local_str($wh[countlogin]).",".
		local_str($wh[LibrarySite]).",".
		local_str($wh[credit]).",".
		local_str($wh[cust01]).",".
		local_str($wh[cust02]).",".
		local_str($wh[cust03]).",".
		local_str($wh[cust04]).",".
		local_str($wh[cust05])."",$newline;

}
	while ($r=tmq_fetch_array($s)) {
		local_row($r);
	}
	
?>