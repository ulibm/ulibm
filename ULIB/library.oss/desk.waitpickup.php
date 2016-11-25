<?php 
include("../inc/config.inc.php");
html_start();
include ("./inc.php");

?><style>
* {
	font-size: 13px!important;
}
</style><?php 

$tbname="member";



//dsp
/*
$dsp[4][text]="วันที่";
$dsp[4][field]="dt";
$dsp[4][filter]="module:localdt";
$dsp[4][width]="15%";
function localdt($wh) {
	return ymd_datestr($wh[dt],"shortd")."<br>".ymd_ago($wh[dt]);
}
*/
$dsp[3][text]="ผู้ขอใช้";
$dsp[3][field]="name";
$dsp[3][filter]="module:local_name";
$dsp[3][width]="30%";


function local_name($wh) {
	$s=tmq("select * from member where UserAdminID='$wh[UserAdminID]' ");
	$s=tfa($s);
	$res="";
	$res.= get_member_name($wh[UserAdminID]);
	if ($s[email]!="") {
		$res.= "<br><a href='mailto:$s[email]'>Email:$s[email]</a>";
	}
	return $res;
}

$dsp[2][text]="รายการคำขอ::l::Requests";
$dsp[2][field]="id";
$dsp[2][filter]="module:local_request";
$dsp[2][width]="70%";

function local_request($wh) {
	$res="<form method=post action='processpickup.php'>
	<input type=hidden name='cardid' value='$wh[UserAdminID]'>
		<table>
	";
	$s=tmq("select * from oss_req where cardid='$wh[UserAdminID]' and stat='waitpickup' ");
	$sum=0;
	$count=tmq_num_rows($s);
	while ($r=tfa($s)) {
		$tmp=explode("Author:",$r[mat_info]);
		//printr($tmp);
		$tmp=$tmp[0];
		$res.="<tr>
		<td><input type=checkbox name='paylist[]' value='$r[id]'
		style='height: 16px!important' checked></td>
		<td><a href='checkmatresult.php?id=$r[id]' notarget=_blank>".substr($tmp,0,60)."</a></td>
		<td width=70>".number_format($r[fee],2)."</td>
	</tr>";
		$sum=$sum+$r[fee];
	}
	$res.="
	</table>
	 &bull;  รวม <b>".number_format($count)."</b> รายการ  <input type=submit value='คลิกที่นี่เพื่อบันทึกการรับ'></form>";
	return "$res";
}
/*
$dsp[5][text]="สถานะ";
$dsp[5][field]="ordr";
$dsp[5][width]="30%";
$dsp[5][filter]="module:local_stat";


function local_stat($wh) {
	$s="";
	global $statusdb;//printr($statusdb);
	$s.= $statusdb[$wh[stat]];
		$s.="<br>
<a href='updatepaystatus.php?id=$wh[id]'>คลิกเพื่อทำรายการ</a>";

	return "$s";
}*/
$limit=" UserAdminID<>'' and UserAdminID in (select cardid from oss_req where stat='waitpickup' ) ";
$kw=trim($kw);
if ($kw!="") {
	$limit.="  and idcard = '$kw'";
}
?><center><form method="post" action="<?php  echo $PHP_SELF?>" style="margin-bottom: 0px;">
	<input type="text" name="kw" value="<?php  echo $kw?>"> <input type="submit" value="ค้นหา">
</form></center><?php 
$_TBWIDTH="100%";
fixform_tablelister($tbname,$limit,$dsp,"no","no","no","kw=$kw",$c,"id desc");
include("desk.inc.ifupdater.php");


//foot();
?>