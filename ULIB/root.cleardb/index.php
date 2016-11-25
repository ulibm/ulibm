<?php  
	; 
		set_time_limit(0);
        include ("../inc/config.inc.php");
		head();
        mn_root("cleardb");
?>
                <div align = "center">
<?php  
pagesection(getlang("เคลียร์ (ลบ) ฐานข้อมูล::l::Clear (delete) database"));
?><center><h2 style="color: red"><?php echo getlang("รีเซ็ตฐานข้อมูลให้เหมือนตอนติดตั้งโปรแกรมครั้งแรก <br>โปรดระวัง ข้อมูลใด ๆ ที่อยู่ในฐานข้อมูลจะถูกลบทิ้ง
::l::Reset database to empty (First-install status)<br>Caution: all data in database will be erased");?></h2></center><?php  

if ($clear=="yes") {
	$i=0;
	$buff="";
	$handle = fopen("../install_fixhide/backup-full.sql", "rb");
	$expact="#%%";
	while (!feof($handle)) {
	  $buff .= fread($handle, 1);
	  $decus=substr($buff,-3);
	  if ($decus==$expact) {
		  $buff=trim($buff,$expact);
		tmq($buff);
		$i++;
		$buff="";
	  }
	}
	html_dialog("Database Reloaded", "Done $i queries");;
}

?>
<form method=post action="<?php echo $PHP_SELF?>" onsubmit="return confirm('Clear all data')&& confirm('sure?');">
<input type=hidden name="clear" value="yes">
<table border = 0 cellpadding = 0 width = 600 align = center cellspacing=30>
	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Start '></td>
</tr>
</table></form>
<?php  
				foot();
?>