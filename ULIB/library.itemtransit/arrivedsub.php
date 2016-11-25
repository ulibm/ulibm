<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="itemtransit-arrive";
include("arrived.inc.php");

$tmp=mn_lib();
//pagesection($tmp);

$mdtypedb=tmq_dump2("media_type","code","name"); //printr($mdtypedb);


$s=tmq("select * from itemtransit_main where id='$pid' ");
$s=tfa($s);
	$str="<b>$s[name]</b><br>";
	$str.=ymd_datestr($s[dt])."<BR>";
	$str.=get_library_name($s[loginid]);;

	$str2="";
	$s2=tmq("select distinct RESOURCE_TYPE,count(id) as cc  from media_mid where bcode in (select bcode from itemtransit_sub where pid='$pid' ) group by RESOURCE_TYPE ");
	while ($r2=tfa($s2)) {  
		$str2.= " &nbsp;&bull; ".getlang($mdtypedb[$r2[RESOURCE_TYPE]]) . " ".$r2[cc] ." รายการ <br>";
	}


	?><table align=center width=<?php  echo $_TBWIDTH;?>>
	<tr>
		<td><?php html_dialog($tmp,$str);?></td>
		<td><?php html_dialog("Detail",$str2);?></td>
	</tr>
	</table><?php 

$tbname="itemtransit_sub";


$c[1][text]="วันเวลา::l::date time";
$c[1][field]="dt";
$c[1][fieldtype]="autotime";
$c[1][descr]="";
$c[1][defval]="student";

$c[2][text]="บาร์โค้ดทรัพยากร::l::Item's Barcode";
$c[2][field]="bcode";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";
/*
$c[3][text]="สถานะ::l::Status";
$c[3][field]="status";
$c[3][fieldtype]="list:new,cancel,done";
$c[3][descr]="";
$c[3][defval]="new";
*/


$c[4][text]="-";
$c[4][field]="pid";
$c[4][fieldtype]="addcontrol";
$c[4][descr]="";
$c[4][align]="left";
$c[4][defval]=$pid;

//dsp

$dsp[2][text]="-";
$dsp[2][field]="id";
$dsp[2][align]="center";
$dsp[2][filter]="module:localcov";
$dsp[2][width]="10%";
function localcov($wh) {
	$chk=tmq("select * from media_mid where bcode='$wh[bcode]' ");
	$s="";
	if (tnr($chk)!=1) {
		$s.="<font  color=red>barcode note found</font>";
	} else {
		$chk2=tfa($chk);
		//printr($chk2);
		$s.=res_cov_dsp($chk2[pid]);
	}
	return "$s";
}


$dsp[1][text]="รายละเอียด::l::Detail";
$dsp[1][field]="id";
$dsp[1][filter]="module:localdet";
$dsp[1][width]="70%";
function localdet($wh) {
	global $dcrURL;
	global $mdtypedb;
	$chk=tmq("select * from media_mid where bcode='$wh[bcode]' ");
	$s="<b>[$wh[bcode]]</b> [$wh[status]] ";
	if (tnr($chk)!=1) {
		$s.="<font  color=red>barcode note found</font>";
	} else {
		$chk2=tfa($chk);
		$s.="(".getlang($mdtypedb[$chk2[RESOURCE_TYPE]]).")";
		$s.="<a href='$dcrURL"."dublin.php?ID=$chk2[pid]&item=$wh[bcode]' target=_blank>".marc_gettitle($chk2[pid])."</a>";
	}
	$s.="<br>";
	$s.=ymd_datestr($wh[dt]);
	$s.="<br>";
	$slog=tmq("select * from itemtransit_sub_status where pid='$wh[id]' order by dt  ");
	while ($slogr=tfa($slog)) {
		$s.=" <font class=smaller2>&bull; Status=".$slogr[status]." at ".ymd_datestr($slogr[dt])." by ".get_library_name($slogr[loginid])."<br></font>";
	}
	return $s;
}
$dsp[3][text]="รับ::l::Set Arrived";
$dsp[3][align]="center";
$dsp[3][field]="id";
$dsp[3][filter]="module:localarrived";
$dsp[3][width]="10%";
function localarrived($wh) {
	global $PHP_SELF;
	if ($wh[status]=="new") {
		return "<a href='$PHP_SELF?scanbc=$wh[bcode]&pid=$wh[pid]&issave=yes'>".getlang("ลงรับ::l::Set Arrived")."</a>";
	} else {
		return "-";
	}
}

//printr($_POST);
$now=time();
if ($issave=="yes" && trim($scanbc)!="" ) {
	$chk=tmq("select * from media_mid where bcode='$scanbc' ");
	if (tnr($chk)!=1) {
		html_dialog("Error","Unknown barcode [$scanbc]");
	} else {
		$chkexist=tmq("select * from itemtransit_sub where pid='$pid' and bcode='$scanbc' ");
		if (tnr($chkexist)==1) {
			$chkexist=tfa($chkexist);
			local_setarrive($chkexist[id]);

		} else {
			html_dialog("Error","This Barcode not In Transit [$scanbc]");
		}
	}
}
//$chk;
$randidjs="aa".randid();
?><form method="post" action="<?php  echo $PHP_SELF?>">
<input type="hidden" name="issave" value="yes">
<input type="hidden" name="pid" value="<?php  echo $pid;?>">
	<table align=center width="<?php  echo $_TBWIDTH?>" class=table_border>
<tr>
	<td>Scan Item's Barcode <input type="text" name="scanbc" ID="<?php  echo $randidjs?>"> <input type="submit" value="Recieve"></td>
</tr>
</table>
</form><?php 


fixform_tablelister($tbname," 1 and pid='$pid' ",$dsp,"no","no","no","pid=$pid",$c,"",$o);
?><center><a href="arrived.php" class=a_btn><?php echo getlang("กลับ::l::Back");?></a></center><?php 
?><script type="text/javascript">
<!--
	tmp=getobj("<?php  echo randidjs;?>");
	tmp.focus();
//-->
</script><?php 
foot(); 
?>