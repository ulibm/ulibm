<?php 
	; 
		
        include ("../inc/config.inc.php");
		//head();
		html_start();
		include("_REQPERM.php");
		loginchk_lib();
       // mn_lib();
		pagesection(getlang("ตั้งค่า URL หลัก::l::Set Server's URL"));

	
if ($issave=="yes") {
	barcodeval_set("automated-url",$url);
}
?>
<table border = 0 cellpadding = 0 width = 100% align = center cellspacing=30>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
 <tr valign = "top">
  <td colspan=2 align=center><?php  echo getlang("URL ของเซิร์ฟเวอร์หลักสำหรับการตั้งเวลาประมวลผล::l::URL of automated task");
  echo "<br>";
  form_quickedit("url",barcodeval_get("automated-url"),"text");
  ?>
	  <input type=submit value=' <?php  echo getlang("บันทึก::l::Save"); ?> '></td>
</tr></form>
</table>
<?php 
?>