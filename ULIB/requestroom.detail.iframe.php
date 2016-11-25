<?php 
;
include("./inc/config.inc.php");
$dat=floor($dat);
$mon=floor($mon);
$yea=floor($yea);

html_start();
//include("_REQPERM.php");
$_REQPERM="rqroom_display";
//loginchk_lib();
$allmaintbcodeorig=$allmaintbcode;
?>
<table border="0" cellpadding="0" cellspacing="0" width=780 align=center class=table_border>

<tr><td class=table_head width=30%><?php  echo getlang("วันที่::l::Date")?></td>
<td class=table_td><?php 
echo ymd_datestr(ymd_mkdt($dat,$mon,$yea),'date');
?></td></tr>
<tr><td class=table_head width=30%><?php  echo getlang("ช่วงเวลา::l::Period")?></td>
<td class=table_td><?php 
		$s2=tmq("select * from rqroom_periodinfo where maintb='$iframe_maintb' and code='$iframe_period' ",false);
		if (tmq_num_rows($s2)!=1) { die("rqroom_periodinfo where maintb='$iframe_maintb' and code='$iframe_period' ");}
		$r2=tmq_fetch_array($s2);
		echo getlang($r2[name]);

?></td></tr>
</table>
<?php 
	//////////////////////plan img start
$spath="$dcrs/_tmp/rqroomfile_tp/$iframe_maintb.jpg";
//echo $spath;
if (file_exists($spath) ) {
	 echo "<img border=0 src='$dcrURL"."_tmp/rqroomfile_tp/$iframe_maintb.jpg' width=1000>";
}
//////////////////////plan img end
?>
<br />
<?php 
		$s2=tmq("select * from rqroom_roomsub where maintb='$iframe_maintb' order by ordr ",false);
		while ($r2=tmq_fetch_array($s2)) {
			$jsid="a".randid();

		$c=tmq("select * from rqroom_timetbi where maintb='$iframe_maintb' and period='$iframe_period' and keyid='$dat-$mon-$yea' and roomsub='$r2[code]' ",false);
			?><div id="root<?php  echo $jsid;?>" style="left:<?php  echo $r2[js_x]?>px; top:<?php  echo $r2[js_y]?>px; position: absolute; width:70;" class=table_border>
<div id="handle<?php  echo $jsid;?>" class=table_head><nobr class=smaller><?php  echo getlang($r2[name]);?></nobr></div>
<?php 
$str="";
if (tmq_num_rows($c)==0) {
	$str="<A HREF='requestroom.pick.php?roomid=$iframe_maintb&roomsub=$r2[code]&periodid=$iframe_period&dat=$dat&mon=$mon&yea=$yea' target=_top class=smaller2><img src='$dcrURL/neoimg/right32.png' align=absmiddle border=0 width=16> ";
	$str.=getlang("เลือก::l::Pick")."</A>";
	$bgcol="#D0FFCE";
} else {
	$c=tmq_fetch_array($c);
	$str="".getlang("จองแล้ว::l::Taken")."</a><BR>";
	$str.="<nobr class=smaller2>(".$c[loginid].")</nobr>";
	$bgcol="#FFE7CE";
}
echo "<TABLE width=100%>
<TR>
	<TD  bgcolor=$bgcol class=smaller2>$str</TD>
</TR>
</TABLE>";
?>
</div>
<?php 
		}
	
?>