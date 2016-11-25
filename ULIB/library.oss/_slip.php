<?php 
	; 
		
    include ("../inc/config.inc.php");
	$s=tmq("select * from oss_mem where cardid='$id' ");
	$s=tfa($s);
	html_start();

?><table width=600 align=center class=table_border>
<tr>
	<td class=table_head>ชื่อ</td>
	<td class=table_td><?php  echo $s[name]?></td>
</tr>
<tr>
	<td class=table_head>รหัสประจำตัวประชาชน</td>
	<td class=table_td><?php  echo $s[cardid]?></td>
</tr>
<tr>
	<td class=table_head>Email</td>
	<td class=table_td><?php  echo $s[email]?></td>
</tr>
<tr>
	<td class=table_head>เบอร์โทร</td>
	<td class=table_td><?php  echo $s[tel]?></td>
</tr>
<tr>
	<td class=table_head>คณะ/หน่วยงาน</td>
	<td class=table_td><?php  echo $s[fac]?></td>
</tr>
<tr>
	<td class=table_td align=center>วันที่สมัคร</td>
	<td class=table_td><?php  echo ymd_datestr($s[dt])?></td>
</tr>
</table>
<?php  pagesection("รายการที่เคยทำรายการ");



$tbname="oss_req";



//dsp

$dsp[4][text]="วันที่";
$dsp[4][field]="dt";
$dsp[4][filter]="date";
$dsp[4][width]="15%";


$dsp[2][text]="ชื่อ (ข้อความ)::l::Name (Place name)";
$dsp[2][field]="mat_info";
$dsp[2][width]="30%";

$dsp[5][text]="สถานะ";
$dsp[5][field]="ordr";
$dsp[5][width]="20%";
$dsp[5][filter]="module:local_stat";


function local_name($wh) {
	$s=tmq("select * from oss_mem where cardid='$wh[cardid]' ");
	$s=tfa($s);
	return $s[name];
}
function local_stat($wh) {
	return "$wh[stat]";
}


$limit=" cardid='$id' ";

fixform_tablelister($tbname,$limit,$dsp,"no","no","no","id=$id",$c,"id desc");


?>