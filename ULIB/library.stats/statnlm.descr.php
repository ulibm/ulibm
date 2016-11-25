<?php  
	; 
		
        include ("../inc/config.inc.php");
		head();
		html_start();
	include("_REQPERM.php");
	mn_lib();
       // mn_lib();
	pagesection(getlang("แก้ไขข้อความบรรยายสถิติ::l::Manage stat. description"));

	
if ($issave=="yes") {
	barcodeval_set("statnlm-str-descr",addslashes($descr));
}
?><center><form method=post action="<?php echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<table border = 0 cellpadding = 0 width =<?php echo $_TBWIDTH;?> align = center cellspacing=30>

 <tr valign = "top">
  <td width=50%><TEXTAREA NAME="descr" ROWS="" COLS="" style="width:100%; height:500"><?php echo barcodeval_get("statnlm-str-descr"); ?></TEXTAREA><BR>
  โค้ด=ข้อความบรรยาย<BR>
  1 คำบรรยายต่อ 1 บรรทัด</td>
 </tr>
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr>
</table><BR>
</form>
	<a href='statnlm.php' class='smaller a_btn'><?php echo getlang("กลับ::l::Back");?></a>
</center>
<?php  
foot();
?>