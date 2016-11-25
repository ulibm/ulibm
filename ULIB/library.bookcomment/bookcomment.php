<?php 
	; 
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="bookcomment";
        mn_lib();
if ($issave=="yes") {
	viewdiffman_add("bookcomment","bookcomment",$bookcomment_name.$newline.$bookcomment_agreement);

	barcodeval_set("bookcomment_isenable",addslashes($bookcomment_isenable));
	barcodeval_set("bookcomment_name",addslashes($bookcomment_name));
	barcodeval_set("bookcomment_agreement",addslashes($bookcomment_agreement));
	barcodeval_set("bookcomment_instantshow",addslashes($bookcomment_instantshow));
}
?>
                <div align = "center">
<?php 
pagesection(getlang("ตัวเลือก::l::Options"));
?>
<table border = 0 cellpadding = 0 width = "<?php  echo $_TBWIDTH?>" align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">
<input type=hidden name="issave" value="yes">

<tr valign = "top">
	<td class=table_head> <?php  echo getlang("ชื่อระบบ::l::System name");?></td>
  <td width=75% align=center class=table_td><?php  form_quickedit("bookcomment_name",barcodeval_get("bookcomment_name"),"text"); ?></td>
 </tr>
<tr valign = "top">
	<td class=table_head> <?php  echo getlang("เปิดใช้งานหรือไม่::l::Enable this module?");?></td>
  <td  align=center class=table_td><?php  form_quickedit("bookcomment_isenable",barcodeval_get("bookcomment_isenable"),"yesno"); ?></td>
 </tr>
<tr valign = "top">
	<td class=table_head> <?php  echo getlang("โพสท์ข้อความแล้วแสดงทันที::l::Show comment librarian's permission");?></td>
  <td  align=center class=table_td><?php  form_quickedit("bookcomment_instantshow",barcodeval_get("bookcomment_instantshow"),"yesno"); ?></td>
 </tr>
<tr valign = "top">
	<td class=table_head> <?php  echo getlang("ข้อตกลงการใช้งาน::l::Agreement");?></td>
  <td  align=center class=table_td><?php  form_quickedit("bookcomment_agreement",barcodeval_get("bookcomment_agreement"),"html"); 
  viewdiffman("bookcomment","bookcomment");?></td>
 </tr>


	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
				foot();
?>