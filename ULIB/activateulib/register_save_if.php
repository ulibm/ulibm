<?php 
	; 
		
	include ("../inc/config.inc.php");
	html_start();
	loginchk_root();

	pagesection(getlang("Entered Information"),"narrow");

?>
<table border = 0 cellpadding = 3 width = 100% align = center cellspacing=0 class=table_border>
<form method=post action="<?php  echo getval("SYSCONFIG","ulibmasterurl");?>activateulib/sv/save.php" onsubmit="getobj('localsubmit').disabled=true; return true">
<input type=hidden name="issave1" value="yes">
<input type=hidden name="issave" value="<?php  echo base64_encode($dcrURL);?>">
<tr valign = "top"><td class=table_head> <?php  echo getlang("Referrence code");?></td>
<td width=50% align=left class=table_td><?php  form_quickedit("refcode",barcodeval_get("activateulib-refcode"),"readonlytext_base64"); ?></td></tr>
<tr valign = "top"><td class=table_head> <?php  echo getlang("ชื่อหน่วยงาน ภาษาไทย::l::Organization name (Thai)");?></td>
<td width=50% align=left class=table_td><?php  form_quickedit("orgname_thai",barcodeval_get("activateulib-orgname-thai"),"readonlytext_base64"); ?></td></tr>
<tr valign = "top"><td class=table_head> <?php  echo getlang("ชื่อหน่วยงาน ภาษาอังกฤษ::l::Organization name (English)");?></td>
<td width=50% align=left class=table_td><?php  form_quickedit("orgname_eng",barcodeval_get("activateulib-orgname-eng"),"readonlytext_base64"); ?></td></tr>
<tr valign = "top"><td class=table_head> <?php  echo getlang("ที่อยู่::l::Address");?></td>
<td width=50% align=left class=table_td><?php  form_quickedit("address",barcodeval_get("activateulib-address"),"readonlytext_base64"); ?></td></tr>
<tr valign = "top"><td class=table_head> <?php  echo getlang("เซิร์ฟเวอร์ออนไลน์ตลอดเวลาหรือไม่::l::Always on");?></td>
<td width=50% align=left class=table_td><?php  form_quickedit("alwayson",barcodeval_get("activateulib-alwayson"),"readonlytext"); ?></td></tr>
<tr valign = "top"><td class=table_head> <?php  echo getlang("URL::l::URL");?></td>
<td width=50% align=left class=table_td><?php  form_quickedit("url",$dcrURL,"readonlytext"); ?></td></tr>
<tr valign = "top"><td class=table_head> <?php  echo getlang("วิธีการติดต่อ::l::How to contact");?></td>
<td width=50% align=left class=table_td><?php  form_quickedit("contact",barcodeval_get("activateulib-contact"),"readonlytext_base64"); ?>
</td></tr>

	<tr valign = "top">
	  <td colspan=2 align=center><BR><?php 
	  if (strpos($dcrURL,"localhost")>1 || strpos($dcrURL,"127.0.0")>1  ) {
		echo "<FONT class=smaller color=red>".getlang("<B class=smaller >คำเตือน</B>: หากคุณติดตั้ง ULibM ตัวนี้โดยใช้ชื่อเซิร์ฟเวอร์เป็น localhost หรือ 127.0.0._ แสดงว่าคุณติดตั้งเซิร์ฟเวอร์บนเน็ทเวิร์คภายใน ทำให้ไม่สามารถออนไลน์ได้ในทุกกรณี หากเซิร์ฟเวอร์ของคุณสามารถเชื่อมต่ออินเทอร์เน็ทได้ แนะนำให้ติดตั้ง ULibM โดยใช้หมายเลขไอพีจริง หรือชื่อโดเมน::l::<B class=smaller >Warning</B>: If this copy of ULibM install with domain 'localhost' or 127.0.0._ , means this copy can online in local network only, if possible please install ULibM with external IP (real ip) or domain name.")."</FONT><BR>";
	  }
	  ?><BR>
	  <B>* Target Server is [<?php  echo getval("SYSCONFIG","ulibmasterurl");?>]</B><BR><BR>
	  <input type=submit value=' Submit to ULIB Central ' ID="localsubmit">  <INPUT TYPE="reset" value=" Cancel " onclick="top.location='index.php' "></td>
</tr></form>
</table>