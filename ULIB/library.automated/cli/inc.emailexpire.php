<?php 
if ($setid=="") {
	die("no setid");
}
$automatedtaskname="automated_task";
$mailsubj=barcodeval_get("memexpirenotif-email-mailsubj");
$mailbody=barcodeval_get("memexpirenotif-email-mailbody");
$mailsubj=addslashes($mailsubj);
$mailbody=addslashes($mailbody);
if (trim($mailsubj)=="") {
	die("no mailsubj");
}

if (trim($mailbody)=="") {
	die("no mailbody");
}
function local_chdate($wh) {
	if ( floor($wh[dat]) == 0 || floor($wh[mon]) == 0 || floor($wh[yea]) == 0) {
		return getlang("ไม่กำหนดวันหมดอายุ::l::Expire date not set");
	}
	return strip_tags(	ymd_datestr(ymd_mkdt($wh[dat],$wh[mon],$wh[yea]-543),'shortd')." <br><font class=smaller>".ymd_ago(ymd_mkdt($wh[dat],$wh[mon],$wh[yea]-543))."</font>");
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
	$selectctrl=" *,str_to_date(concat(dat,',',mon,',',(yea-543)),'%d,%m,%Y') as enddt ";

  $sql1 ="SELECT $selectctrl FROM member WHERE 1  $havingctrl "; // limit $goto,$list_page";
    $test = tmq($sql1,false);
    $rc = tmq_num_rows($test);

	$test=tmq("$sql1 "); // for item that just has a hold
	while ($r=tmq_fetch_array($test)) {
		//$chk=tmq("select * from memexpire_notif where libid='$automatedtaskname' and memid='$r[hold]' ",true);
		//if (tmq_num_rows($chk)==0) {
			tmq("insert into memexpire_notif set libid='$automatedtaskname' ,memid='$r[UserAdminID]' ,setid='$setid' ",false);
		//}
	}
//////////////////////////////////////////////////////////////
//die;

$s=tmq("select * from memexpire_notif where setid='$setid' ",false);

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

	$expdate=local_chdate($meminfo);

	$title=str_replace('[MEMBERNAME]',$memname,$mailsubj);
	$title=str_replace('[MEMBERBC]',$r[memid],$title);
	$title=str_replace('[MEMBERMAIL]',$toemail,$title);
	$title=str_replace('[MYNAME]',get_library_name($automatedtaskname),$title);
	$title=str_replace('[LIBURL]',$dcrURL,$title);
	$title=str_replace('[EXPDATE]',$expdate,$title);

	$body=str_replace('[MEMBERNAME]',$memname,$mailbody);
	$body=str_replace('[MEMBERBC]',$r[memid],$body);
	$body=str_replace('[MEMBERMAIL]',$toemail,$body);
	$body=str_replace('[MYNAME]',get_library_name($automatedtaskname),$body);
	$body=str_replace('[LIBURL]',$dcrURL,$body);
	$body=str_replace('[EXPDATE]',$expdate,$body);


	//umail_que($mailsetid,$toemail,$title,$body);
	$umail_mail_libid=$automatedtaskname;
	echo umail_mail($toemail,$title,$body);

	$sent++;
}
?>Sent <?php  echo $sent;?>,
Eof 