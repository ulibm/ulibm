<?php 
include("../../inc/config.inc.php");
include("./_conf.php");
html_start();
$whs=tmq("select * from ulib_clientlogins where id='$id' ",false);
$wh=tfa($whs);
//printr($wh);
	$c1=tmq("select * from ulib_clientlogins_support where uug='$wh[loginid]' ");
	$c1=tmq_num_rows($c1);
	$p1=tmq("select sum(price) as aa from ulib_clientlogins_support where uug='$wh[loginid]' ");
	$p1=tmq_fetch_array($p1);
	$p1=$p1[aa];
   
	$s="<b>".$wh[name]."</b> - $wh[orgtype]<br>
	&gt; <a href='uug.support.php?id=$wh[loginid]'>ประวัติ support ($c1 = ".number_format($p1)." ฿)</a> :  <a href='uug.ma.php?id=$wh[loginid]'>ประวัติ M/A</a>
	<font class=smaller>";
	$p1=tmq("select sum(price) as aa from ulib_clientlogins_ma where uug='$wh[loginid]' ");
	$p1=tmq_fetch_array($p1);
	$p1=number_format($p1[aa]);
	$c2=tmq("select * from ulib_clientlogins_ma where uug='$wh[loginid]' ");
	$c2=tmq_num_rows($c2);
	$s.=" ($c2)";

	$s1=tmq("select * from ulib_clientlogins_ma where uug='$wh[loginid]' and matype='เริ่มM-A' ");
	if (tmq_num_rows($s1)==0) {
		$s.=" : ยังไม่เคย M/A";
	} else {
		$s1=tmq_fetch_array($s1);
		$dts=$s1[dt];
		$s1=tmq("select * from ulib_clientlogins_ma where uug='$wh[loginid]' and matype<>'เริ่มM-A' ");
		//echo "<br>$dts";
		while ($r=tmq_fetch_array($s1)) {
			$dts=$dts+floor(60*60*24*30*floor($r[month]));
			//echo "<br>".floor(60*60*24*30*floor($r[month]));
		}
		//echo "<br>$dts";
		$s.="<br> &nbsp;&nbsp;&nbsp; คุ้มครองถึง ".ymd_datestr($dts,"date");;
	}
	$s.=" = ".($p1)." ฿</font><br>";
	$c3=tmq("select * from ulib_clientlogins_contact where uug='$wh[loginid]' ");
	$c3=tmq_num_rows($c3);
	$s.=" &gt; <a href='uug.contact.php?id=$wh[loginid]'>ชื่อผู้ติดต่อ ".number_format($c3)."</a><br>";
	$s3=tmq("select * from ulib_clientlogins_contact where uug='$wh[loginid]' order by name ");
	while ($r3=tmq_fetch_array($s3)) {
		$s.=" &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($r3[name])." <font class=smaller2>" .($r3[email])." ".$r3[tel]."</font> (รับผิดชอบด้าน: $r3[role])<br>";

	}
   
   //echo $s;
   ?><table width=800 align=center><tr><td><BR><BR><?php
   echo "<center><b>".$wh[name]."</b></center><BR><BR><BR>";
?>ยินดีต้อนรับเข้าสู่ ULibM User Group (UUG)<BR>
<BR>
ขณะนี้ทางผู้จัดการระบบ ULibM User Group  ได้จัดเตรียมล็อกอินและรหัสผ่านของท่าน สำหรับล็อกอินเข้าใช้งานให้ท่าน ดังนี้<BR>
<BR>
<blockquote><B>Login: <?php echo $wh[loginid]; ?><BR>
Password: <?php echo $wh[passwd]; ?><BR>
</b>
</blockquote><BR>
ซึ่งท่านใช้ล็อกอินรหัสผ่านดังกล่าว ล็อกอินเข้าสู่ระบบ User Group ได้ที่  <u>www.ulibm.net</u>  
เพื่อดาวน์โหลดไฟล์อัพเดท อัพเดทโปรแกรม ดูคู่มือวิธีการใช้งานต่าง ๆ<BR>
<BR>
ซึ่งเมื่อท่านล็อกอินเข้าสู่ระบบแล้ว ขอแนะนำให้ท่านได้ดำเนินการต่อไปนี้<BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1. คลิกที่เมนู [แก้ไขข้อมูล] เพื่ออัพเดทข้อมูลของหน่วยงานท่าน และแก้ไขรหัสผ่าน<BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2. คลิกที่เมนู [รายชื่อผู้ติดต่อ] เพื่อเพิ่มข้อมูลชื่อผู้ปฎิบัติงานห้องสมุดที่สามารถติดต่อได้<BR>
<BR>
หากมีปัญหาหรือข้อสงสัยในการเข้าใช้ระบบ กรุณาติดต่อ <BR>
<BR>
<blockquote>
นายสันติภาพ เปลี่ยนโชติ<BR>
087-807-9887<BR>
Line ID: peace2727<BR>
apeacez@gmail.com<BR>
<BR>
อาจารย์สมพงษ์ เจริญศิริ<BR>
icharoensiri@gmail.com<BR>
 09-4761-4441
</blockquote>
<BR>
<BR>
<center>
ด้วยความนับถือ<BR>
<BR>
จากทีมผู้พัฒนาระบบห้องสมุดอัตโนมัติ ULibM
</center>
</td></tr></table>