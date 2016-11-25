<?php 
include("inc/config.inc.php");
$emailto=trim($emailto);
if ($issend=="yes" ) {
	include("$dcrs"."inc/email/ini.php");
	if (!umail_chk($emailto)) {
		html_dialog("","Invalid Email [$emailto]");
	} else {
	umail_mail("$emailto","Bibliography record [$id]","
	".marc_gettitle($id)."
	-------------------------------------------------------
	".html_displaymedia($id)."
	");
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
		top.removegb();
	//-->
	</SCRIPT><?php 
		die;
	}
}
html_start();
	?>
	<TABLE width=400 align=center class=table_border>
	<TR>
		<TD class=table_head><?php echo getlang("ทรัพยากร::l::Record");?></TD>
	</TR>
	<TR>
		<TD class=table_td><?php 
		res_brief_dsp($id);
		?>
		</TD>
	</TR>
	<TR>
		<TD class=table_head><?php echo getlang("กรุณากรอกอีเมล์ของคุณ::l::Please Enter your E-mail");?></TD>
	</TR><FORM METHOD=POST ACTION="dublin.emailme.php">
	<INPUT TYPE="hidden" NAME="issend" value="yes">
	<INPUT TYPE="hidden" NAME="id" value="<?php  echo $id?>">
		
	<TR>
		<TD class=table_td align=center> <INPUT TYPE="text" NAME="emailto" value="<?php 
if ($_memid!="") {
	$s=tmq("select * from member where UserAdminID='$_memid' ");
	$s=tmq_fetch_array($s);
	//printr($s);
	echo $s[email];
}
//printr($_SESSION);
		?>"> <INPUT TYPE="submit" value="<?php echo getlang("ส่ง::l::Send");?>"> <A HREF="javascript:void(null)" onclick="top.removegb()"><?php  echo getlang("ยกเลิก::l::Cancel");?></A>
		</TD>
	</TR>
	</FORM>	</TABLE> <?php ?>
	<?php 

?>