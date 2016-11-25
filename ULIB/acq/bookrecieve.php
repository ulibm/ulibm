<?php 
include("./cfg.inc.php");
limitpage_var();
html_start();
$savethisid=floor($savethisid);
$searchid=floor($searchid);
$bystore=urldecode($bystore);
if ($savethisid!="") {
	tmq("update acqn_sub set stat='$setstat' where 1 and id='$savethisid' limit 1 ");
}

//print_r($_GET);
?><center><form method="GET" action="bookrecieve.php">
<h2>ตั้งค่าสถานะรายการเป็น
<font  color="<?php  echo $_s[$setstat][color]?>" style='font-size:20px; font-weight:bold;'><?php  echo $_s[$setstat][name]?></font><!-- <br>
ร้านค้า/สำนักพิมพ์ : <?php 
echo $bystore;
?> -->
</h2>

	ค้นหาด้วย ID (ตามที่ปรากฏในไฟล์ Excel)
	<input type="text" 
	name="searchid" ID=searchid
	value=""
	> <input type="submit" value="ค้นหา">
<input type="hidden" name="bystore" value="<?php  echo urlencode($bystore);?>">
<input type="hidden" name="setstat" value="<?php  echo ($setstat);?>">
</form>
<?php 
if ($searchid==0) {
	?>
	<script type="text/javascript">
	<!--
		tmp=getobj("searchid");
		tmp.focus();
	//-->
	</script>
	<?php 
		die;
} else {
}

$s=tmq("select * from acqn_sub where id='$searchid' ");
if (tnr($s)==0) {
	?>
	ไม่พบ หมายเลข <?php  echo $searchid?>
<?php  die;
}
$r=tfa($s);

?> กำลังตั้งค่ารายการต่อไปนี้<br>
<style>
.table_td {
	font-size: 22px!important;
}
</style>
<table width=600 align=center class=table_border>
<tr>
	<td class=table_head width=200>
	ชื่อเรื่อง</td>
	<td class=table_td><?php 
	 echo $r[titl];
	?></td>
</tr>
<tr>
	<td class=table_head>
	ผู้แต่ง</td>
	<td class=table_td><?php 
	 echo $r[auth];
	?></td>
</tr>
<tr>
	<td class=table_head>
	ISBN</td>
	<td class=table_td><?php 
	 echo $r[isn];
	?></td>
</tr>
<tr>
	<td class=table_head>
	ร้านค้า</td>
	<td class=table_td><?php 
	 echo $r[s_store];
	?></td>
</tr>
<tr>
	<td class=table_head>
	คณะ</td>
	<td class=table_td><?php 
	 echo $r[s_subj];
	?></td>
</tr>
<tr>
	<td class=table_head>
	หมายเลขอ้างอิงในใบสั่งซื้อ</td>
	<td class=table_td><?php 
	 echo $r[id];
	?></td>
</tr>
<tr>
	<td>แนะนำโดย</td>
	<td class=table_td><?php  echo $r[s_name]?> (<?php  echo $r[s_stat]?>)</td>
</tr>
<tr>
	<td>อีเมล์</td>
	<td class=table_td><a target=_blank href="mailto:<?php  echo $s[s_email]?>?subject=ความคืบหน้าการแนะนำสั่งซื้อ&body=<?php  
	$body="ชื่อเรื่อง $s[titl]%0A%0A
	 ผู้แต่ง :$r[auth]%0A%0A
	ISBN : $r[isn]%0A%0A
	จำนวน  $r[copy] เล่ม%0A%0A ";
	echo ($body);
	?> "><?php  echo $r[s_email]?></a></td>
</tr>
<tr>
</table>
<form method="post" action="bookrecieve.php">
	<input type="hidden" 
	name="savethisid" 
	value="<?php  echo $searchid;?>"
	> <input type="submit" value="ยืนยันการตั้งค่าสำหรับรายการหมายเลข <?php  echo $searchid?>" ID="finalsubmit">
<input type="hidden" name="bystore" value="<?php  echo urlencode($bystore);?>"
style="font-size: 22px;"
>
<input type="hidden" name="setstat" value="<?php  echo ($setstat);?>">

</form>

	<script type="text/javascript">
	<!--
		tmp=getobj("finalsubmit");
		tmp.focus();
	//-->
	</script>
<?php ?></center>