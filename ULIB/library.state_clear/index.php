<?php 
include("../inc/config.inc.php");
head();
$_REQPERM="stat-candelete";
$tmp=mn_lib();
pagesection($tmp);
			 
		if ($yrtoclearstat!="" && library_gotpermission("stat-candelete")) {
			$s=explode(",","stat_checkout_callnnlm,stat_checkout_callnnlm2,stathist_checkin_media_librarian,stathist_checkin_member_libsite,stathist_checkin_member_media,stathist_checkout_media_librarian,stathist_rqroom_member,stathist_servspoti_member,stathist_renew_member_media,stat_checkin_librarian,stat_checkin_librarian_log,stat_checkout_byhrs,stat_checkout_byhrs_log,stat_checkout_callndc,stat_checkout_callndc2,stat_checkout_callndc2_log,stat_checkout_callnlc2_log,stat_checkout_callnlocal,stat_checkout_callnlocal_log,stat_checkout_callnnlm2_log,stat_checkout_callnnlm_log,stat_checkout_callndc_log,stat_checkout_callnlc,stat_checkout_callnlc2,stat_checkout_callnlc_log,stat_checkout_librarian,stat_checkout_librarian_log,stat_checkout_libsite,stat_checkout_libsite_log,stat_checkout_mbmajor,stat_checkout_mbmajor_log,stat_checkout_mbroom,stat_checkout_mbroom_log,stat_checkout_mbtype,stat_checkout_mbtype_log,stat_checkout_restype,stat_checkout_restype_log,stat_ft_fttype,stat_ft_fttype_log,stat_globaluid,stat_memberlogin_membertype,stat_memberlogin_membertype_log,stat_ms_byhrs,stat_ms_byhrs_log,stat_ms_gatecode,stat_ms_gatecode_log,stat_ms_membertype,stat_ms_membertype_log,stat_sharemarc_type,stat_sharemarc_type_log,stat_visithp_type,stat_visithp_type_log,stathist_checkout_member_libsite,stathist_checkout_member_media,stathist_cir_member,stathist_insidelib_member,stathist_insidelib_mid,stathist_insidelib_restype,stathist_librarian_login_ip,stathist_ms_member_ip,stathist_ms_member_ms,stathist_servspot_member,stathist_ttb_member,stathist_used_shelf_bib,stathist_used_shelf_book,stathist_viewbib_bib_type,statordr_checkout_book,statordr_checkout_member,statordr_ft_resid,statordr_memberlogin_member,statordr_ms_member,statordr_search_text,statordr_searchnotfound_text,statordr_sharemarc,statordr_used_book,stathist_ms_member_gate");
			@reset($s);
			?><table width=600 align=center>
			<tr>
				<td><?php 
			while (list($k,$v)=each($s)) {
				echo " Flushing <b style='color: darkblue;'>$v</b>";
				tmq("delete from $v where yea='$yrtoclearstat' or yea='".($yrtoclearstat+543)."' ");
				//tmq("delete from $v"."_log where yea='$yrtoclearstat' or yea='".($yrtoclearstat+543)."' ");
				echo "  <b style='color: darkgreen;'>done</b>";
			}
			?></td>
			</tr>
			</table><?php 
			 html_dialog("Cleared","Stat for [$yrtoclearstat] cleared");
			 if ($deletemembertrace=="yes") {
			   tmq("delete from member_edittrace where  FROM_UNIXTIME(dt, '%Y')='$yrtoclearstat'");
			   tmq("delete from member_edittrace where  FROM_UNIXTIME(dt, '%Y')='".($yrtoclearstat+543)."'");
			 }
			 if ($deletemediatrace=="yes") {
			   tmq("delete from media_edittrace where  FROM_UNIXTIME(dt, '%Y')='$yrtoclearstat'");
			   tmq("delete from media_edittrace where  FROM_UNIXTIME(dt, '%Y')='".($yrtoclearstat+543)."'");
			 }
		}
?><br />
<form action="<?php  echo $PHP_SELF?>" method="post" onsubmit="return confirm('Please Confirm');">
<input type="hidden" name="db" value="<?php  echo $db;?>" />
	 <table border="0" cellpadding="0" cellspacing="0" width=780 align=center class=table_border>

<tr><td class=table_head><?php  echo getlang("เคลียร์สถิติ::l::Clear Stat.");?></td>
<td class=table_td>
<select name="yrtoclearstat"><?php 
for($y=$_MSTARTY;$y<=$_MENDY;$y++) {
	echo "<option value='".($y-543)."'>$y (".($y-543).")";
}
?></select> <input type="submit" value="Clear"><?php 

?></td>
</tr>
<tr><td class=table_head><?php  echo getlang("ลบสถิติการเพิ่มลบแก้ไขข้อมูลสมาชิก::l::Clear Edit Member Log.");?></td>
<td class=table_td><input type=checkbox name="deletemembertrace" value="yes">
</td>
</tr>
<tr><td class=table_head><?php  echo getlang("ลบสถิติการเพิ่มลบแก้ไขข้อมูลไอเทมและบรรณานุกรม::l::Clear Edit Bib and Item Log.");?></td>
<td class=table_td><input type=checkbox name="deletemediatrace" value="yes">
</td>
</tr>
</table></form><?php 
html_dialog("information",getlang("เป็นการเคลียร์สถิติทั้งหมดที่เกี่ยวข้องกับ - การยืมคืน - การเยี่ยมชมเว็บไซต์ - ระบบประตูทางเข้า - การใช้ในห้องสมุด - การสืบค้น"));
foot(); 
?>