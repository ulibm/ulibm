<?php 
	; 
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="personalsettings";
        $tmp=mn_lib();
if ($issave=="yes") {
	barcodeval_set("personalsetting-o-hidelibmann-$useradminid",addslashes($hidelibmann));
	barcodeval_set("personalsetting-o-minsscreensaver-$useradminid",floor($minsscreensaver));
	barcodeval_set("personalsetting-o-usepushmenu-$useradminid",addslashes($usepushmenu));
	barcodeval_set("personalsetting-o-mainmenuswitchtabmode-$useradminid",addslashes($mainmenuswitchtabmode));
	barcodeval_set("personalsetting-o-pushmenulocation-$useradminid",addslashes($pushmenulocation));
	barcodeval_set("personalsetting-o-useqrreaderatcir-$useradminid",addslashes($useqrreaderatcir));
	barcodeval_set("personalsetting-o-keepalivesession-$useradminid",addslashes($keepalivesession));
	if ($issave=="yes") {
      redir($PHP_SELF); die;
   }
}
?>
                <div align = "center">
<?php 
pagesection(getlang($tmp));
?>
<table border = 0 cellpadding = 0 width = 780 align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">

<input type=hidden name="issave" value="yes">
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ใช้เมนูด่วน::l::Use Push menu");?></td>
  <td  align=center class=table_td><?php  form_quickedit("usepushmenu",barcodeval_get("personalsetting-o-usepushmenu-$useradminid"),"list:yes,no"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ตำแหน่งเมนูด่วน::l::Push menu Style");?></td>
  <td  align=center class=table_td><?php  form_quickedit("pushmenulocation",barcodeval_get("personalsetting-o-pushmenulocation-$useradminid"),"list:Left,Menu Bar"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("สลับแท็บที่เมนูหลักเมื่อ::l::Switch tab in main menu when");?></td>
  <td  align=center class=table_td><?php  form_quickedit("mainmenuswitchtabmode",barcodeval_get("personalsetting-o-mainmenuswitchtabmode-$useradminid"),"list:MouseOver,Click"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("จำนวนนาทีสำหรับตัวพักหน้าจอ::l::Minutes for screen saver");?></td>
  <td  align=center class=table_td><?php  form_quickedit("minsscreensaver",barcodeval_get("personalsetting-o-minsscreensaver-$useradminid"),"number"); ?><br>
   <?php  echo getlang("-1 เพื่อไม่ให้ใช้::l::-1  to disable");?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ซ่อนปุ่มวิธีใช้เบื้องต้น::l::Hide mannual button");?> <?php  html_libmann("libmannexample");?></td>
  <td  align=center class=table_td><?php  form_quickedit("hidelibmann",barcodeval_get("personalsetting-o-hidelibmann-$useradminid"),"yesno"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ใช้ตัวช่วยอ่าน QR ในระบบการยืมคืน::l::Use QR READER at circulation");?></td>
  <td  align=center class=table_td><?php  form_quickedit("useqrreaderatcir",barcodeval_get("personalsetting-o-useqrreaderatcir-$useradminid"),"yesno"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ไม่ต้องตัดสถานะล็อกอิน::l::Keep alive session");?></td>
  <td  align=center class=table_td><?php  form_quickedit("keepalivesession",barcodeval_get("personalsetting-o-keepalivesession-$useradminid"),"yesno"); ?></td>
 </tr>


	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
				foot();
?>