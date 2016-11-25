<?php 
	; 
		
        include ("../inc/config.inc.php");
		//head();
		html_start();
		include("_REQPERM.php");
		loginchk_lib();
       // mn_lib();
	pagesection(getlang("แก้ไขข้อความบรรยายสถิติ::l::Manage stat. description"));

	
if ($issave=="yes") {
	barcodeval_set("quickstat-descr",addslashes($descr));
}
?>
<table border = 0 cellpadding = 0 width = 100% align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
 <tr valign = "top">
  <td width=50%><TEXTAREA NAME="descr" ROWS="" COLS="" style="width:100%; height:500"><?php  echo barcodeval_get("quickstat-descr"); ?></TEXTAREA><BR>
  โค้ด=ข้อความบรรยาย<BR>
  1 คำบรรยายต่อ 1 บรรทัด<BR>
  <font class=smaller>* ข้อความบรรยายเหล่านี้ถูกนำไปใช้กับสถิติการยืมคืนแยกตามหมวดด้วย</font></td>
 </tr>
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
?>