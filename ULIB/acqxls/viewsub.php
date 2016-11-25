<?php 
include("cfg.inc.php");
//include("head.php");
//print_r($_SESSION);
html_start();
$s=tmq("select * from acqn_sub where id='$id' ");
$s=tfa($s);

?>
<table class=table_border width=100%>
<tr>
	<td width=100 style="width:100px!important">ชื่อเรื่อง</td>
	<td class=table_td><?php  echo $s[titl]?></td>
</tr>
<tr>
	<td>ผู้แต่ง</td>
	<td class=table_td><?php  echo $s[auth]?></td>
</tr>
<tr>
	<td>ISBN</td>
	<td class=table_td><?php  echo $s[isn]?></td>
</tr>
<tr>
	<td>สำนักพิมพ์</td>
	<td class=table_td><?php  echo $s[pub]?></td>
</tr>
<tr>
	<td>ปีพิมพ์</td>
	<td class=table_td><?php  echo $s[yea]?></td>
</tr>
<tr>
	<td>จำนวนสำเนา</td>
	<td class=table_td><?php  echo $s[copy]?></td>
</tr>
<?php  if ($_tmid!="") {?>
<tr>
	<td>ราคา</td>
	<td class=table_td><?php  echo number_format($s[price],2)?></td>
</tr>
<tr>
	<td>ส่วนลด	</td>
	<td class=table_td><?php  echo number_format($s[pricedis],2);?> </td>
</tr>
<tr>
	<td>ราคาสุทธิ</td>
	<td class=table_td><b><?php  echo number_format($s[pricenet],2)?></b></td>
</tr>
<?php }?>
<tr>
	<td>สถานะ</td>
	<td class=table_td style="border-color: <?php  echo $_s[$s[stat]][color]?>;background-color: <?php  echo $_s[$s[stat]][bg]?>; border-width: 1px;"><?php  echo $_s[$s[stat]][name]?></td>
</tr>
<tr>
	<td>แนะนำโดย</td>
	<td class=table_td><?php  echo $s[s_name]?> (<?php  echo $s[s_stat]?>)</td>
</tr>
<tr>
	<td>ข้อเสนอแนะเพิ่มเติม</td>
	<td class=table_td><?php  echo $s[s_oth]?></td>
</tr>
<tr>
	<td>อีเมล์</td>
	<td class=table_td><a href="mailto:<?php  echo $s[s_email]?>?subject=ความคืบหน้าการแนะนำสั่งซื้อ&body=<?php  
	$body="ชื่อเรื่อง $s[titl]%0A%0A
	 ผู้แต่ง :$s[auth]%0A%0A
	ISBN : $s[isn]%0A%0A
	จำนวน  $s[copy] เล่ม%0A%0A ";
	echo ($body);
	?> "><?php  echo $s[s_email]?></a></td>
</tr>
<tr>
	<td>เบอร์โทรศัพท์</td>
	<td class=table_td><?php  echo $s[s_tel]?></td>
</tr>
<tr>
	<td>แนะนำเมื่อ</td>
	<td class=table_td><?php  echo ymd_datestr($s[s_dt]);?></td>
</tr>
<tr>
	<td>ใช้ในคณะ</td>
	<td class=table_td><?php  echo ($s[s_subj]);?></td>
</tr>
<tr>
	<td>ชื่อร้านค้า </td>
	<td class=table_td><?php  echo ($s[s_store]);?></td>
</tr>
</table>