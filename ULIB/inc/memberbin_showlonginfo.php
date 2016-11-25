<?php 
function memberbin_showlonginfo($id,$dspname="") {
	global $member_showlonginfo_isshowexternallinks;
	global $_ROOMWORD;
	global $_TBWIDTH;
	global $thaimonstr;
	global $_memid;
	global $dcrURL;
	global $memberspechtml;
	global $dcr;
			$sql2="select * from member_bin where UserAdminID='$id'";
			//echo ($sql2);
			$result2=tmq($sql2,false);
				$nnnn=tmq_num_rows($result2);
				$s=tmq_fetch_array($result2);

			if ($nnnn == 0)
				{
				html_dialog("","ไม่พบรหัสสมาชิกนี้! กรุณาระบุใหม่ ::l::Barcode id not found!");
				//die();
				}
		?>
<br />
<TABLE cellpadding=0 border=0 cellspacing=0 width="<?php  echo $_TBWIDTH;?>" align=center class=table_border >
<TR valign=top>
	<TD width=50><IMG SRC='<?php  echo member_pic_url($id);?>' width=128 height=144 <?php  echo $memberspechtml?> onerror="this.src='/<?php  echo $dcr?>/pic/no.jpg'" BORDER=0 ALT=''><?php 
	if ($member_showlonginfo_isshowexternallinks!="no"  ) {
		if ( ($id==$_memid || loginchk_lib('chk'))) {
			echo "<br><br><a href=\"$dcrURL"."member/log.login.php?mem=$s[UserAdminID]\" class='smaller2 a_btn'>".getlang("ประวัติการล็อกอิน::l::Login History")."</a>";
			echo "<br><a href=\"$dcrURL"."member/log.ms.php?mem=$s[UserAdminID]\" class='smaller2 a_btn'>".getlang("ประวัติการเข้าห้องสมุด::l::Gate History")."</a>";
      }
		if ( ( loginchk_lib('chk'))) {

        	echo "<br><a href=\"$dcrURL"."member/log.edit.php?mem=$s[UserAdminID]\" class='smaller2 a_btn'>".getlang("ประวัติการแก้ไข::l::Update History")."</a>";
		}
	}
		?></TD>
	<TD>
	<TABLE cellpadding=0 border=0 cellspacing=0 width=100% > 
	<TR>
		<TD class=table_head <?php  echo $addhtmlsizehead;?>><?php  echo getlang("Barcode::l::Barcode");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo $s[UserAdminID]?></TD>
	</TR>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("ชื่อ::l::Name");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo $dspname;
										?></TD>
	</TR>
	<TR>
	
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>>Credits</TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php 
		echo number_format($s[credit]);?></TD>
	</TR>
	<TR>
	
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>>Description</TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php 
		echo stripslashes($s[descr]);?></TD>
	</TR>	
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("ประเภทสมาชิก::l::Member Type");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php 
		$rooms=tmq("select * from member_type where type='$s[type]'");
		$rooms=tmq_fetch_array($rooms);
		echo getlang($rooms[descr])?></TD>
	</TR>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("$_ROOMWORD");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php 
		echo get_room_name($s[room]);?></TD>
	</TR>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("ที่อยู่::l::Address");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo $s[address]?></TD>
	</TR>

	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("รายละเอียดอื่น::l::Note")?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo $s[descr]?></TD>
	</TR>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("อีเมล์::l::Email")?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo $s[email]?></TD>
	</TR>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("เบอร์โทรศัพท์::l::Tel.")?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo $s[tel]?></TD>
	</TR>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang("สาขาห้องสมุด::l::Campus");?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo get_libsite_name($s[libsite])?></TD>
	</TR>
<?php 
$cust=tmq("select * from member_customfield where isshow='yes' and isshowtouser='yes' order by fid");
while ($custr=tmq_fetch_array($cust)) {
?>
	<TR>
		<TD class=table_head  <?php  echo $addhtmlsizehead;?>><?php  echo getlang($custr[name]);?></TD>
		<TD class=table_td <?php  echo $addhtmlsize;?>><?php  echo $s[$custr[fid]]?></TD>
	</TR>
<?php 
}
		
?>
</table>

</td></tr>
</table>
										<?php 
}
?>