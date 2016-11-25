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
	$res="<form method=post action='processpay.php'>
	<input type=hidden name='cardid' value='$wh[UserAdminID]'>
		<table width=100%>
	";
	$s0=tmq("select distinct pay_transid from oss_req where cardid  in (select distinct cardid from oss_req where cardid='$wh[UserAdminID]' and pay_transid<>'' ) ");
	$sum=0;
	while ($r0=tfa($s0)) {
		if ($r0[pay_transid]=="") { continue;}
		$s=tmq("select * from oss_req where cardid='$wh[UserAdminID]' and pay_transid='$r0[pay_transid]'  ");
		//$dspdt=tmq("select * from oss_pay where pay_transid='$r0[pay_transid]' ");
		$dspdt=tmq("select * from finedone where idid='$r0[pay_transid]' ");
		$r00=tfa($dspdt);
		$dspdt=$r00[dt];
		$dspdt=ymd_datestr($dspdt);
		$res.="<tr>
			<td bgcolor=#f2f2f2 colspan=3><b>&nbsp; ".$dspdt."<!-- $r0[pay_transid] --></b>
			&bull;  รวม <font>".number_format($r00[cach],2)."</font> บาท <font>".number_format($r00[credit],2)."</font> credit";
	if ($r00[fine]!=$r00[fine]) {
		$res.=" <font  color=darkred>ชำระจริง <b>".number_format($r00[fine],2)."</b> บาท</font>";
	}
	$res.="

			</td>
		</tr>";
		while ($r=tfa($s)) {
			$tmp=explode("Author:",$r[mat_info]);
			//printr($tmp);
			$tmp=$tmp[0];
			$res.="<tr>
			<!-- <td><input type=checkbox name='paylist[]' value='$r[id]'
			style='height: 16px!important' checked></td> -->
			<td> &nbsp; &nbsp; &nbsp;<a href='checkmatresult.php?id=$r[id]' notarget=_blank>".substr(dspmarc($tmp),0,55)."</a></td>
			<td width=70 align=right>".number_format($r[fee],2)." <!-- --$r[pay_transid] --></td>
			<td width=50>&nbsp;</td>
		</tr>";
			$sum=$sum+$r[fee];
		}

	}
	$res.="
	</table>
	 <!-- &bull;  รวม <b>".number_format($sum,2)."</b> บาท -->";
	  

	 
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


$limit=" UserAdminID<>'' and UserAdminID in (select cardid from oss_req where pay_transid<>'' ) ";

$kw=trim($kw);
if ($kw!="") {
	$limit.="  and UserAdminID = '$kw'";
}
?><style>
TD {
vertical-align: top;
}
</style>
<center><form method="post" action="<?php  echo $PHP_SELF?>" style="margin-bottom: 0px;">
	<input type="text" name="kw" value="<?php  echo $kw?>"> <input type="submit" value="ค้นหา">
</form></center><?php 
$_TBWIDTH="100%";
fixform_tablelister($tbname,$limit,$dsp,"no","no","no","kw=$kw",$c,"id desc");
include("desk.inc.ifupdater.php");


//foot();
?>