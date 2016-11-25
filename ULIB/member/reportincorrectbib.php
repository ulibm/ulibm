<?php 
    ;
	include ("../inc/config.inc.php");
	head();
  mn_web("webpage");
	if ($_memid=="" || $ID=="") {
		 die("please re-check information");
	}
	if ($_memid!="" && $ID!="" && $issave=="yes") {
	$now=time();
	$comment=addslashes($comment);
	tmq("insert into webpage_incorrectbib set memid='$_memid',bibid='$ID',dt='$now',text='$comment' ");
	?><script>
	alert("<?php echo getlang("ขอบคุณสำหรับข้อมูลของคุณ :)::l::Thank you for your information :)");?>");
	self.location="<?php  echo "$dcrURL/dublin.php?ID=$ID"?>";
	</script><?php 
		redir("$dcrURL/dublin.php?ID=$ID");
		 die();
	}
pagesection(getlang("ระบบแจ้งรายการบรรณานุกรมผิด::l::Report Incorrect Bib. "));
?>

<table width=780 align=center cellpadding=0 cellspacing=0 class=table_border>
	<TR>
		<TD style='padding-left: 100px;'><?php 
	$old=tmq("select * from webpage_incorrectbib where memid='$_memid' and bibid='$ID' order by dt ");
	while ($oldr=tmq_fetch_array($old)) {
		echo "<B>".(ymd_datestr($oldr[dt]))."</B><BR>";
		echo $oldr[text]."<BR><BR>";
	}
		?></TD>
	</TR>

	<form action=reportincorrectbib.php method=post><tr><td class=table_head><?php  echo getlang("กรุณาอธิบายข้อมูลส่วนที่ผิดพลาด::l::Please describe incorrect information you found");?></td></tr>
		<tr><td class=table_head><textarea name="comment" cols=90 rows=6></textarea></td></tr>
			<tr><td class=table_head><input type=submit value="<?php  echo getlang("ส่งข้อมูล::l::Submit Report");?>">
			<a href="<?php  echo "$dcrURL/dublin.php?ID=$ID"?>"><?php  echo getlang("กลับ::l::Back");?></a>
			</td></tr>
			<input type=hidden value="<?php  echo $ID?>" name=ID>
			<input type=hidden value="yes" name=issave>
	</form>
	</table><?php 
		echo html_displaymarc($ID);

			foot();
?>