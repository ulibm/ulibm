<?php 
set_time_limit(0);
include("../../inc/config.inc.php");
include("./_conf.php");

if ($mode=="resetbibdt" && $bibid!="") {
	tmq("update media set lastdt='0' where id='$bibid';");
	echo "done";
	die;
}


function local_implode($a) {
	@reset($a);
	while (list($k,$v)=each($a)) {
		$retVal[$k]=$v;
	}
	//printr($retVal);
	return serialize($retVal);
}
	///chkcompatible cli
		//ต้องไปแก้ไขไฟล์ addnewDBBook.php ให้อัพเดทฟิลด์นี้ด้วย
		$s=tmq("show columns from media where Field ='lastdt' ");
		if (tmq_num_rows($s)==0) {
			tmq("ALTER TABLE  media ADD  lastdt DOUBLE NOT NULL ;");
		}
		//$s=tmq_fetch_array($s);printr($s);
	///chkcompatible end
	//printr($biblist);

	$index=explode(";",$data);
	//printr($index);

	$sql="";
	@reset($index);
	while (list($k,$v)=each($index)) {
			$sql.=",trim($v),':--:' ";
	}
	$sql=trim($sql,',');
	$sql=trim($sql,',');


	$biblist=explode(":",$biblist);
	//printr($biblist);
	$biblist=arr_filter_remnull($biblist);
	@reset($biblist);
	while (list($k,$v)=each($biblist)) {
		$sqllocal="select  ID,trim(concat($sql)) as hashes from media where ID='$v' ";
		$s=tmq($sqllocal);
		if (tmq_num_rows($s)==0) {
			$r=Array();
			$r[ID]=$v;
			$r[hashes]="not_exists";
			unset($r[0]);
			unset($r[1]);
			unset($r[2]);
			unset($r[3]);
			unset($r[4]);
			echo serialize($r);
			echo "$newline";
		} else {
			$r=tmq_fetch_array($s);
			//$resultdata=$r[ID]."::".$r[hashes];
			//$resultdata=local_implode($r,"[recsplit]");
			$r[hashes]=(base64_encode($r[hashes]));
			unset($r[0]);
			unset($r[1]);
			unset($r[2]);
			unset($r[3]);
			unset($r[4]);
			echo serialize($r);
			echo "$newline";
		}
	}
	die;
?>