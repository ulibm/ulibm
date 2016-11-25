<?php 
    ;
	ob_start();
ini_set("max_execution_time",600);
	include ("../inc/config.inc.php");
	head();
	$_REQPERM="index_reindex";
	mn_lib();
	$indexpertime=getval("_SETTING","indexeachround");
	
	if ($newindex=="yes") {
		 tmq("update media set reindexstatus='no' where importid='$ID'");
	}
	if ($contindex=="yes") {
		 //find current page
		 $calpage =tmq("select id from media where importid='$ID' and reindexstatus='yes' " );
		 $page=floor(tmq_num_rows($calpage) / $indexpertime);
	}


	if ($ID=="[EMPTY]") {
		$ID="";
	}
	if ($page=="") {
		$page=1;
	}

	$sql_count="select count(*) as tmpqcount from media where importid='$ID'";
	$result = tmq($sql_count,false); 
	$result=tmq_fetch_array($result);
	$n = floor($result[tmpqcount]); 
	

//$s=tmq($sql);
//$n=tmq_num_rows($s);
$numset=ceil($n / $indexpertime);
$redirpath="index.php?reindexdone=$ID";
if ($n>$indexpertime) {
	if ($page>($numset+1)) {
		?><SCRIPT LANGUAGE="JavaScript">
		<!--
		alert("INDEX COMPLETED");
		//-->
		</SCRIPT><?php 
		redir("index.php?reindexdone=$ID",0);
      die;
	}

	?><BR><BR><CENTER><?php  echo getlang("เนื่องจากเป็นการ Index ข้อมูลจำนวนมาก จึงแบ่งการ Index ออกเป็น ::l::To re-index large amount of data, system will split index operation to"); ?><?php  echo $numset+1 ?> <?php  echo getlang("ครั้ง	ครั้งละ ประมาณ ::l::round. Estimated "); ?><BR>
<?php  echo $indexpertime ?> <?php  echo getlang("รายการ ขณะนี้เป็นการ Index รอบที่::l::records/round current round is"); ?>
 <?php  echo $page ?>/<?php  echo $numset +1?><BR>
	<?php  echo getlang("หลังจาก Index เสร็จใจแต่ละรอบ โปรแกรมจะเริ่มทำการ Index รอบต่อไปโดยอัตโนมัติ::l::. After finish this round system will continue automatically"); ?><BR><BR><BR>
	<FONT SIZE="" COLOR="#5D5D5D"><B><H1>[<?php  echo $page ?>/<?php  echo $numset +1?>]</H1></B></FONT><BR><TABLE width=700 align=center>
	<TR>
		<TD><?php 
	echo html_graph("V",$numset+1,$page,20,700,"#3DB66D");
	?></TD>
	</TR>
	</TABLE><BR><I>Indexing ....</I></CENTER><?php 
	$redirpath="reindex.php?ID=$ID&page=".($page+1);
}
ob_flush();
sleep(1);
$sql ="select id from media where importid='$ID' and reindexstatus='no' limit 0 , $indexpertime" ;
//$sql ="select id from media where importid='$ID' and reindexstatus='no' limit " . (($page-1)*$indexpertime) ." , $indexpertime" ;  
$s=tmq($sql);
	/*
function getmicrotime(){ 
list($usec, $sec) = explode(" ",microtime()); 
return ((float)$usec + (float)$sec); 
} */

while ($r=tmq_fetch_array($s)) {
/*
$time_start = getmicrotime();
*/
tmq("update media set reindexstatus='yes' where importid='$ID' and id='$r[id]' ");
	index_reindex($r[id]);
/*
$time_end = getmicrotime();
$time = $time_end - $time_start;

echo "Did nothing in $time seconds<BR>";
*/
}

/////////////////////////////////////////////

redir("$redirpath",1);

foot();
?>