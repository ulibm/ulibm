<?php 
;
include("./inc/config.inc.php");
head();
mn_web("requestroom");

//include("_REQPERM.php");
$dat=floor($dat);
$mon=floor($mon);
$yea=floor($yea);

$allmaintbcodeorig=$allmaintbcode;
?><table border="0" cellpadding="0" cellspacing="0" width=780 align=center class=table_border>

<tr><td class=table_td align=center><?php  echo getlang("กิจกรรมในวันที่::l::Activities on ")?><?php 
echo ymd_datestr(ymd_mkdt($dat,$mon,$yea),'date');
?> <A HREF="requestroom1.php"><?php  echo getlang("กลับไปปฏิทิน::l::Back to calendar");?></A></td></tr>
</table>
<?php 

if ($iframe_period!="") {
	?><CENTER><iframe width=780 src="detail.iframe.php?<?php 
	echo "mon=$mon&dat=$dat&yea=$yea&iframe_maintb=$iframe_maintb&iframe_period=$iframe_period";	
	?>" height=400></iframe></CENTER><?php 
}
?>
<br />
<?php 

$s="select * from rqroom_maintb where 0 ";

$allmaintbcode=explode(',',$allmaintbcode);
$allmaintbcode=arr_filter_remnull($allmaintbcode);
while (list($k,$v)=each($allmaintbcode)) {
	$s.= " or code='$v' ";
}
$s.="order by name";
$s=tmq($s);
//pagesection("กรุณาระบุห้อง/ห้องย่อย/ที่นั่ง ที่ต้องการจอง::l::Please choose room, seat you want to request");

while ($r=tmq_fetch_array($s)) {
	//printr($r);
	pagesection($r[name],"requestroom");
	$s2=tmq("select * from rqroom_periodinfo where maintb='$r[code]' order by ordr ");
	?>
<TABLE width=780 align=center>
<tr><td   valign=middle align=left colspan='<?php  echo tnr($s2)+1?>'>
<?php 
	?> &nbsp;&nbsp;<?php  echo getlang($r[descr]);
	?>
</td></tr>
<?php 

			echo "<TR  valign=bottom>";
			echo "<TD width=100  valign=top><img src='./neoimg/spacer.gif' height=10 width=100></TD>";
			echo "<TD class=table_td align=left width=100%>";
			$s3=tmq("select * from rqroom_periodinfo where maintb='$r[code]' order by ordr");
			while ($r3=tmq_fetch_array($s3)) {
			$old=tmq("select * from rqroom_eventinfo where maintb='$r[code]' and period='$r3[code]' and keyid='$dat-$mon-$yea'  ",false);
  			$old=tmq_fetch_array($old);
			if ($old[text]=='' && strtolower($r[isautoopen])!="yes") {
				continue;
			}
			  $str="<div style='width:100%; margin-top:5;margin-buttom:5; border-style: dotted; border-color: gray; border-width:0px; border-bottom-width:1;display:block; height: 120'>";

			$str.="<A 
			HREF='requestroom.detail.php?mon=$mon&dat=$dat&yea=$yea&allmaintbcode=$allmaintbcodeorig&iframe_maintb=$r[code]&iframe_period=$r3[code]'
			HREF='predetail.php?mon=$mon&dat=$dat&yea=$yea&allmaintbcode=$allmaintbcodeorig&iframe_maintb=$r[code]&iframe_period=$r3[code]' target=_top>";
  			if ($old[image]!='' && file_exists("$dcrs/_tmp/rqroomfile/$old[image]")) {
  				  $str.= "<img src='$dcrURL/_tmp/rqroomfile/$old[image]' style='float:left; margin-right: 3px;' border=0 width=120 height=120>";
  			} else {
  				  $str.= "<img src='./timetable/view/Group-icon.png' style='float:left;margin-right: 3px;' border=0 width=120>";
			}
			if (trim($old[text])!='') {
				 $str.= "<b style='color:#005771; font-size: 17'>$old[text]</b>";
			}
          //$str.="<img src='$dcrURL/neoimg/right32.png' align=absmiddle border=0 width=32>";
           $str.=" <font style='color:#005771; font-size: 14'>(".getlang($r3[name]).")</font>";
		 
			 $str.= "<br /><img src='$dcrURL/neoimg/clock.png' 
				align=absmiddle border=0 width=16><b style='font-size:12'> $r3[time] 
				</b></A>";

		$chkava=tmq("select * from rqroom_roomsub where maintb='$r[code]' order by ordr ",false);
		$ava=0; $taken=0;
		while ($chkavar=tmq_fetch_array($chkava)) {
			$chkava2=tmq("select * from rqroom_timetbi where maintb='$r[code]' and period='$r3[code]' and keyid='$dat-$mon-$yea' and roomsub='$chkavar[code]' ",false);
			if (tmq_num_rows($chkava2)==0) {
				$ava++;
			} else {
				$taken++;
			}
		}
		$str.= " <BR><FONT style='font-size: 12;'><img src='$dcrURL/neoimg/menuicon/key16.png' 
					align=absmiddle border=0 width=16> ";
		   $str.= getlang("จองแล้ว::l::Taken").": $taken ";
		   $str.= getlang("ว่าง::l::Available").": $ava </FONT>";

				if (trim($old[text])!='' || $old[image]) {
					$str.= "<BR><A HREF='requestroom.detail.read.php?ID=$old[id]' target=_blank style='font-size:12;width:75%; text-align: right;'>..".getlang("ข้อมูลเพิ่มเติม::l::More info")." </a>";
				}

		$str.= " <BR></div>";
          
          echo $str;
			}
          echo "</TD>";
		
		
		echo "</TR>";

	?>
	</TABLE><BR><BR><?php 
}


foot();

?>