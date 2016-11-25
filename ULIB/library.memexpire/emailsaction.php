<?php 
    ;
include ("../inc/config.inc.php");
loginchk_lib('check');
function local_chdate($wh) {
	if ( floor($wh[dat]) == 0 || floor($wh[mon]) == 0 || floor($wh[yea]) == 0) {
		return getlang("ไม่กำหนดวันหมดอายุ::l::Expre date not set");
	}
	return strip_tags(	ymd_datestr(ymd_mkdt($wh[dat],$wh[mon],$wh[yea]-543),'shortd')." <br><font class=smaller>".ymd_ago(ymd_mkdt($wh[dat],$wh[mon],$wh[yea]-543))."</font>");
}

$_REQPERM="memexpire";
if (!library_gotpermission($_REQPERM)) {
	die('_REQPERM');
}
/*
$_REQPERM="mailsman";
if (!library_gotpermission($_REQPERM)) {
	die('_REQPERM (mailsman)');
}
*/
if ($setid=="") {
	die("no setid");
}
if (trim($mailsubj)=="") {
	die("no mailsubj");
}

if (trim($mailbody)=="") {
	die("no mailbody");
}

$mailsubj=addslashes($mailsubj);
barcodeval_set("memexpirenotif-email-mailsubj",$mailsubj);

$mailbody=addslashes($mailbody);
barcodeval_set("memexpirenotif-email-mailbody",$mailbody);

$s=tmq("select * from memexpire_notif where setid='$setid' ",false);

$sent=0;
$noemailcount=0;
$mailsetid="เตือนวันหมดอายุ ".ymd_datestr(time(),'shortdt');
while ($r=tmq_fetch_array($s)) {
	$meminfo=tmq("select * from member where UserAdminID='$r[memid]' ",false);
	if (tmq_num_rows($meminfo)==0) {
		continue;
	}
	$meminfo=tmq_fetch_array($meminfo);
	$memname=addslashes($meminfo[UserAdminName]);
	//printr($r);
	$toemail=trim($meminfo[email]);
	if ($toemail=='') {
		$noemailcount++;
		continue;
	}
	$expdate=local_chdate($meminfo);

	$title=str_replace('[MEMBERNAME]',$memname,$mailsubj);
	$title=str_replace('[MEMBERBC]',$r[memid],$title);
	$title=str_replace('[MEMBERMAIL]',$toemail,$title);
	$title=str_replace('[MYNAME]',get_library_name($useradminid),$title);
	$title=str_replace('[LIBURL]',$dcrURL,$title);
	$title=str_replace('[EXPDATE]',$expdate,$title);

	$body=str_replace('[MEMBERNAME]',$memname,$mailbody);
	$body=str_replace('[MEMBERBC]',$r[memid],$body);
	$body=str_replace('[MEMBERMAIL]',$toemail,$body);
	$body=str_replace('[MYNAME]',get_library_name($useradminid),$body);
	$body=str_replace('[LIBURL]',$dcrURL,$body);
	$body=str_replace('[EXPDATE]',$expdate,$body);


	umail_que($mailsetid,$toemail,$title,$body);
	$sent++;
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("<?php  echo getlang("บันทึกข้อมูลการส่งอีเมล์ $sent รายการ\\n$noemailcount รายการไม่มีอีเมล์ ::l::$sent emails added into queues\\n$noemailcount record has no email.");?>");
//-->
</SCRIPT>
<?php 
redir("../library.mailsman/send.php?setid=".urlencode($mailsetid),2);
?>