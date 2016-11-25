<?php 
include("../inc/config.inc.php");
html_start();
//printr($_SESSION);
$now=time();
if ($cardid=="") {	die("cardid=''");}

if (!is_array($paylist)|| count($paylist)==0) {
	html_dialog("error","กรุณาเลือกรายการที่ต้องการชำระด้วย");die;
}

	if ($cardid!="" && $setstat!="") {
		$s="select * from oss_req where cardid='$cardid' and stat='waitpickup' and (0 ";
		@reset($paylist);
		while (list($k,$v)=each($paylist)) {
			$s.=" or id='$v' ";
		}
			$s.=" )";
		$s=tmq($s);
		while ($r=tfa($s)) {
			tmq("update oss_req set stat='$setstat' where id='$r[id]'  ");
							tmq("insert into oss_req_log set pid='$r[id]',
				lib='$useradminid',
				dt='$now',
				stat='$setstat'
				");
		}
		
		redir("desk.waitpickup.php"); 
		die;
	}



	$now=time();

?><table cellpadding=20>
<tr>
	<td>
	<?php  member_showinfo($cardid); ?>
	</td>
</tr>
</table>
<table cellpadding=20 width=100%>
<tr>
	<td><?php 
$res="
		<table width=100%>
	";
	$s="select * from oss_req where cardid='$cardid' and stat='waitpickup' and (0 ";
	@reset($paylist);
	while (list($k,$v)=each($paylist)) {
		$s.=" or id='$v' ";
	}
		$s.=" )";
	$s=tmq($s,false);
	$sum=0;
	$count=tnr($s);
	while ($r=tfa($s)) {
		$tmp=explode("Author:",$r[mat_info]);
		//printr($tmp);
		$tmp=$tmp[0];
		$res.="<tr>
		<td><a href='checkmatresult.php?id=$r[id]' target=_blank>".substr($tmp,0,60)."</a></td>
		<td width=70>".number_format($r[fee],2)."</td>
	</tr>";
		$sum=$sum+$r[fee];
	}
	$res.="
	</table>
	 &bull;  รวม <b>".number_format($count)."</b> รายการ  ";
	 echo $res;
	?>
	</td>
</tr>
</table>
<TABLE width=95% style="border: 1px solid darkgreen; padding: 3 3 3 3; margin: 5 5 5 5;background-color: #EFFCED">
<TR>
	<TD align=center style="background-color: #eeeeee">กรุณายืนยัน</TD>
</TR>
<FORM METHOD=POST ACTION="processpickup.php">
<input type="hidden" name="sumpay" value="<?php  echo $sum?>">
<INPUT TYPE="hidden" NAME="cardid" value="<?php  echo $cardid?>">
<?php 
	@reset($paylist);
	while (list($k,$v)=each($paylist)) {
		echo "<INPUT TYPE=hidden NAME='paylist[]' value='$v'>
";
	}
?>
<TR valign=top>
	<TD align=left><TABLE width=100%>
	<tr>
		<td>กำหนดสถานะทุกรายการเป็น<br>
		<label><input type="radio" name="setstat" value='done'  checked> รายการเสร็จสมบูรณ์แล้ว</label>
		<label><input type="radio" name="setstat" value='cancelbylib'  > ยกเลิกรายการโดยบรรณารักษ์</label>
		</td>
	</tr>
	</TABLE><INPUT TYPE="submit" style="font-size:15; color: darkred; font-family: Tahoma;font-weight: bold;"  value="  บันทึก  " class=a_btngreen></TD>
</TR>
</FORM>
</TABLE>