<?php 
if ($setid=="") {
	die("no setid");
}
$automatedtaskname="automated_task";
$mailsubj=barcodeval_get("finesnotifnotif-email-mailsubj");
$mailbody=barcodeval_get("finesnotifnotif-email-mailbody");
$mailsubj=addslashes($mailsubj);
$mailbody=addslashes($mailbody);
if (trim($mailsubj)=="") {
	die("no mailsubj");
}

if (trim($mailbody)=="") {
	die("no mailbody");
}

$dayback=floor($dayback);
$dayback2=floor($dayback2);
if ($dayback==0) {
	$dayback=0;
}
if ($dayback2==0) {
	$dayback2=100000;
}
   $now=time();
	$nowpure=mktime(0, 0, 0, date('m'), date('j'), date('Y'));
	$groupbyctrl=" group by  isdone,memberId";
	$havingctrl="having isdone<>'yes' and sumb>='$dayback' and sumb<='$dayback2' ";
	$wheresql="1";
	$selectctrl="*,sum(fine) as sumb";
  $sql1 ="SELECT $selectctrl FROM fine WHERE $wheresql $groupbyctrl  $havingctrl "; // limit $goto,$list_page";
    $test = tmq($sql1,false);
    $rc = tmq_num_rows($test);

	while ($r=tmq_fetch_array($test)) {
		tmq("insert into fines_notif set libid='$automatedtaskname' ,memid='$r[memberId]' ,setid='$setid' ",false);
	}


//////////////////////////////////////////////////////////////
//die;
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
	$title=str_replace('[MYNAME]',get_library_name($automatedtaskname),$title);
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

	$umail_mail_libid=$automatedtaskname;
	echo umail_mail($toemail,$title,$body);
	$sent++;
}
?>Sent <?php  echo $sent;?>,
Eof 