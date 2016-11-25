<?php 
	; 
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="borrowlaneconfig";
        $tmp=mn_lib();
		pagesection($tmp);
?>

<?php 
if ($issave=="yes") {
  viewdiffman_add("brlane","brlane",$linktext.$newline.$greeting.$newline.$instruct);
  $s=tmq("select * from library_site");
   while ($r=tfa($s)) {
      eval("\$tmp=\$isenable_$r[code];");
   	barcodeval_set("brlane-isenable-for-$r[code]",addslashes($tmp));
   }
   barcodeval_set("brlane-isenable",addslashes($isenable));
	barcodeval_set("brlane-greeting",addslashes($greeting));
	barcodeval_set("brlane-linktext",addslashes($linktext));
	barcodeval_set("brlane-instruct",addslashes($instruct));
}
?><form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">
<table border = 0 cellpadding = 0 width = 600 align = center cellspacing=30>
<tr valign = "top">
  <td width=50% align=center><b><?php echo getlang("เปิดใช้หรือไม่::l::Enable");?></b> <BR>
  <?php  form_quickedit("isenable",barcodeval_get("brlane-isenable"),"yesno"); ?></td>
 </tr><?php 
$s=tmq("select * from library_site");
while ($r=tfa($s)) {
?>
<tr valign = "top">
  <td width=50% align=center><?php echo getlang("เปิดใช้หรือไม่::l::Enable");?> : <?php echo getlang($r[name]);?> <BR>
  <?php  form_quickedit("isenable_$r[code]",barcodeval_get("brlane-isenable-for-$r[code]"),"yesno"); ?></td>
 </tr>
<?php 
}
?>
 <tr valign = "top">
  <td width=50% align=center><?php echo getlang("ข้อความบนปุ่มให้ผู้ใช้คลิก::l::Text on button");?><BR>
  <?php  form_quickedit("linktext",barcodeval_get("brlane-linktext"),"text"); ?></td>
 </tr>
<tr valign = "top">
  <td width=50% align=center><?php echo getlang("บรรทัดแสดงข้อความต้อนรับ::l::Greeting line");?><BR>
  <?php  form_quickedit("greeting",barcodeval_get("brlane-greeting"),"text"); ?></td>
 </tr>

 <tr valign = "top">
  <td width=50% align=center><?php  form_quickedit("instruct",barcodeval_get("brlane-instruct"),"html"); 
  viewdiffman("brlane","brlane");
  ?><BR>
    <?php 
	frm_globalupload("brlane","brlane");
  ?></td>
 </tr>

	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr>
</table></form>
<?php 
				foot();
?>