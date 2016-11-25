<?php 
include("cfg.inc.php");
include("head.php");

if ($mode=="view") {
	?><TABLE width=700 align=center>
	<TR>
		<TD><?php 
$s=tmq("select * from data where id='$id'");
$s=tfa($s);
echo "<B style='font-size:20;color:darkblue;'>$s[name]</B><BR>";
echo "<B style='font-size:15;color:blace;'>อัพโหลดโดย : ".get_member_name($s[loginid])."</B><BR>";
echo "<B style='font-size:15;color:blace;'>เมื่อ : ".ymd_datestr($s[dt])."</B><BR><BR>";

echo "$s[dat]";
die;
?></TD>
	</TR>
	</TABLE><?php 
}

	?><CENTER><FORM method="post" action="search.php">กรุณาใส่คำที่ต้องการสืบค้น 1 บรรทัดต่อ 1 การค้นหา<BR>
	<TEXTAREA name="kw" rows="9" cols="100"><?php  echo $kw;?></TEXTAREA><BR><INPUT type="submit" value=" ค้นหา">
		
	</FORM></CENTER><?php 
$kw=trim($kw);
if ($kw=="") {
	die;
}

$kwa=explode("
",$kw);
@reset($kwa);
?><TABLE width=800 align=center border=0>
<TR>
	<TD><?php 
while (list($k,$v)=each($kwa)) {
	$v=trim($v);
	if ($v=="") continue;
	echo "<DIV style='display:block; background-color: #e5e5e5; widht:100%'>
		
	<FONT style='color:black;font-size:20;'>ค้นหา:$v</FONT></DIV>";
	$smaster="select distinct pid as pidd from acqn_sub where titl like '%$v%' or isn like '%$v%' or auth like '%$v%' order by id asc ";
	$s=tmq($smaster);
	if (tnr($s)!=0) { echo "ค้นพบ ".tnr($s)." รายการ<BR>";} else {
		echo "<FONT  color=darkgreen style='font-size:15; font-weight:bold;'>ไม่พบข้อมูลซ้ำซ้อน</FONT>";
	}
	if (tnr($s)>10) { echo "แสดงผลการค้นหา 10 รายการแรก<BR>";}
	?><TABLE width=700 align=center border=0 cellpadding=0 cellspacing=0>
	<TR>
		<TD><?php 
		$countdsp=0;
	while ($r=tfa($s) ) {
		$countdsp++;
		if ($countdsp>10) continue;
		$pidinfo=tmq("select * from acqn where id='$r[pidd]' ");
		$pidinfo=tfa($pidinfo);
		$sthis="select * from acqn_sub where (titl like '%$v%' or isn like '%$v%' or auth like '%$v%' ) and pid='$r[pidd]' order by id desc ";
		$sthis=tmq($sthis);
		?><table width=100% class=table_border>
		<tr>
			<td class=table_head><?php  echo $pidinfo[name]?>
			<a href="sub.php?pid=<?php  echo $r[pidd];?>" target=_blank>คลิกเพื่อดู</a></td>
		</tr>
		<tr>
			<td><?php 
		while ($sthisr=tfa($sthis)) {
			echo "&bull; <a  href=\"javascript:void(null)\" onclick=\"window.open('viewsub.php?id=$sthisr[id]','viewsub','width=500,height=500');\">$sthisr[titl] $sthisr[auth] $sthisr[pub] $sthisr[yea]</a> <font style='border-color: ".$_s[$sthisr[stat]][color].";background-color: ".$_s[$sthisr[stat]][bg].";cursor: hand; cursor: pointer;;display: inline-block; border-width:1px; border-style: solid; width:120px;'>สถานะ ".$_s[$sthisr[stat]][name]."</font><br>";
		}	
		?></td>
		</tr>
		</table><?php 
	}
	//print_r("$v");
	?></div></TD>
</TR>
</TABLE><br><?php 
}

?></TD>
</TR>
</TABLE><BR><BR><BR>