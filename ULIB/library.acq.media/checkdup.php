<?php 
    ;
	include ("../inc/config.inc.php");
	$titl=getval("MARC","add-autotitle-to");
	$isbn=getval("MARC","add-isbn-to");
	$s=("select * from media where 1 ");
	?><title><?php  echo getlang("ตรวจสอบความซ้ำซ้อน::l::Check for duplication"); ?></title><?php 
	if ($d_titl!="") {
		$s="$s and $titl like '%$d_titl%' ";
	}
	if ($d_isbn!="") {
		$s="$s and $isbn like '%$d_isbn%' ";
	}
	$s="$s  limit 0,6 ";
	$s=tmq($s);
echo "".getlang("ชื่อเรื่อง::l::Title")." $d_titl, ISBN $d_isbn";
	?><TABLE width=100%>
	<TR>
		<TD bgcolor=f0f0f0><B>
<?php  echo getlang("วัสดุสารสนเทศที่มีในฐานข้อมูล::l::Material in Database"); ?></B></TD>
	</TR>
<?php 
if (tmq_num_rows($s)==0) {
		?>	<TR>
		<TD align=center>- <?php  echo getlang("ไม่มี::l::None"); ?> -</TD>
	</TR><?php 
}
	while ($r=tmq_fetch_array($s)) {
		?>	<TR>
		<TD><A HREF="../dublin.php?ID=<?php  echo $r[ID]?>" target=_blank><?php  echo substr(marc_gettitle($r[ID]),0,40)?></A></TD>
	</TR><?php 
	}

?>	</TABLE>

<?php 
	$s=("select * from acq_media where 1 ");
	if ($d_titl!="") {
		$s="$s and d_titl like '%$d_titl%' ";
	}
	if ($d_isbn!="") {
		$s="$s and d_isbn like '%$d_isbn%' ";
	}
	$s="$s  limit 0,6 ";
	$s=tmq($s);
	?><TABLE width=100%>
	<TR>
		<TD bgcolor=f0f0f0><B><?php  echo getlang("วัสดุสารสนเทศที่อยู่ในระบบจัดหา::l::Items in acquisition"); ?></B></TD>
	</TR>
<?php 
if (tmq_num_rows($s)==0) {
		?>	<TR>
		<TD align=center>- <?php  echo getlang("ไม่มี::l::None"); ?> -</TD>
	</TR><?php 
}
	while ($r=tmq_fetch_array($s)) {
		?>	<TR>
		<TD><?php  echo substr($r[d_titl],0,40)?></TD>
	</TR><?php 
	}

?>	</TABLE>