<?php 
include("../../inc/config.inc.php");
include("./_conf.php");
head();
        mn_root("havester");

tmq("
CREATE TABLE IF NOT EXISTS `ulibhavestlist` (
  `id` double NOT NULL auto_increment,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `brief` varchar(255) NOT NULL,
  `stat` varchar(255) NOT NULL,
  `url` longtext NOT NULL,
  `url_bibid` longtext NOT NULL,
  `dt` double NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `code_2` (`code`)
)");
tmq("
CREATE TABLE IF NOT EXISTS `media_havest_id` (
  `id` double NOT NULL auto_increment,
  `bibid` varchar(255) NOT NULL,
  `hashed` longtext NOT NULL,
  `havestpid` varchar(255) NOT NULL,
  `lastupdate` double NOT NULL,
  `lastcheckrelation` double NOT NULL,
  PRIMARY KEY  (`id`)
) ");

if ($cmd=="clearlasttime") {
	tmq("update ulibhavestlist set dt=0 where code='$code';");
}
if ($cmd=="clearHolding") {
	tmq("delete from media_havest_id where havestpid='$code';");
}
	///chkcompatible cli
		$s=tmq("show columns from index_db where Field ='havestlist' ");
		if (tmq_num_rows($s)==0) {
			tmq("ALTER TABLE  index_db ADD  havestlist LONGTEXT NOT NULL ;");
		}
		$s=tmq("show columns from media where Field ='keyid' ");
		if (tmq_num_rows($s)==0) {
			tmq("ALTER TABLE  media ADD  keyid LONGTEXT NOT NULL ;");
		}
		$s=tmq("show columns from media where Field ='masterfrom' ");
		if (tmq_num_rows($s)==0) {
			tmq("ALTER TABLE  media ADD  masterfrom LONGTEXT NOT NULL ;");
		}
		//$s=tmq_fetch_array($s);printr($s);
	///chkcompatible end


$tbname="ulibhavestlist";


$c[2][text]="code";
$c[2][field]="code";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[6][text]="ชื่อย่อ";
$c[6][field]="brief";
$c[6][fieldtype]="text";
$c[6][descr]="";
$c[6][defval]="";


$c[3][text]="name";
$c[3][field]="name";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="";

$c[4][text]="Url::l::Url";
$c[4][field]="url";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="";

$c[5][text]="Url for Bib-Address";
$c[5][field]="url_bibid";
$c[5][fieldtype]="longtext";
$c[5][descr]=" [bibid] for \$bibid";
$c[5][defval]="";


//dsp


$dsp[7][text]="Icon";
$dsp[7][field]="id";
$dsp[7][width]="5%";
$dsp[7][filter]="module:local_upload";

$dsp[3][text]="Code";
$dsp[3][field]="code";
$dsp[3][width]="7%";
/*
$dsp[4][text]="Url::l::Url";
$dsp[4][field]="url";
$dsp[4][width]="30%";
*/
$dsp[6][text]="name";
$dsp[6][field]="name";
$dsp[6][filter]="module:local_detail";
$dsp[6][width]="50%";


function local_upload($wh) {
	global $dcrs;
	global $dcrURL;
	$s="<A HREF='upload.php?mediatypemanage=$wh[code]'><img border=0 width=48 height=48 src='";
	if (file_exists("$dcrs/_tmp/havestclientlogo-$wh[code].png")==true) {
		$s.= "$dcrURL/_tmp/havestclientlogo-$wh[code].png";
	} else {
		$s.=  "$dcrURL/_tmp/mediatype.png";
	}
	$s.="'></A>";
	return $s;
	//
}

function local_cmd($wh) {

	return "<A HREF='run.php?code=$wh[code]' target=_blank><B>เปิดหน้าต่างอัพเดท</B></A> <BR>
	<A HREF='run-relcheck.php?code=$wh[code]' target=_blank><B>เปิดหน้าต่างตรวจสอบ</B></A> <BR>
	<A HREF='".$wh[url]."/_havester/cli/index.php?cmd=clearlasttime' target=_blank onclick=\"return confirm('all record has to be refetch?');\">ลบบันทึกเวลาที่ไซต์นี้</A> 
	<BR><A HREF='clientlist.php?cmd=clearlasttime&code=$wh[code]' onclick=\"return confirm('all record has to be refetch?');\">ลบบันทึกเวลาล่าสุด</A> 
	<BR><A HREF='clientlist.php?cmd=clearHolding&code=$wh[code]' onclick=\"return confirm('all holding record has to be Deleted?') && confirm('confirm again');\">ลบข้อมูลการ Holding ทั้งหมด</A>";

}

function local_detail($wh) {
	//$percent=floor(percent_cal($c1,$c2));
	return "$wh[name]<BR><FONT class=smaller>$wh[url]</FONT>";
	//
	$c1=number_format(tmq_num_rows(tmq("select id from  media_havest_id where havestpid='$wh[code]' ")));
	$c2=number_format(tmq_num_rows(tmq("select id from  media where masterfrom='$wh[code]' ")));
	//$percent=floor(percent_cal($c1,$c2));
	return "$wh[name]<BR><FONT class=smaller>Holding ปัจจุบัน $c1, ต้นฉบับ MARC $c2 รายการ </FONT>";

}

$dsp[10][text]="Command";
$dsp[10][field]="id";
$dsp[10][filter]="module:local_cmd";
$dsp[10][width]="30%";

?><CENTER><A HREF="updater.php">เปิดหน้าต่างอัพเดท (ทุกไซต์)</A></CENTER><?php 
fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c);


foot();
?>