<?php 
;
include ("../inc/config.inc.php");
include("_REQPERM.php");
head();
mn_lib();
$newbarcode=str_remspecialsign($newbarcode);
if ($issave=="yes" && $ID!="" && $ID!=$newbarcode && $newbarcode!="") {
	$arraychk=Array();
	$arraychk["fine"]="memberId";
	$arraychk["finedone"]="member";
	$arraychk["webboard_posts"]="memid";
	$arraychk["webpage_memregist"]="UserAdminID";
	$arraychk["webpage_memfavbook_perscate"]="memid";
	$arraychk["webpage_mocalen_resp"]="memid";
	$arraychk["webpage_memfavbook"]="memid";
	$arraychk["webpage_incorrectbib"]="memid";
	$arraychk["webpage_bookcomment"]="memid";
	$arraychk["webpage_bibtag"]="memid";
	$arraychk["webpage_bibrating_log"]="memid";
	$arraychk["webpage_answerpoint"]="memid";
	$arraychk["webboard_post_attatch"]="tmid";
	$arraychk["webboard_posts"]="tmid";
	$arraychk["servicespot_client"]="cu_loginid";
	$arraychk["rqroom_timetbi"]="loginid";
	$arraychk["request_list"]="memberid";
	$arraychk["holdlong_notif"]="memid";
	$arraychk["checkout"]="hold";
	$arraychk["checkout "]="request";
	$arraychk["member"]="UserAdminID";
	$arraychk["useinsidelib"]="memid";


	$arraychk["stathist_checkout_member_libsite"]="head";
	$arraychk["stathist_checkout_member_media"]="head";
	$arraychk["stathist_cir_member"]="head";
	$arraychk["stathist_insidelib_member"]="head";
	$arraychk["stathist_ms_member_gate"]="foot";
	$arraychk["stathist_servspot_member"]="foot";
	$arraychk["stathist_ttb_member"]="foot";
	$arraychk["statordr_checkout_member"]="head";
	$arraychk["statordr_memberlogin_member"]="head";
	$arraychk["statordr_ms_member"]="head";
	$arraychk["stat_memberlogin_membertype"]="head";
	$arraychk["stathist_checkin_member_libsite"]="head";
	$arraychk["stathist_checkin_member_media"]="head";
	$arraychk["stathist_checkout_member_libsite"]="head";
	$arraychk["stathist_checkout_member_media"]="head";
	$arraychk["stathist_cir_member"]="head";
	$arraychk["stathist_insidelib_member"]="head";
	$arraychk["stathist_ms_member_gate"]="head";
	$arraychk["stathist_ms_member_ip"]="head";
	$arraychk["stathist_ms_member_ms"]="head";
	$arraychk["stathist_renew_member_media"]="head";
	$arraychk["stathist_rqroom_member"]="head";
	$arraychk["stathist_servspoti_member"]="head";
	$arraychk["stathist_servspot_member"]="head";
	$arraychk["statordr_ms_member"]="head";
	$arraychk["stathist_ttb_member"]="head";
	$arraychk["statordr_checkout_member"]="head";
	$arraychk["statordr_memberlogin_member"]="head";
   
   
	$chk=tmq("select * from member where UserAdminID='$newbarcode' ",false);
	if (tmq_num_rows($chk)!=0) {
		?><CENTER><?php 
		html_dialog("",getlang("ขออภัย บาร์โค้ดนี้มีผู้ใช้ไปแล้ว::l::Sorry, this barcode already taken"));
		echo get_member_name($newbarcode);
		?></CENTER><?php 
	} else {
		@reset($arraychk);	
		while (list($k,$v)=each($arraychk)) {
			$k=trim($k);
			$chksql="update $k set $v='$newbarcode' where $v='$ID' ";
		?><CENTER><?php 
			//echo $chksql."<BR>";
			tmq($chksql);
		}
////////////picstart
		$suff=barcodeval_get("memberpic-local-suffix");
		$pref=barcodeval_get("memberpic-local-prefix");
		$from ="$dcrs/pic/$pref$ID$suff";
		$to="$dcrs/pic/$pref$newbarcode$suff";
		@rename($from,$to);
////////////picend
			html_dialog("",getlang("เปลี่ยนบาร์โค้ดเรียบร้อย::l::Barcode Changed"));
			
							 $now=time();
tmq("insert into member_edittrace set 
login='$useradminid',
dt='$now',
memid='$UserAdminID',
edittype='update member -change barcode ($ID,$newbarcode) '   ");


			?><BR><?php 
		?>		<A HREF="DBddal.php" class=a_btn><?php  echo getlang("กลับ::l::Back");?></A>
</CENTER><?php 
		foot();
		die;
	}

}

?><BR><TABLE width="<?php  echo $_TBWIDTH?>" align=center class=table_border>
<FORM METHOD=POST ACTION="chbarcode.php">
<INPUT TYPE="hidden" NAME="ID" value="<?php  echo $ID?>">
<INPUT TYPE="hidden" NAME="issave" value="yes">
	<TR>
	<TD class=table_head width=25%><?php echo getlang("เปลี่ยนรหัสบาร์โค้ดของ::l::Change Barcode for");?></TD>
	<TD class=table_td><?php  echo get_member_name("$ID");?></TD>
</TR>
<TR>
	<TD class=table_head width=25%><?php echo getlang("บาร์โค้ดปัจจุบัน::l::Current Barcode");?></TD>
	<TD class=table_td><?php  echo ("$ID");?></TD>
</TR>
<TR>
	<TD class=table_head width=25%><?php echo getlang("เปลี่ยนเป็น::l::Change to");?></TD>
	<TD class=table_td><INPUT TYPE="text" NAME="newbarcode" value="<?php  echo ("$ID");?>" onfocus="this.select();" onclick="this.select();" onmouseup="this.select();"></TD>
</TR>
<TR>
	<TD class=table_td colspan=2 align=center>
		<INPUT TYPE="submit" value="<?php  echo getlang("เปลี่ยน::l::Change");?>">
		<A HREF="DBddal.php" class=a_btn><?php  echo getlang("กลับ::l::Back");?></A>
	</TD>
</TR>
</FORM>
</TABLE><?php 
foot();
?>