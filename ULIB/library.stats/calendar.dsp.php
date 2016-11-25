<?php 
include("../inc/config.inc.php");
html_start();
$yea=floor($yea);
$dat=floor($dat);
$mon=floor($mon);
?><TABLE class=table_border width=100%>
<TR>
	<TD class=table_head width=100><?php echo getlang("Circulation");?></TD>
	<TD class=table_td><?php echo getlang("ให้ยืม::l::Checkout");?>: <?php 
	$s=tmq("select sum(cc) as aa from stat_checkout_libsite where dat='$dat' and mon='$mon' and yea='$yea' ");
	$s=tmq_fetch_array($s);
	echo number_format($s[aa]);
	echo " " .getlang(" ครั้ง ::l:: Times ");

	echo " , ";
	echo getlang("รับคืน::l::Checkin");?>: <?php 
	$s=tmq("select sum(cc) as aa from stat_checkin_librarian where dat='$dat' and mon='$mon' and yea='$yea' ");
	$s=tmq_fetch_array($s);
	echo number_format($s[aa]);
	echo " " .getlang(" ครั้ง ::l:: Times ");
			?>			
			</TD>
</TR>
<TR>
	<TD class=table_head width=100><?php echo getlang("Fines");?></TD>
	<TD class=table_td><?php echo getlang("ค่าปรับ::l::Fines");?>: <?php 
	$s=tmq("select count(id) as aa from finedone where dat='$dat' and mon='$mon' and yea='$yea' ");
	$s=tmq_fetch_array($s);
	echo number_format($s[aa]);
	echo " " .getlang(" ครั้ง ::l:: Times ");
	echo " ,";
	$s=tmq("select sum(cach) as aa from finedone where dat='$dat' and mon='$mon' and yea='$yea' ");
	$s=tmq_fetch_array($s);
	echo number_format($s[aa]);
	echo " ฿";
	echo " ,";
	$s=tmq("select sum(credit) as aa from finedone where dat='$dat' and mon='$mon' and yea='$yea' ");
	$s=tmq_fetch_array($s);
	echo number_format($s[aa]);
	echo " ".getlang(" เครดิต::l:: credits.");
		?></TD>
</TR>
<TR>
	<TD class=table_head width=100><?php echo getlang("ล็อกอิน::l::Login");?>:</TD>
	<TD class=table_td><?php 
		$s=tmq("select distinct foot from stathist_librarian_login_ip where dat='$dat' and mon='$mon' and yea='$yea' ");
	while ($r=tmq_fetch_array($s)) {
				echo get_library_name($r[foot]). ", ";
	}
	?></TD>
</TR>

</TABLE>