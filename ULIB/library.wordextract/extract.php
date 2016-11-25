<?php 
    ;
ini_set("max_execution_time",600);
	include ("../inc/config.inc.php");
	$_REQPERM="wordextract";
	$tmp=mn_lib();
	pagesection($tmp);

$indexpertime=getval("_SETTING","subjextracteachround");

	if ($ID=="[EMPTY]") {
		$ID="";
	}
	if ($page=="") {
		$page=1;
	}
     $sql ="select id from media where importid='$ID'" ;  


$s=tmq($sql);
$n=tmq_num_rows($s);
$numset=ceil($n / $indexpertime);
$redirpath="index.php";
if ($n>$indexpertime) {
	if ($page>($numset+1)) {
		?><SCRIPT LANGUAGE="JavaScript">
		<!--
		alert("EXTRACT COMPLETE");
		//-->
		</SCRIPT><?php 
		redir("index.php",0);
		die;
	}
	head();
	mn_root("subjextract");

	?><BR><BR><CENTER><?php  echo getlang("เนื่องจากเป็นการ extract ข้อมูลจำนวนมาก จึงแบ่งการ extract ออกเป็น ::l::To extract large amount of data, system will split extract operation to"); ?><?php  echo $numset+1 ?> <?php  echo getlang("ครั้ง	ครั้งละ ประมาณ ::l::round. Estimately "); ?> <BR>
<?php  echo $indexpertime ?> <?php  echo getlang("รายการ ขณะนี้เป็นการ extract รอบที่::l::records/round current round is"); ?> 
<?php  echo $page ?>/<?php  echo $numset +1?><BR>
	<?php  echo getlang("หลังจาก extract เสร็จใจแต่ละรอบ โปรแกรมจะเริ่มทำการ extract รอบต่อไปโดยอัตโนมัติ::l::. After finish this round system will continue automatically"); ?><BR><BR><BR>
	<FONT SIZE="" COLOR="#5D5D5D"><B><H1>[<?php  echo $page ?>/<?php  echo $numset +1?>]</H1></B></FONT><BR></CENTER><?php 
	foot();
	$redirpath="extract.php?ID=$ID&page=".($page+1);
}

//$tagsubj=getval("MARC","SUBJTAG");
$tagsubj=tmq_dump("bkedit","fid","fid","where kw='on' ");
$tagcalln=tmq_dump("bkedit","fid","fid","where index01='on' ");
//printr($tagsubj); 
//printr($tagcalln);
$tagsubj=array_diff($tagsubj,$tagcalln);
//printr($tagsubj); 
//die;
$tagsubj=implode(',\'\n\',',$tagsubj);

$sql ="select concat($tagsubj) as allsubjects from media where importid='$ID'  limit " . (($page-1)*$indexpertime) ." , $indexpertime" ;  
$s=tmq($sql,false);
	
$importdt=time();
while ($r=tmq_fetch_array($s)) {

	$data=$r[allsubjects];
	$data=explodenewline($data);
	$data=arr_filter_remnull($data);
	//printr($data);
	while (list($k,$v)=each($data)) {
		$tmpsf=marc_getsubfields($v,"no");
		//printr($tmpsf); die;
		while (list($k2,$v2)=each($tmpsf)) {
			$word=trim($v2," /.-[]()#%+*=_:;");
			$word=addslashes($word);

			$tmp=tmq("select id from indexword where word1='".addslashes($word)."' ",false);
			$tmp=tmq_num_rows($tmp);
			if ($tmp==0 && strlen($word)>3) {
				tmq("insert delayed into indexword set word1='".addslashes($word)."',usoundex='".usoundex_get($word)."' ,importdt='$importdt',mid='$r[ID]',importid='$ID' ");
			}
		}
	}
}

//die;
/////////////////////////////////////////////

redir("$redirpath",1);

?> 