<?php 
include("../inc/config.inc.php");
$printview=floor($printview);
if ($printview!=0) {
	html_start();
	$s=tmq("select * from itemtransit_main where id='$printview' ");
	$s=tfa($s);
	$str="<b>$s[name]</b><br>";
	$str.=" จัดส่งไปยัง <b>".get_libsite_name($s[dest])."</b><br>";
	$str.=ymd_datestr($s[dt])."<BR>";
	$str.=get_library_name($s[loginid])."<br>".stripslashes($s[note]);
	echo $str;
	if (strtolower($s[isperm])=="yes") {
		echo "** นำส่งถาวร (ส่งและย้ายสถานะจัดเก็บ)";
	}
	$mdtypedb=tmq_dump2("media_type","code","name"); //printr($mdtypedb);
	$s2=tmq("select distinct RESOURCE_TYPE,count(id) as cc  from media_mid where bcode in (select bcode from itemtransit_sub where pid='$printview' ) group by RESOURCE_TYPE ");
	while ($r2=tfa($s2)) {  
		//printr($r2);
		echo " &nbsp;&bull; ".getlang($mdtypedb[$r2[RESOURCE_TYPE]]) . " ".$r2[cc] ." รายการ <br>";
	}
	$s3=tmq("select * from itemtransit_sub where pid='$printview' order by  id ");
	?><table width=100% border=1 cellspacing=0>
<tr>
		<td>Barcode</td>
		<td>ประเภททรัพยากร</td>
		<td>ชื่อเรื่อง</td>
	</tr>	<?php 
	while ($r3=tfa($s3)) {  
		?><tr>
		<td><?php  echo $r3[bcode]?></td>
		<td><?php  
		$item=tmq("select * from media_mid where bcode='$r3[bcode]' ");	
		$item=tfa($item);
		echo getlang($mdtypedb[$item[RESOURCE_TYPE]]) ;?></td>
		<td><?php  echo marc_gettitle($item[pid])?></td>
	</tr><?php 
	}
	?>
	</table><?php 
	die;
}
head();
$_REQPERM="itemtransit-main";
$tmp=mn_lib();
pagesection($tmp);

$clearall=floor($clearall);
if ($clearall!=0) {
	tmq("delete from itemtransit_sub where pid='$clearall' ");
	html_dialog("Information","Clear item for ID=$clearall");
}
$setstatusall=floor($setstatusall);
if ($setstatusall!=0 && $setto!="") {
	if ($setto=="new") {
		tmq("update itemtransit_sub set status='new' where pid='$setstatusall' and status='cancel' ");
		$s=tmq("select * from itemtransit_sub where pid='$setstatusall'  and status='cancel'");
	}
	if ($setto=="cancel") {
		tmq("update itemtransit_sub set status='cancel' where pid='$setstatusall' and status='new' ");
		$s=tmq("select * from itemtransit_sub where pid='$setstatusall' and status='new' ");
	}
	$now=time();
	while ($r=tfa($s)) {
		tmq("insert into itemtransit_sub_status set pid='$r[id]' , status='$setto', dt='$now',loginid='$useradminid'  ");
	}
	html_dialog("Information","Set all status to $setto, for ID=$setstatusall");
}

$tbname="itemtransit_main";


$c[1][text]="วันเวลา::l::date time";
$c[1][field]="dt";
$c[1][fieldtype]="autotime";
$c[1][descr]="";
$c[1][defval]="student";

$c[2][text]="ชื่อรายการ::l::Name";
$c[2][field]="name";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="Transit-".strip_tags(ymd_datestr(time(),"shortd"));

$c[3][text]="Librarian";
$c[3][field]="loginid";
$c[3][fieldtype]="autoofficer";
$c[3][descr]="";
$c[3][defval]="";

$c[5][text]="ย้ายถาวรหรือไม่::l::Permanent Transit";
$c[5][field]="isperm";
$c[5][fieldtype]="yesno";
$c[5][descr]="<br>".getlang("หากเป็นการย้ายถาวร จะทำการเปลี่ยนสถานที่จัดเก็บทรัพยากรอัตโนมัติ::l::If permanent' item place will be updated");
$c[5][defval]="NO";

$c[4][text]="สาขาห้องสมุดปลายทาง::l::Destination campus";
$c[4][field]="dest";
$c[4][fieldtype]="foreign:-localdb-,library_site,code,name,displaykey,displaykey,displaykey";
$c[4][descr]="";
$c[4][defval]=$LIBSITE;

$c[44][text]="Note";
$c[44][field]="note";
$c[44][fieldtype]="longtext";
$c[44][descr]="";
$c[44][defval]="";

//dsp


$dsp[1][text]="รายละเอียด::l::Detail";
$dsp[1][field]="id";
$dsp[1][filter]="module:localdet";
$dsp[1][width]="35%";
function localdet($wh) {
	$s="<b>$wh[name]</b><br>";
	$s.=ymd_datestr($wh[dt])."<BR>";
	$s.=get_library_name($wh[loginid])." <font class=smaller>".$wh[note]."</font>";

	return $s;
}

$dsp[2][text]="จัดการไอเทม::l::Manage Item";
$dsp[2][field]="id";
$dsp[2][align]="center";
$dsp[2][filter]="module:localmanitem";
$dsp[2][width]="30%";
function localmanitem($wh) {
	global $PHP_SELF;
	$cc=tmq("select count(id) as cc from itemtransit_sub where pid=$wh[id]");
	$ccr=tfa($cc);
	$ccrn=floor($ccr[cc]);
	$statusnew=tmq("select count(id) as cc from itemtransit_sub where pid='$wh[id]' and status='new' ");
	$statusnew=tfa($statusnew);
	$statusnew=floor($statusnew[cc]);
	$statusdone=tmq("select count(id) as cc from itemtransit_sub where pid='$wh[id]' and status='done' ");
	$statusdone=tfa($statusdone);
	$statusdone=floor($statusdone[cc]);
	$statuscancel=tmq("select count(id) as cc from itemtransit_sub where pid='$wh[id]' and status='cancel' ");
	$statuscancel=tfa($statuscancel);
	$statuscancel=floor($statuscancel[cc]);
	return "<a href='mansub.php?pid=$wh[id]'>".getlang("จัดการ::l::Manage")."</a> ($ccrn)<br>
	<a href='$PHP_SELF?clearall=$wh[id]' class='smaller2 a_btn' >".getlang("เคลียร์ไอเทม::l::Clear Items")."</a> <a href='$PHP_SELF?printview=$wh[id]' class='smaller2 a_btn' target=_blank>".getlang("Print view")."</a><br>
	<font class=smaller>".getlang("ตั้งสถานะเป็น::l::Set status to").":</font>
	<a href='$PHP_SELF?setstatusall=$wh[id]&setto=new' class='smaller2 a_btn' >new</a>
	<a href='$PHP_SELF?setstatusall=$wh[id]&setto=cancel' class='smaller2 a_btn' >cancel</a><br>
	<font class=smaller>new=$statusnew / done=$statusdone / cancel=$statuscancel</font>
	";
}
$dsp[3][text]="ย้ายถาวรหรือไม่::l::Is Permanent";
$dsp[3][field]="isperm";
$dsp[3][align]="center";
$dsp[3][filter]="switchsingle";
$dsp[3][width]="10%";

fixform_tablelister($tbname," 1 ",$dsp,"yes","yes","yes","mi=$mi",$c,"",$o);

foot(); 
?>