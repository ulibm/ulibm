<?php 
if ($setid=="") {
	die("no setid");
}
$automatedtaskname="automated_task";
$mailsubj=barcodeval_get("holdlongnotif-email-mailsubj");
$mailbody=barcodeval_get("holdlongnotif-email-mailbody");
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
	$dayback2=1000;
}
   $now=time();

$nowpure=mktime(0, 0, 0, date('m'), date('j'), date('Y'));
if ($revers!="yes") {
	$daybackuse=$nowpure-($dayback*60*60*24);
	$daybackuse_str=date('Y-m-d',$daybackuse);
	$dayback2use=$nowpure-($dayback2*60*60*24);
	$dayback2use_str=date('Y-m-d',$dayback2use);
	$havingctrl=" having enddt<=date('$daybackuse_str') and enddt>=date('$dayback2use_str') ";
} else {
	$daybackuse=$nowpure+($dayback*60*60*24);
	$daybackuse_str=date('Y-m-d',$daybackuse);
	$dayback2use=$nowpure+($dayback2*60*60*24);
	$dayback2use_str=date('Y-m-d',$dayback2use);
	$havingctrl=" having enddt>=date('$daybackuse_str') and enddt<=date('$dayback2use_str') ";
}
//echo "[$daybackuse_str-$dayback2use_str]";
	$selectctrl=" *,str_to_date(concat(edat,',',emon,',',(eyea-543)),'%d,%m,%Y') as enddt ";

  $sql1 ="SELECT $selectctrl FROM `checkout` WHERE 1  $havingctrl "; // limit $goto,$list_page";
    $test = tmq($sql1,false);
    $rc = tmq_num_rows($test);

	$test=tmq("$sql1 and returned	='no' "); // for item that just has a hold
	while ($r=tmq_fetch_array($test)) {
		//$chk=tmq("select * from holdlong_notif where libid='$automatedtaskname' and memid='$r[hold]' ",true);
		//if (tmq_num_rows($chk)==0) {
			tmq("insert into holdlong_notif set libid='$automatedtaskname' ,memid='$r[hold]' ,setid='$setid' ",false);
		//}
	}
//////////////////////////////////////////////////////////////
//die;

$s=tmq("select * from holdlong_notif where setid='$setid' ",false);

$sent=0;
$noemailcount=0;
$mailsetid="ทวงถาม ".ymd_datestr(time(),'shortdt');
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

		$sql="select * from checkout where hold='$r[memid]' and allow='yes' and returned='no' order by id asc";
		$result=tmq($sql);
		$holdingnum=tmq_num_rows($result);
		if ($holdingnum==0) {
			continue;
		}
		$cc=0;
		$holdlist="";
		while ($row = tmq_fetch_array($result)) {
				$cc++;
				$holdlist.="$cc. $row[mediaId]:".substr(trim($row[mediaName]),0,50).".. : กำหนดส่งวันที่ ". 
				ymd_datestr(ymd_mkdt($row[edat],$row[emon],$row[eyea]-543),'date')."
";
		}

	$title=str_replace('[MEMBERNAME]',$memname,$mailsubj);
	$title=str_replace('[MEMBERBC]',$r[memid],$title);
	$title=str_replace('[MEMBERMAIL]',$toemail,$title);
	$title=str_replace('[MYNAME]',get_library_name($automatedtaskname),$title);
	$title=str_replace('[LIBURL]',$dcrURL,$title);
	$title=str_replace('[HOLDNUM]',$holdingnum,$title);
	$title=str_replace('[HOLDINGLIST]',$holdlist,$title);

	$body=str_replace('[MEMBERNAME]',$memname,$mailbody);
	$body=str_replace('[MEMBERBC]',$r[memid],$body);
	$body=str_replace('[MEMBERMAIL]',$toemail,$body);
	$body=str_replace('[MYNAME]',get_library_name($automatedtaskname),$body);
	$body=str_replace('[LIBURL]',$dcrURL,$body);
	$body=str_replace('[HOLDNUM]',$holdingnum,$body);
	$body=str_replace('[HOLDINGLIST]',$holdlist,$body);


	//umail_que($mailsetid,$toemail,$title,$body);
	$umail_mail_libid=$automatedtaskname;
	echo umail_mail($toemail,$title,$body);

	$sent++;
}
?>Sent <?php  echo $sent;?>,
Eof 