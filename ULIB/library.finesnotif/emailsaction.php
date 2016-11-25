<?php 
    ;
include ("../inc/config.inc.php");
loginchk_lib('check');

$_REQPERM="finesnotif";
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
barcodeval_set("finesnotifnotif-email-mailsubj",$mailsubj);

$mailbody=addslashes($mailbody);
barcodeval_set("finesnotifnotif-email-mailbody",$mailbody);

$s=tmq("select * from fines_notif where setid='$setid' ",false);

$sent=0;
$noemailcount=0;
$mailsetid="ทวงค่าปรับ ".ymd_datestr(time(),'shortdt');
while ($r=tmq_fetch_array($s)) {
	$meminfo=tmq("select * from member where UserAdminID='$r[memid]' ",false);
	if (tmq_num_rows($meminfo)==0) {
		continue;
	}
	$meminfo=tmq_fetch_array($meminfo);
	$memname=addslashes($meminfo[UserAdminName]);
	//printr($meminfo);
	$toemail=trim($meminfo[email]);
	if ($toemail=='') {
		$noemailcount++;
		continue;
	}

		$sql="select * from fine where memberId='$r[memid]' and isdone<>'yes' and fine>0 order by id asc";
		$result=tmq($sql);
		$holdingnum=tmq_num_rows($result);
		if ($holdingnum==0) {
			continue;
		}
		$cc=0;
		$holdlist="";
		while ($row = tmq_fetch_array($result)) {
				$cc++;
				$holdlist.="$cc. ".substr($row[topic],0,50).".. : ค่าปรับ  ". 
				number_format($row[fine])."
";
		}

	$title=str_replace('[MEMBERNAME]',$memname,$mailsubj);
	$title=str_replace('[MEMBERBC]',$r[memberId],$title);
	$title=str_replace('[MEMBERMAIL]',$toemail,$title);
	$title=str_replace('[MYNAME]',get_library_name($useradminid),$title);
	$title=str_replace('[LIBURL]',$dcrURL,$title);
	$title=str_replace('[HOLDNUM]',$holdingnum,$title);
	$title=str_replace('[HOLDINGLIST]',$holdlist,$title);

	$body=str_replace('[MEMBERNAME]',$memname,$mailbody);
	$body=str_replace('[MEMBERBC]',$r[memberId],$body);
	$body=str_replace('[MEMBERMAIL]',$toemail,$body);
	$body=str_replace('[MYNAME]',get_library_name($useradminid),$body);
	$body=str_replace('[LIBURL]',$dcrURL,$body);
	$body=str_replace('[HOLDNUM]',$holdingnum,$body);
	$body=str_replace('[HOLDINGLIST]',$holdlist,$body);


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
redir("../library.mailsman/send.php?setid=".urlencode($mailsetid));
?>