<?php redir("$dcrURL/member/logout.php",1800);?>
<table width = "<?php  echo $_TBWIDTH;?>" align=center border = "0" cellspacing = "0" cellpadding = "3" bgcolor = "#bbbbbb" class=table_border >

    <tr >
        <td class='smaller table_td'> &nbsp; <IMG SRC="<?php  echo $dcrURL?>neoimg/userlock.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle> <?php  echo getlang("สมาชิก::l::Member"); ?>:
<?php 
    echo get_member_name($_memid);
    echo " <FONT class=smaller2>($_memid)</FONT>";
?> 
<?php 
	$s= "select * from member where UserAdminID='$_memid'";
	//echo $s;
	$s=tmq($s);
	if (tmq_num_rows($s)==0) {
		$s=tmq("Select * From ulib_clientlogins Where loginid='".substr($_memid,4)."'  AND isallowed ='yes' ",false);
		$s=tmq_fetch_array($s);
	} else {
		$s=tmq_fetch_array($s);
	}

	$s= "select * from member_type where type='$s[type]'";
	//echo $s;
	$s=tmq($s);
	$s=tmq_fetch_array($s);
	if ($s[descr]!="") {
		echo "<FONT class=smaller2>(".html_membertype_icon($s[type]).getlang("$s[descr]").")</FONT>";
	}
?>
</td>
        <td width = "50%" align = "right" class='smaller table_td'>
		<?php 

if (substr($_memid,0,4)=="uug:") {
	html_xpbtn(getlang("แก้ไขข้อมูล::l::Edit information").",$dcrURL/member/uug.chpwd.php,gray"
	."::".getlang("รายชื่อผู้ติดต่อ::l::Staff information").",$dcrURL/member/uug.staff.php,gray"
	."::".getlang("ออกจากระบบ::l::Logout").",$dcrURL/member/logout.php,red"
	);
} else {
	html_xpbtn(getlang("หน้าหลักสมาชิก::l::Main page").",$dcrURL/member/mainadmin.php,gray"
	."::".getlang("แก้ไขข้อมูลส่วนตัว::l::Edit personal Info.").",$dcrURL/member/chpwd.php,gray"
	."::".getlang("ออกจากระบบ::l::Logout").",$dcrURL/member/logout.php,red"
	);
}
		?></td>
    </tr>
</table>