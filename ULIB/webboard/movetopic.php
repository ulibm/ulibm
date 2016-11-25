<?php 
include("./cfg.inc.php");
               
     head();

$ismanager=loginchk_lib("check");
if ($ismanager!=true) {
	die();
}

$now=time();
$sql2 ="SELECT *  FROM webboard_boardcate where 1 "; 
$sql2 = "$sql2 order by ordr";

$s=tmq($sql2);
?><CENTER><B><BR><?php  echo getlang("กรุณาเลือกหัวข้อที่จะย้ายไปยัง::l::Choose destination category");?></B></CENTER><BR>
<TABLE cellpadding=3 cellspacing=1 bgcolor=black align=center width=780 class=table_border>
<TR bgcolor=eeeeee>
	<TD width=70%  class=table_head><B><?php  echo getlang("หัวข้อ::l::Category");?></B></TD>
</TR>
<?php 
	while ($r=tmq_fetch_array($s)) {

?>
<TR bgcolor=white>
	<TD class=table_td>
	<?php 
		$link="<A HREF='movetopicaction.php?TID=$TID&ID=$r[id]'>";
		echo $link;
	?><B><?php  echo getlang($r[name]);?></B><BR>&nbsp;&nbsp;<B></B><?php  echo getlang($r[descr])?></A></TD>
</TR>

<?php 
	}	
?>
</TABLE><BR><CENTER><A HREF="index.php"><?php  echo getlang("ยกเลิกการย้าย - ไปหน้าหลัก::l::Cancel, go webboard's home");?></A></CENTER><BR>
 <?php 


foot();

?>