<?php 
    ;
ini_set("max_execution_time",600);
	include ("../inc/config.inc.php");

if ($setconfig=="yes") {
	barcodeval_set("importitem[libsite]",$importitem[libsite]);
	barcodeval_set("importitem[status]",$importitem[status]);
	barcodeval_set("importitem[onbcdup]",$importitem[onbcdup]);
	barcodeval_set("importitem[itemplace]",$importitem[itemplace]);
	barcodeval_set("importitem[doafter]",$importitem[doafter]);
} 
	$set_libsite= barcodeval_get("importitem[libsite]");
	$set_status= barcodeval_get("importitem[status]");
	$set_onbcdup= barcodeval_get("importitem[onbcdup]");
	$set_itemplace= barcodeval_get("importitem[itemplace]");
	$set_doafter= barcodeval_get("importitem[doafter]");

$itemlocatetag=getval("MARC","itemlocatetag");

$indexpertime=getval("_SETTING","indexeachround");

	if ($ID=="[EMPTY]") {
		$ID="";
	}
	if ($page=="") {
		$page=1;
	}
     $sql ="select id from media where importid='$ID' and length($itemlocatetag)>5" ;  

$s=tmq($sql);
$n=tmq_num_rows($s);
$numset=ceil($n / $indexpertime);
$redirpath="index.php";
if ($n>$indexpertime) {
	if ($page>($numset+1)) {
		?><SCRIPT LANGUAGE="JavaScript">
		<!--
		alert("IMPORT-ITEM COMPLETE");
		//-->
		</SCRIPT><?php 
		redir("index.php",0);
		die;
	}
	head();
	include("_REQPERM.php");
	mn_lib();

	?><BR><BR><CENTER><?php  echo getlang("เนื่องจากเป็นการ import ข้อมูลจำนวนมาก จึงแบ่งการ import ออกเป็น ::l::To import large amount of data, system will split import operation to"); ?><?php  echo $numset+1 ?> <?php  echo getlang("ครั้ง	ครั้งละ ประมาณ ::l::round. Estimately "); ?> <BR>
<?php  echo $indexpertime ?> <?php  echo getlang("รายการ ขณะนี้เป็นการ import รอบที่::l::records/round current round is"); ?> 
<?php  echo $page ?>/<?php  echo $numset +1?><BR>
	<?php  echo getlang("หลังจาก import เสร็จใจแต่ละรอบ โปรแกรมจะเริ่มทำการ import รอบต่อไปโดยอัตโนมัติ::l::. After finish this round system will continue automatically"); ?><BR><BR><BR>
	<FONT SIZE="" COLOR="#5D5D5D"><B><H1>[<?php  echo $page ?>/<?php  echo $numset +1?>]</H1></B></FONT><BR></CENTER><?php 
	foot();
	$redirpath="extractitem.php?ID=$ID&page=".($page+1);
}

$sql ="select $itemlocatetag,ID from media where importid='$ID' and length($itemlocatetag)>5 limit " . (($page-1)*$indexpertime) ." , $indexpertime" ;  
$s=tmq($sql,false);

	$a2z=str_replace(',','',$_STR_A_Z);
	$a2zu=strtoupper("$a2z");
	$a2zth=str_replace(',','',$_STR_A_Zth);
$importdt=time();
$dt=time();
$dt_str=floor(date('d')).'-'.floor(date('m')).'-'.floor(date('Y'));
while ($r=tmq_fetch_array($s)) {
	$data=$r[$itemlocatetag];
	$data=explodenewline($data);
	while (list($k,$v)=each($data)) {
		$word=$v;
		$v2=addslashes($v);
		$word=marc_getsubfields($v);
		$word[p]=trim(trim($word[p]),"$a2zu");
		$word[p]=trim($word[p],"$a2z");
		$word[p]=trim($word[p],"$a2zth");
		$word[i]=trim($word[i]);
		$word[g]=trim($word[g]);
		$word[a]=trim($word[a]);
		$word[b]=trim($word[b]);
		$word[l]=trim($word[l]);

		//printr($word);

		$sql_insert="insert into media_mid set price='$word[p]' ,libsite='$set_libsite', status='$set_status' , place='$set_itemplace' , adminnote='$v2' ";
		if ($word[g]!="") {
			$sql_insert.=" , inumber='ฉ. $word[g]' ";
		}
		$sql_insert.=" , calln='$word[a] $word[b]' ";
		$sql_insert.=" , dt='$dt' ";
		$sql_insert.=" , RESOURCE_TYPE='$word[l]' ";
		$sql_insert.=" , dt_str='$dt_str' ";
		$sql_insert.=" , pid='$r[ID]' ";
		//echo "[$sql_insert]";

		$tmp=tmq("select id from media_mid where bcode='".addslashes($word[i])."' ",false);
		$tmp=tmq_num_rows($tmp);
		if ($tmp!=0 ) {
			if ($set_onbcdup=="emptybc") {
				tmq($sql_insert);
			} elseif ($set_onbcdup=="add") {
				$sql_insert.=" , bcode='$word[i]' ";
				tmq($sql_insert);
			} elseif ($set_onbcdup=="ignore") {
			}
		} else {
			$sql_insert.=" , bcode='$word[i]' ";
			tmq($sql_insert);
		}
	}
	if ($set_doafter=="delete") {
		tmq("update media set $itemlocatetag='' where ID='$r[ID]' ");
	}
}

/////////////////////////////////////////////

redir("$redirpath",2);

?> 