<?php 
;
include("../../inc/config.inc.php");
 include("./index.inc.php");
$_SESSION['marked'] =@array_unique($_SESSION['marked'] );
if ($clear=="yeahyeah") {
	unset($_SESSION['marked']);
	redir("exportmarked.php");
	die;
}
if ($del!="") {
	foreach ($_SESSION['marked'] as $key =>  $value) {
		if ($del==$value) {
			unset($_SESSION['marked'][$key]);
		}
	}
}
$_TBWIDTH="100%";
html_start();
		//mn_web("exportmarked");
		
		
if (!is_array($_SESSION['marked']) || count($_SESSION['marked'])==0) {
  html_dialog("error",getlang("คุณต้องทำการเลือกรายการที่จะส่งออกก่อน::l::Must be some record marked before export") . "<br />
 <!-- <br />
<a href='index.php'>".getlang("กลับ::l::Back")."</a> -->");
	die;
}
?><BR>
<TABLE width=<?php  echo $_TBWIDTH?> align=center bgcolor=white cellspacing=1><td align=right><nobr><a href="exportmarked.php?clear=yeahyeah"><IMG SRC="<?php  echo $dcrURL;?>neoimg/clear.jpg" WIDTH="29" HEIGHT="26" BORDER="0" ALT="" align=absmiddle><B> <?php  echo getlang("ล้างทั้งหมด::l::Clear all"); ?></B></a>&nbsp;</td>
        </TR>
    </TABLE><TABLE width=<?php  echo $dcrURL;?> align=center bgcolor=black cellspacing=1>
<TR bgcolor=#c9c9c9>
	<TD width=5%><B><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></B></TD>
	<TD width=80%><B><?php  echo getlang("ชื่อเรื่อง /ชื่อผู้แต่ง::l::Title /Author"); ?></B></TD>
	<TD><B><?php  echo getlang("ลบ::l::Delete"); ?></B></TD>
</TR><?php 

$i=0;
foreach ($_SESSION['marked'] as $value) {
	$i++;
	if ($i % 2 ==0) {
		$c="f2f2f2";
	} else {
		$c="white";
	}
	echo "<TR bgcolor=$c><TD>$i</TD>
	<TD>";
	echo "<a href='$dcrURL"."dublin.php?ID=$value' target=_blank>".(marc_gettitle($value) . "</a>/".marc_getauth($value)."<BR>");
	echo "</TD>
	<TD align=center><A HREF=\"exportmarked.php?del=$value\"><FONT SIZE=1>".getlang("ลบรายการนี้::l::Delete")."</FONT></A></TD>
</TR>";
}

?>
</TABLE><BR>
<BR>
<FORM METHOD=POST ACTION="exportmarkedAction.php">
<TABLE width=500 align=center>
<TR>
	<TD colspan=2><B><?php  echo getlang("กรุณาเลือกรูปแบบการส่งออก::l::Choose export format"); ?> </B></TD>
</TR>
<TR>
	<TD>
	<label><INPUT TYPE="radio" NAME="exptype" value=full style="border: 0;"><?php  echo getlang("แสดง MARC::l::Display MARC"); ?></label><BR>
	<label><INPUT TYPE="radio" NAME="exptype" value=brieve style="border: 0;"><?php  echo getlang("รายละเอียดเต็ม::l::Full Detail"); ?></label><BR>
	<label><INPUT TYPE="radio" NAME="exptype" value=shorted style="border: 0;"><?php  echo getlang("รายละเอียดย่อ::l::Short Detail"); ?></label><BR>
	<label><INPUT TYPE="radio" NAME="exptype" value=marc style="border: 0;" checked>MARC (ISO 2709)</label><BR>
	</TD>
	<TD>
	<label><INPUT TYPE="radio" NAME="viewtype" value=view style="border: 0;" checked><?php  echo getlang("ดูทางหน้าจอ::l::Screen"); ?></label><BR>
	<label><INPUT TYPE="radio" NAME="viewtype" value=download style="border: 0;" ><?php  echo getlang("ดาวน์โหลด::l::Local disk"); ?></label><BR>
<?php 
if (barcodeval_get("mailsetting-isenable")=="yes") {?>
	<label><INPUT TYPE="radio" NAME="viewtype" value=email style="border: 0;" ><?php  echo getlang("ส่งทางอีเมล์::l::Send to E-mail "); ?></label> <INPUT TYPE="text" NAME="emailto"  value="<?php 
if ($_memid!="") {
	$s=tmq("select * from member where UserAdminID='$_memid' ");
	$s=tmq_fetch_array($s);
	//printr($s);
	echo $s[email];
}
//printr($_SESSION);
		?>"><BR>
	<?php }?>
	</TD>
</TR><TR>
	<TD><INPUT TYPE="submit" value=Export></TD>
</TR>

</TABLE></FORM>

<script type="text/javascript">
<!--
	top.scrollTo(0,0);
//-->
</script>
