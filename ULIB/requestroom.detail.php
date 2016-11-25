<?php 
;
include("./inc/config.inc.php");
head();
mn_web("requestroom");
$dat=floor($dat);
$mon=floor($mon);
$yea=floor($yea);
$allmaintbcodeorig=$allmaintbcode;

?>
<!-- <table border="0" cellpadding="0" cellspacing="0" width=780 align=center class=table_border>

<tr><td class=table_head width=30%><?php  echo getlang("วันที่::l::Date")?></td>
<td class=table_td><?php 
echo ymd_datestr(ymd_mkdt($dat,$mon,$yea),'date');
?></td></tr>
</table> -->
<?php 

if ($iframe_period!="") {
	?><CENTER><iframe width=1000 src="requestroom.detail.iframe.php?<?php 
	echo "mon=$mon&dat=$dat&yea=$yea&iframe_maintb=$iframe_maintb&iframe_period=$iframe_period&allmaintbcode=$allmaintbcodeorig";	
	?>" height=600></iframe></CENTER><?php 
	
	echo " <CENTER><B>[<A style='font-size: 20px; color: #FF6600' HREF='requestroom.predetail.php?mon=$mon&dat=$dat&yea=$yea&allmaintbcode=$allmaintbcode' target=_top>".getlang("กลับ::l::Back")."</A>]</B></CENTER>";

	foot();
	die;
}


$s="select * from rqroom_maintb where (0 ";
$allmaintbcode=explode(',',$allmaintbcode);
$allmaintbcode=arr_filter_remnull($allmaintbcode);
while (list($k,$v)=each($allmaintbcode)) {
	$s.= " or code='$v' ";
}
$s.=") and isshow='yes' order by name";
$s=tmq($s);
pagesection("กรุณาระบุห้อง/ห้องย่อย/ที่นั่ง ที่ต้องการจอง::l::Please choose room, seat you want to request");
while ($r=tmq_fetch_array($s)) {
	//printr($r);
	pagesection($r[name],"narrow");

	?><CENTER><?php  echo $r[descr];
	if (trim("$r[grantonly1]$r[grantonly2]$r[grantonly3]$r[grantonly4]")!="") {
		echo getlang("สงวนเฉพาะสมาชิก::l::Only for member type");
		echo "  : ";
		$mbtdb=tmq_dump("member_type","type","descr");
		if (trim($r[grantonly1])!="") { echo getlang($mbtdb[$r[grantonly1]]) ." &nbsp; "; }
		if (trim($r[grantonly2])!="") { echo getlang($mbtdb[$r[grantonly2]]) ." &nbsp; "; }
		if (trim($r[grantonly3])!="") { echo getlang($mbtdb[$r[grantonly3]]) ." &nbsp; "; }
		if (trim($r[grantonly4])!="") { echo getlang($mbtdb[$r[grantonly4]]) ." &nbsp; "; }
	}
	?></CENTER><TABLE width=780 align=center>
	<TR>
		<TD class=table_head  valign=middle><?php  echo getlang("ห้อง-ที่นั่ง/ช่วงเวลา::l::Room/Period");?></TD>
		<?php  
		$s2=tmq("select * from rqroom_periodinfo where maintb='$r[code]' order by ordr,name ");
		while ($r2=tmq_fetch_array($s2)) {
			echo "<TD class=table_head width=150  valign=bottom> ".getlang($r2[name])."<BR>";
  			$old=tmq("select * from rqroom_eventinfo where maintb='$r[code]' and period='$r2[code]' and keyid='$dat-$mon-$yea'  ",false);
  			$old=tmq_fetch_array($old);
			$old[text]=trim($old[text]);
			//printr($old);
			if (trim($old[text])!='' || $old[image]) {
				echo "<A HREF='requestroom.detail.read.php?ID=$old[id]' target=_blank>";
			}
				if (trim($old[text])!='') {
					 echo "<b>$old[text]</b><br />";
				}
				if ($old[image]!='') {
					 echo "<img src='$dcrURL/_tmp/rqroomfile/$old[image]' align=absmiddle border=0 width=120><br />";
				}
			echo "</A>";
			echo "<BR><A HREF='requestroom.detail.php?mon=$mon&dat=$dat&yea=$yea&allmaintbcode=$allmaintbcodeorig&iframe_maintb=$r[code]&iframe_period=$r2[code]' target=_top><img src='$dcrURL/neoimg/clock.png' align=absmiddle border=0 width=16><b > ";
			echo getlang("แสดงเฉพาะรอบ::l::Show Period")."</b></A>";
			
			echo "</TD>";
		}
	?>
	</TR>
		<?php  
		$s2=tmq("select * from rqroom_roomsub where maintb='$r[code]' order by ordr ",false);
		while ($r2=tmq_fetch_array($s2)) {
			echo "<TR valign=top>";
			echo "<TD class=table_head>".getlang($r2[name])."</TD>";
		
			$s3=tmq("select * from rqroom_periodinfo where maintb='$r[code]' order by ordr,name");
			while ($r3=tmq_fetch_array($s3)) {
 				$str="";

				$c=tmq("select * from rqroom_timetbi where maintb='$r[code]' and period='$r3[code]' and keyid='$dat-$mon-$yea' and roomsub='$r2[code]' ",false);
				if (tmq_num_rows($c)==0) {
					$str.="<A HREF='requestroom.pick.php?roomid=$r[code]&roomsub=$r2[code]&periodid=$r3[code]&dat=$dat&mon=$mon&yea=$yea'><img src='$dcrURL/neoimg/right32.png' align=absmiddle border=0 width=32> ";
					$str.=getlang("เลือก::l::Pick")."</A>";
					$bgcol="#D0FFCE";
				} else {
					$c=tmq_fetch_array($c);
					$str.=getlang("ถูกจองแล้ว::l::Taken");
					$str.=" ($c[loginid])";
					$bgcol="#FFE7CE";
				}
				echo "<TD class=table_td align=center style='background-color: $bgcol'>".$str."</TD>";
			}
		
		
		echo "</TR>";
		}
	?>
	</TABLE><BR><BR><?php 
}
//fixform_tablelister($tbname," maintb='$roomid' ",$dsp,"no","no","no","roomid=$roomid&dat=$dat&mon=$mon&yea=$yea",$c);
echo "<br /><center><b><a href='requestroom1.php'>".getlang("กลับ::l::Back")."</a></b></center>";
foot();
?>