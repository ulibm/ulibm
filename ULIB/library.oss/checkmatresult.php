<?php 
	;
	include ("../inc/config.inc.php");
	include ("./inc.php");
html_start();
	if ($id!="" && $deletethis=="yes") {
		tmq("delete from oss_req where id='$id' ");
		redir("desk.new.php?servicetype=$servicetype&filterstat=$filterstat"); die;
	}
	if ($id!="" && $setstat!="") {
		$isfound_reason=addslashes($isfound_reason);

		tmq("update oss_req set
		dt_lastupdate='$now',
		isfound_reason='$isfound_reason',
		stat='$setstat',
		fee='$fee'
		where id='$id'
		",false);

		$now=time();
		tmq("insert into oss_req_log set pid='$id',
		lib='$useradminid',
		dt='$now',
		money='$fee',
		stat='$setstat'
		");


		$cardid=tmq("select * from oss_req where id='$id' ");
		$cardid=tmq_fetch_array($cardid);
//	printr($cardid);	die;
		?><script type="text/javascript">
		<!--
			//window.open("_slip.php?id=<?php  echo $cardid[cardid];?>");
		//-->
		</script><?php 
		redir("desk.new.php?servicetype=$servicetype&filterstat=$filterstat"); die;
	}
	$s=tmq("select * from oss_req where id='$id' ");
	$s=tfa($s);
	$now=time();

	$pickupatdb=tmq_dump2("oss_pickuptype","classid","name");
	$sourcesdb=tmq_dump2("oss_sources","classid","name");
?><style>
.tdul {
	border: #cdcdcd solid 0px;
	border-bottom-width:1px;
}
</style>
<table>
<tr>
	<td>
	<center><b><!--  -->คำขอที่ <?php  echo $s[id]?></b></center>
	<table cellspacing=5 >
<tr>
	<td class=tdul>ส่งคำขอเมื่อ</td>
	<td class=tdul><?php  echo ymd_datestr($s[dt])?></td>
</tr>
<tr>
	<td class=tdul>ผู้ส่งคำขอ</td>
	<td class=tdul><?php 
	echo get_member_name($s[cardid]);
	?></td>
</tr>
	<tr>
		<td class=tdul>
	<?php 
	$s[mat_info]=dspmarc($s[mat_info]);
	$s[mat_info]=str_replace("\n","</td>	</tr><tr><td class=tdul>",$s[mat_info]);
	$s[mat_info]=str_replace("Title:","Title:</td><td class=tdul>",$s[mat_info]);
	$s[mat_info]=str_replace("Author:","Author:</td><td class=tdul>",$s[mat_info]);
	$s[mat_info]=str_replace("Detail:","Detail:</td><td class=tdul>",$s[mat_info]);

	echo stripslashes($s[mat_info]);?>

</td>
	</tr>	
	<!--  -->
	<tr><td class=tdul>โน๊ต/ข้อความถึงบรรณารักษ์: </td><td class=tdul><?php  echo getlang(stripslashes($s[bknote]));
	
	if ($s[reftrans]!="") {
		echo "<i style='color:darkred'> รายการนี้ระบบสร้างขึ้นอัตโนมัติ จากการชำระแบบไม่เต็มจำนวน</i>";
	}
?></td>	</tr>
	<tr><td class=tdul>	ทรัพยากรของ: </td><td class=tdul><?php  
$tmpsource= getlang(stripslashes($sourcesdb[$s[sources]]));
if ($tmpsource=="") {
	echo getlang($s[sources]);
} else {
	echo $tmpsource;
}
?></td>	</tr>
	<tr><td class=tdul> การรับเอกสาร: </td><td class=tdul><?php  
	if ($s[servicetypeoptions]=="0") {
		echo getlang(" ส่งทางอีเมล์ ::l:: Send to my Email");
	} else {
		echo getlang(stripslashes($pickupatdb[$s[pickupat]]));
	}?></td>	</tr>
	<tr><td class=tdul>สถานะปัจจุบัน:</td><td class=tdul> <b><?php  
	echo $statusdb[$s[stat]];
	
	?></td>	</tr>
	<tr><td class=tdul>วิธีการติดต่อกลับ</td><td class=tdul> <b><?php  
	echo $s[resptype];
	
	?></td>	</tr>
	
	</table>
	
	</td>
</tr>
</table>
<?php 
if ($s[reftrans]!="") { die; }
if ($readonly=="yes") { die; }
?>

<TABLE width=95% class=table_border>
<TR>
	<TD align=center style="background-color: #eeeeee">กรุณากำหนดสถานะ</TD>
</TR>
</TABLE>
<!-- domtab s -->
<div id="d01" class="">
	

<!-- domtab e -->
<TABLE width=95% style="border: 1px solid darkgreen; padding: 3 3 3 3; margin: 5 5 5 5;background-color: #EFFCED">
<FORM METHOD=POST ACTION="checkmatresult.php">
<INPUT TYPE="hidden" NAME="id" value="<?php  echo $id?>">
<input type="hidden" name="filterstat" value="<?php  echo $filterstat;?>">
<input type="hidden" name="servicetype" value="<?php  echo $servicetype;?>">

<TR valign=top>
	<TD align=center width=100 valign=top> <B>พบ</B></TD>
	<TD align=left><TABLE width=100%>
	<TR valign=top>
	
		<TD class=smaller> <TEXTAREA NAME="isfound_reason" ROWS="6" COLS="40" style="width: 100%;font-family: Tahoma;"><?php  echo $s[isfound_reason]?></TEXTAREA>
		</TD>
	</TR>
	<tr>
		<td>ค่าใช้จ่าย <input type="text" name="fee" value="<?php  echo number_format($s[fee],2);?>"> บาท</td>
	</tr>
	<style>
	.currented {
		border: 1px solid #7e8bc9;
		background-color: #edf0fa;
	}
	</style>
	<tr>
		<td style="display:none">กำหนดสถานะเป็น<br>
		<!-- <label><input type="radio" name="setstat" value='done' checked> รายการเสร็จเรียบร้อยแล้ว</label> -->
		<?php 
		$nextstat=$statusstep[$s[stat]];
		if ($nextstat=="") {
			$nextstat=$s[stat];
		}
		?>
		<label <?php  if ($s[stat]=="new") echo " class=currented "; ?>><input type="radio" name="setstat" value='new'  <?php  if ($nextstat=="new") echo "checked"; ?>> รายการใหม่</label>
		<label <?php  if ($s[stat]=="processing") echo " class=currented "; ?>><input type="radio" name="setstat" value='processing'  <?php  if ($nextstat=="processing") echo "checked"; ?>> กำลังดำเนินการ</label>
		<label <?php  if ($s[stat]=="waitpayment") echo " class=currented "; ?>><input type="radio" name="setstat" value='waitpayment'  <?php  if ($nextstat=="waitpayment") echo "checked"; ?>> รอชำระเงิน</label>
		<label <?php  if ($s[stat]=="matsent") echo " class=currented "; ?>><input type="radio" name="setstat" value='matsent'  <?php  if ($nextstat=="matsent") echo "checked"; ?> > จัดส่งเอกสารแล้ว</label>
		<label <?php  if ($s[stat]=="waitpickup") echo " class=currented "; ?>><input type="radio" name="setstat" value='waitpickup'  <?php  if ($nextstat=="waitpickup") echo "checked"; ?> > รอผู้มารับเอกสาร</label><br>
		<label <?php  if ($s[stat]=="done") echo " class=currented "; ?>><input type="radio" name="setstat" value='done'  <?php  if ($nextstat=="done") echo "checked"; ?> > เสร็จสิ้น</label>
		</td>
	</tr>
	</TABLE><INPUT TYPE="submit" style="font-size:15; color: darkred; font-family: Tahoma;font-weight: bold;"  value=" บันทึก " class=a_btngreen>
	
	<font style="font-size:12px; color: 999999" size="" color=""><?php  echo $statusdb[$s[stat]]?> =&gt; <?php  echo $statusdb[$nextstat]?></font></TD>
</TR>
</FORM>
</TABLE>
</div>

<div id="d02"  style="display:none;">
	<TABLE width=95% style="border: 1px solid darkred; padding: 3 3 3 3; margin: 5 5 5 5;background-color: #FCEDED">
<FORM METHOD=POST ACTION="checkmatresult.php">
<INPUT TYPE="hidden" NAME="id" value="<?php  echo $id?>">
<INPUT TYPE="hidden" NAME="setstat" value="matnotfound">
<input type="hidden" name="filterstat" value="<?php  echo $filterstat;?>">
<input type="hidden" name="servicetype" value="<?php  echo $servicetype;?>">

<TR valign=top>
	<TD align=center width=100 valign=top> <B>ไม่พบ</B></TD>
	<TD align=left><TABLE width=100%>
	<TR valign=top>
		<TD width=100>สาเหตุ<br>
		<TEXTAREA ID="isfound_reasonid" name="isfound_reason" rows="4" cols="" style="width: 100%;font-family: Tahoma;"><?php  echo $s[isfound_reason]?></TEXTAREA><BR>
		<A HREF="javascript:void(null);" onclick="tmp=getobj('isfound_reasonid'); tmp.value='ไม่พบทรัพยากรที่ต้องการ';" class=smaller>ไม่พบทรัพยากรที่ต้องการ</A>, 
		<A HREF="javascript:void(null);" onclick="tmp=getobj('isfound_reasonid'); tmp.value='ระบุข้อมูลน้อยเกินไป';" class=smaller>ระบุข้อมูลน้อยเกินไป</A>,
		<A HREF="javascript:void(null);" onclick="tmp=getobj('isfound_reasonid'); tmp.value='ทรัพยากรถูกยืมอยู่';" class=smaller>ทรัพยากรถูกยืมอยู่</A>,
		<A HREF="javascript:void(null);" onclick="tmp=getobj('isfound_reasonid'); tmp.value='มีวัสดุค้างส่งเกินกำหนด';" class=smaller>มีวัสดุค้างส่งเกินกำหนด</A>,
		<A HREF="javascript:void(null);" onclick="tmp=getobj('isfound_reasonid'); tmp.value='เกินจำนวนที่สามารถให้ยืมได้';" class=smaller>เกินจำนวนที่สามารถให้ยืมได้</A>
		
		</TD>
	</TR>

	</TABLE><INPUT TYPE="submit" style="font-size:15; color: darkred; font-family: Tahoma;font-weight: bold;"  value=" บันทึก " class=a_btngreen></TD>
</TR>
</FORM>
</TABLE> 
</div>

<FORM METHOD=POST ACTION="checkmatresult.php">
	<INPUT TYPE="hidden" NAME="id" value="<?php  echo $id?>">
	<INPUT TYPE="hidden" NAME="deletethis" value="yes">

<a href="javascript:void(null)" onclick="tmp=getobj('d01');tmp.style.display='none';tmp=getobj('d02');tmp.style.display='block';" style="color:red";>ไม่พบทรัพยากร   </a>
<INPUT TYPE="submit" style="font-size:15; color: darkred; font-family: Tahoma;font-weight: bold;"  value=" ลบคำขอนี้ "
	onclick="return confirm('Please confirm');" class=a_btngreen>
</form>

<div id="logdsp" class=smaller2>
<?php 
$s=tmq("select * from oss_req_log where pid='$id' ");
while ($r=tfa($s)) {
	echo "&bull; ".ymd_datestr($r[dt])." ".get_library_name($r[lib])."(".$r[lib]."): ตั้งสถานะเป็น ".$statusdb[$r[stat]]." ";
	if (floor($r[money])!=0) {
		echo "กำหนดค่าใช้จ่าย $r[money]";
	}
	echo "<br>";
}
?>
	
</div>
<!-- <a href="desk.new.php" class=a_btn>กลับ</a> -->
<?php 

?>
<style>
BODY {
height: 100px!important;
}
</style>
 </body>
</html>
