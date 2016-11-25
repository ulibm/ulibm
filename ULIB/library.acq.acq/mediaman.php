<?php 
    ;
	include ("../inc/config.inc.php");
if ($edit=="") {
	echo "var not found";
	die;
}
if ($text=="addmenu") {
	?><CENTER><BLOCKQUOTE>
	<A HREF="mediaman.add.all.php?edit=<?php  echo $edit;?>"><?php  echo getlang("เพิ่มรายการทั้งหมดในฐานข้อมูลวัสดุสารสนเทศที่จะสั่งซื้อ::l::Add all from database");?></A><BR><BR>
	<A HREF="mediaman.add.allnotsent.php?edit=<?php  echo $edit;?>"><?php  echo getlang("เพิ่มรายการทั้งหมดในฐานข้อมูลวัสดุสารสนเทศที่จะสั่งซื้อ ซึ่งยังไม่ได้สั่งซื้อในใบสั่งซื้ออื่นๆ::l::Add only records not added in other");?></A><BR><BR>
	<A HREF="mediaman.add.bybudget.php?edit=<?php  echo $edit;?>"><?php  echo getlang("เพิ่มตามชุดงบประมาณ::l::Add by budget sets");?>...</A><BR><BR>
	<A HREF="mediaman.add.bymajor.php?edit=<?php  echo $edit;?>"><?php  echo getlang("เพิ่มตามสาขาวิชา::l::Add by subjects");?>...</A><BR><BR>
	</BLOCKQUOTE></CENTER><?php 
	die;
}
if ($text=="delmenu") {
	?><CENTER><BLOCKQUOTE>
	<A HREF="mediaman.del.all.php?edit=<?php  echo $edit;?>"><?php  echo getlang("ลบรายการทั้งหมดในใบสั่งซื้อนี้::l::Delete all");?></A><BR><BR>
	<A HREF="mediaman.del.bybudget.php?edit=<?php  echo $edit;?>"><?php  echo getlang("ลบตามชุดงบประมาณ::l::Delete by budget sets");?>..</A><BR><BR>
	<A HREF="mediaman.del.bymajor.php?edit=<?php  echo $edit;?>"><?php  echo getlang("ลบตามสาขาวิชา::l::Delete by budget sets");?>...</A><BR>
	<A HREF="mediaman.del.statuspass.php?edit=<?php  echo $edit;?>"><?php  echo getlang("ลบทุกรายการที่มีสถานะ &quot;ได้แล้ว&quot;::l::Delete all with status&quot;Available&quot;");?></A><BR><BR>
	<A HREF="mediaman.del.statusfail.php?edit=<?php  echo $edit;?>"><?php  echo getlang("ลบทุกรายการที่มีสถานะ &quot;ไม่ได้&quot;::l::Delete all with status &quot;Not available&quot;");?></A><BR><BR>
	</BLOCKQUOTE></CENTER><?php 
	die;
}
	?>