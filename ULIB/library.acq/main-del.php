<?php 
;
include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();

?><BR><TABLE width=400 align=center>
<TR>
	<TD>
<?php 
$tbmn="width=400 cellpadding=2 cellspacing=1
bgcolor=777777";

function local_set($item,$title) {
?><IMG SRC="../image/arrow.gif" WIDTH="14" HEIGHT="9" BORDER="0" ALT="" align=absmiddle> <A HREF="set.php?item=<?php  echo $item?>"><?php echo $title?></A><BR>
<?php 	
}
html_librarymenu("acqmenu_main");
html_librarymenu("acqmenu_Edittext");
?>
 <TABLE width=100%>
<TR>
<TD class=table_td style="padding-left: 15px;">
<?php 
	local_set("send-head2","".getlang("แก้ไขที่อยู่ห้องสมุด::l::Edit library's address")."");
?>
<B><?php  echo getlang("ใบสั่งซื้อ::l::Ordering");?></B><BR>
<?php 
	local_set("send-head","".getlang("แก้ไขข้อความส่วนหัว::l::Edit heading text")."");
	local_set("send-body","".getlang("แก้ไขข้อความ::l::Edit text")."");
?>
<B><?php  echo getlang("ใบสอบราคา::l::Request info.");?></B><BR>
<?php 
	local_set("sob-head","".getlang("แก้ไขข้อความส่วนหัว::l::Edit heading text")."");
	local_set("sob-body","".getlang("แก้ไขข้อความ::l::Edit text")."");
?>
<B><?php  echo getlang("รายการหนังสือ::l::Material lists");?></B><BR>
<?php 
	local_set("list-body","".getlang("แก้ไขข้อความแนะนำ::l::Edit suggestion text")."");
?>

</TD>
</TR>
</TABLE><?php 
html_librarymenu("acqmenu_setting");
?></TD>
</TR>
</TABLE>

<?php foot();?>