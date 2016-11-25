<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
        mn_root("activateulib");
?><BR><?php 
			pagesection(getlang("ULIBM - Modify Information"),"login");
?><BR>
<table border = 0 cellpadding = 3 width = 600 align = center cellspacing=0 class=table_border>
<form method=post action="register_save.php">
<input type=hidden name="issave" value="yes">
<tr valign = "top"><td class=table_head> <?php  echo getlang("Referrence code");?></td>
<td width=50% align=left class=table_td><?php  form_quickedit("refcode",barcodeval_get("activateulib-refcode"),"readonlytext"); ?></td></tr>
<tr valign = "top"><td class=table_head> <?php  echo getlang("ชื่อหน่วยงาน ภาษาไทย::l::Organization name (Thai)");?></td>
<td width=50% align=left class=table_td><?php  form_quickedit("orgname_thai",barcodeval_get("activateulib-orgname-thai"),"text"); ?></td></tr>
<tr valign = "top"><td class=table_head> <?php  echo getlang("ชื่อหน่วยงาน ภาษาอังกฤษ::l::Organization name (English)");?></td>
<td width=50% align=left class=table_td><?php  form_quickedit("orgname_eng",barcodeval_get("activateulib-orgname-eng"),"text"); ?></td></tr>
<tr valign = "top"><td class=table_head> <?php  echo getlang("ที่อยู่::l::Address");?></td>
<td width=50% align=left class=table_td><?php  form_quickedit("address",barcodeval_get("activateulib-address"),"longtext"); ?></td></tr>
<tr valign = "top"><td class=table_head> <?php  echo getlang("URL::l::URL");?></td>
<td width=50% align=left class=table_td><?php  form_quickedit("url",$dcrURL,"readonlytext"); ?></td></tr>
<tr valign = "top"><td class=table_head> <?php  echo getlang("เซิร์ฟเวอร์ออนไลน์ตลอดเวลาหรือไม่::l::Always on");?></td>
<td width=50% align=left class=table_td><?php  form_quickedit("alwayson",barcodeval_get("activateulib-alwayson"),"yesno"); ?></td></tr>
<tr valign = "top"><td class=table_head> <?php  echo getlang("วิธีการติดต่อ::l::How to contact");?></td>
<td width=50% align=left class=table_td><?php  form_quickedit("contact",barcodeval_get("activateulib-contact"),"medtext"); ?>
Telephone, Email, etc.</td></tr>

	<tr valign = "top">
	  <td colspan=2 align=center>
	  <B>* Please fill all fields</B><BR>
	  <input type=submit value=' Save '> <INPUT TYPE="reset" value=" Cancel " onclick="self.location='index.php' "></td>
</tr></form>
</table>
<?php 

foot();
?>