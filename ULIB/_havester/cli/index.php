<?php 
set_time_limit(0);
include("../../inc/config.inc.php");
	///chkcompatible cli
		//ต้องไปแก้ไขไฟล์ addnewDBBook.php ให้อัพเดทฟิลด์นี้ด้วย
		$s=tmq("show columns from media where Field ='lastdt' ");
		if (tmq_num_rows($s)==0) {
			tmq("ALTER TABLE  media ADD  lastdt DOUBLE NOT NULL ;");
		}
		$s=tmq("show columns from index_db where Field ='havestlist' ");
		if (tmq_num_rows($s)==0) {
			tmq("ALTER TABLE  index_db ADD  havestlist VARCHAR(255) NOT NULL ;");
		}
		//$s=tmq_fetch_array($s);printr($s);
	///chkcompatible end
include("./_conf.php");
//echo "s";
$svdt=floor($svdt);
$limitnum=floor($limitnum);
if ($limitnum<10) {
	$limitnum=10;
}
function local_implode($a) {
	@reset($a);
	while (list($k,$v)=each($a)) {
		$retVal[$k]=$v;
	}
	//printr($retVal);
	return serialize($retVal);
}


if ($cmd=="clearlasttime" && $svdt==0) {
	tmq("update media set lastdt='0';");
	echo "clearlasttime done.";
	die;
}
if ($cmd=="generalfetch" && $svdt!=0) {
	$truetime_diff=time()-$svdt;
	//echo $truetime_diff;
	$truetime=time()+$truetime_diff;
	$index=explode(";",$data);
	//printr($index);
	$sql="";
	@reset($index);
	while (list($k,$v)=each($index)) {
			$sql.=",trim($v),':--:' ";
	}
	$sql=trim($sql,',');
	$sql=trim($sql,',');

	$now=time();
	$sql="select  ID,trim(concat($sql)) as hashes,$now as dt from media where lastdt>'$truetime' or lastdt=0 limit $limitnum";
	$s=tmq($sql);
	$c=tmq_num_rows($s);
	while ($r=tmq_fetch_array($s)) {
		$MARCDATA=tmq("select * from media where ID='$r[ID]' ");
		$MARCDATA=tmq_fetch_array($MARCDATA);
		//$MARCDATA=arr_filter_remnull($MARCDATA);
		$MARCDATA=local_implode($MARCDATA,"[recsplit]");
		unset($r[0]);
		unset($r[1]);
		unset($r[2]);
		unset($r[3]);
		$r[hashes]=base64_encode(trim($r[hashes]));
		//printr($r);
		$r[MARCDATA]=(base64_encode($MARCDATA));
		echo serialize($r);
		echo "$newline";
		tmq("update media set lastdt='$truetime' where ID='$r[ID]' ");
	}
	$last=Array();
	$last[counted]=$c;
	echo serialize($last);
	die;
}
if ($cmd=="generalfetch" && $svdt!=0) {

}
?>