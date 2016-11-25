<?php 
;
include("../../inc/config.inc.php");
$dat=floor($dat);
$mon=floor($mon);
$yea=floor($yea);

head();
//include("_REQPERM.php");
$_REQPERM="rqroom_display";
mn_lib();
$allmaintbcodeorig=$allmaintbcode;
?>
<table border="0" cellpadding="0" cellspacing="0" width=780 align=center class=table_border>

<tr><td class=table_head width=30%><?php  echo getlang("วันที่::l::Date")?></td>
<td class=table_td><?php 
echo ymd_datestr(ymd_mkdt($dat,$mon,$yea),'date');
?></td></tr>
</table><br />

<?php 
if ($delete_id!="") {
	tmq("delete from rqroom_timetbi  where id='$delete_id' ");
}
if ($setloginid!="") {
	 $dt=ymd_mkdt($dat,$mon,$yea);
	 tmq("delete from rqroom_timetbi  where maintb='$edit_maintb' and period='$edit_period' and keyid='$dat-$mon-$yea' and roomsub='$edit_subroom' and dt='$dt' ");
	 tmq("insert into rqroom_timetbi  set maintb='$edit_maintb' , period='$edit_period' , keyid='$dat-$mon-$yea' ,loginid='$setloginid' ,dt='$dt' ,roomsub='$edit_subroom' ");
}
if ($edit_period!="" && $setloginid=="") {
	 $dt=ymd_mkdt($dat,$mon,$yea);
	 $old=tmq("select * from rqroom_timetbi  where maintb='$edit_maintb' and period='$edit_period' and keyid='$dat-$mon-$yea'  and dt='$dt' and roomsub='$edit_subroom'  ");
$oldcount=tmq_num_rows($old);
$old=tmq_fetch_array($old);
	 ?>
	 <table border="0" cellpadding="0" cellspacing="0" width=780 align=center class=table_border>
<form action="detail.php" method="post" >
<input type="hidden" name="mon" value="<?php  echo $mon;?>" />
<input type="hidden" name="dat" value="<?php  echo $dat;?>" />
<input type="hidden" name="yea" value="<?php  echo $yea;?>" />
<input type="hidden" name="allmaintbcode" value="<?php  echo $allmaintbcodeorig;?>" />

<input type="hidden" name="edit_period" value="<?php  echo $edit_period;?>" />
<input type="hidden" name="edit_subroom" value="<?php  echo $edit_subroom;?>" />
<input type="hidden" name="edit_maintb" value="<?php  echo $edit_maintb;?>" />

<tr><td class=table_head><?php  echo getlang("บาร์โค้ดสมาชิก::l::Member's barcode");?></td><td class=table_td><input type="text" name="setloginid" ID='setloginid' value="<?php  echo $old[loginid];?>"><SCRIPT LANGUAGE="JavaScript">
<!--
	getobj("setloginid").select();
//-->
</SCRIPT>
 <A HREF="detail.php?<?php  echo "mon=$mon&dat=$dat&yea=$yea&allmaintbcode=$allmaintbcodeorig&delete_id=$old[id]"; ?>"><?php  echo getlang("สละสิทธิ์::l::Cancel");?></A>
</td></tr>

<tr><td class=table_head colspan=2><input type="submit" value=" OK "> <input type="reset" value=" Reset "></td></tr>
</form>
</table>
	 <?php 
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
$s.=" order by name";
$s=tmq($s);
pagesection("กรุณาระบุห้อง/ห้องย่อย/ที่นั่ง ที่ต้องการจอง::l::Please choose room, seat you want to request");
while ($r=tmq_fetch_array($s)) {
	//printr($r);
	pagesection($r[name],"narrow");
	?><TABLE width=780 align=center>
	<TR >
		<TD class=table_head><?php  echo getlang("ที่นั่ง/ช่วงเวลา::l::Room/Period");?></TD>
		<?php  
		$s2=tmq("select * from rqroom_periodinfo where maintb='$r[code]' order by ordr ");
		while ($r2=tmq_fetch_array($s2)) {
				echo "<TD class=table_head width=20%   valign=bottom>";
				
  			$old=tmq("select * from rqroom_eventinfo where maintb='$r[code]' and period='$r2[code]' and keyid='$dat-$mon-$yea'  ",false);
  			$old=tmq_fetch_array($old);
				//printr($old);
				if (trim($old[text])!='') {
					 echo "<b>$old[text]</b><br />";
				}
  			if ($old[image]!='' && file_exists("$dcrs/_tmp/rqroomfile/$old[image]")) {
  				  echo "<img src='$dcrURL/_tmp/rqroomfile/$old[image]' align=absmiddle border=0 width=120><br />";
  			}
				echo getlang($r2[name]);
				echo "<BR><A HREF='predetail.php?mon=$mon&dat=$dat&yea=$yea&allmaintbcode=$allmaintbcodeorig&iframe_maintb=$r[code]&iframe_period=$r2[code]' target=_top><img src='$dcrURL/neoimg/clock.png' 
				align=absmiddle border=0 width=16><b style='font-size:12'> ";
				echo getlang("แสดงเฉพาะรอบ::l::Show Period")."</b></A>";
				echo "</TD>";
		}
	?>
	</TR>
		<?php  
		$s2=tmq("select * from rqroom_roomsub where maintb='$r[code]' order by ordr ",false);
		while ($r2=tmq_fetch_array($s2)) {
			echo "<TR>";
			echo "<TD class=table_head>".getlang($r2[name])."</TD>";
		
			$s3=tmq("select * from rqroom_periodinfo where maintb='$r[code]' order by ordr");
			while ($r3=tmq_fetch_array($s3)) {
			$str="";
				$c=tmq("select * from rqroom_timetbi where maintb='$r[code]' and period='$r3[code]' and keyid='$dat-$mon-$yea' and roomsub='$r2[code]' ",false);
				$editurl="<A HREF='detail.php?mon=$mon&dat=$dat&yea=$yea&allmaintbcode=$allmaintbcodeorig&edit_period=$r3[code]&edit_subroom=$r2[code]&edit_maintb=$r[code]'>";
				if (tmq_num_rows($c)==0) {
					$str.="$editurl<img src='$dcrURL/neoimg/right32.png' align=absmiddle border=0 width=16> ";
					$str.=getlang("เลือก::l::Pick")."</A>";
					$bgcol="#D0FFCE";
				} else {
					$c=tmq_fetch_array($c);
					$str="$editurl".getlang("จองแล้ว::l::Taken")."</a>";
					$str.=" (".get_member_name($c[loginid]).")";
					$bgcol="#FFE7CE";
				}
				echo "<TD style='background-color: $bgcol' class=table_td align=center
				>".$str."</TD>";
			}
		
		
		echo "</TR>";
		}
	?>
	</TABLE><?php 
}
//fixform_tablelister($tbname," maintb='$roomid' ",$dsp,"no","no","no","roomid=$roomid&dat=$dat&mon=$mon&yea=$yea",$c);
echo "<br /><center><b><a href='index.php'>".getlang("กลับ::l::Back")."</a></b></center>";
foot();
?>