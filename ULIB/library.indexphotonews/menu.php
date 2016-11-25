<?php 
$now=time();
?><style>
.anspointmn {
	text-align: center;
	padding-top: 3;
	padding-bottom: 3;
	padding-left: 7;
	cursor: hand; cursor: pointer;
	border-width: 1px;
	border-color: #8C8C8C;
	border-style:solid;
	text-align: left;
}
.anspointmn a {
	color:#000099;
	text-align: center;
	font-size: 16;
	font-weight:bold;
	cursor: hand; cursor: pointer;
}
.anspointmnsmall a {
	color:white;
	font-size: 14;
	cursor: hand; cursor: pointer;
	font-weight:bold;
	color: #3D4461;
}

.anspointmnsmall {
	border-width: 1px;
	border-color: #8C8C8C;
	border-style:solid;
	text-align: left;
	padding-top: 2;
	padding-bottom: 2;
	cursor: hand; cursor: pointer;
	padding-left:7px;
}
.anspointnum {
	color:#676767;
	text-align: center;
	font-size: 13;
}
</style><TABLE cellpadding=0 cellspacing=2 border=0 width=200 align=center>
<?php if (library_gotpermission("webpage-indexphotonews")) {
?>
<TR>
	<TD class=anspointmnsmall style="background-color: #E7F3F8"><A HREF="setting.php" ><?php  echo getlang("ตั้งค่าระบบ::l::Settings");?></A></TD>
</TR>
<?php }?>
<TR>
	<TD class=anspointmn style="background-color: #E7F3F8"><A HREF="index.php?cate=news" ><?php  echo getlang("ข่าวทั้งหมด::l::All items");?></A></TD>
	<TD class=anspointnum ><?php  
$c=tmq("select * from webpage_indexphotonews where 1 ");
echo number_format(tmq_num_rows($c));
?></TD>
</TR>
<TR>
	<TD class=anspointmn style="background-color: #E7F3F8"><A HREF="index.php?cate=displaying" ><?php  echo getlang("ข่าวที่ปัจจุบัน::l::Current displaying");?></A></TD>
		<TD class=anspointnum ><?php  
$c=tmq("select * from webpage_indexphotonews where cate='news' and dtstart<=$now and dtend>=$now ");
echo number_format(tmq_num_rows($c));
?></TD>
</TR>

<?php 
if (library_gotpermission("webpage-indexphotonews")) {
	?><TR>
	<TD class=anspointmnsmall style="background-color: #e0e0e0"><A HREF="index.php?cate=hide" ><?php  echo getlang("รายการที่ถูกซ่อน::l::Hidden items");?></A></TD>
		<TD class=anspointnum ><?php  
$c=tmq("select * from webpage_indexphotonews where cate='Hidden' ");
echo number_format(tmq_num_rows($c));
?></TD>
</TR><?php 
}
?>

</TABLE>