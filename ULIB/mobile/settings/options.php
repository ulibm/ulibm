<?php 
	; 
        include ("../../inc/config.inc.php");
		head();
		include("_REQPERM.php");
        mn_lib();
if ($issave=="yes") {
	barcodeval_set("webmobile-options-enable",addslashes($enable));
	barcodeval_set("webmobile-options-showloginform",addslashes($showloginform));
	barcodeval_set("webmobile-options-showsearchform",addslashes($showsearchform));
	barcodeval_set("webmobile-options-titlebartext",addslashes($titlebartext));
	barcodeval_set("webmobile-options-titlebartheme",addslashes($titlebartheme));
	barcodeval_set("webmobile-options-footertext",addslashes($footertext));
	barcodeval_set("webmobile-options-useredirect",addslashes($useredirect));
	barcodeval_set("webmobile-options-redirectscreendecis",addslashes($redirectscreendecis));

}
?>
                <div align = "center">
<?php 
pagesection(getlang("ตัวเลือกของหน้าโฮมเพจ::l::Homepage options"));
?>
<table border = 0 cellpadding = 0 width = 780 align = center cellspacing=0>
<form method=post action="<?php  echo $PHP_SELF?>">

<input type=hidden name="issave" value="yes">
 <tr valign = "top">
	<td class=table_head colspan=2> <?php  echo getlang("ตัวเลือก::l::Options");?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("เปิดใช้งานหรือไม่::l::Enable?");?></td>
  <td  align=center class=table_td><?php  form_quickedit("enable",barcodeval_get("webmobile-options-enable"),"yesno"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("แสดงแบบฟอร์มสืบค้นที่หน้าหลัก::l::Show Search Form at Homepage");?></td>
  <td  align=center class=table_td><?php  form_quickedit("showsearchform",barcodeval_get("webmobile-options-showsearchform"),"yesno"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("แสดงแบบฟอร์มล็อกอินที่หน้าหลัก::l::Show Login Form at Homepage");?></td>
  <td  align=center class=table_td><?php  form_quickedit("showloginform",barcodeval_get("webmobile-options-showloginform"),"yesno"); ?></td>
 </tr>

  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ข้อความ Title bar::l::Title Bar Text");?></td>
  <td  align=center class=table_td><?php  form_quickedit("titlebartext",barcodeval_get("webmobile-options-titlebartext"),"text"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("Theme Title bar::l::Title Bar Theme");?></td>
  <td  align=center class=table_td><img src="theme2.png" width="279" height="220" border="0" alt=""><br>
  <?php  form_quickedit("titlebartheme",barcodeval_get("webmobile-options-titlebartheme"),"list:a,b,c,d,e"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ข้อความส่วนท้าย::l::Footer Text");?></td>
  <td  align=center class=table_td><?php  form_quickedit("footertext",barcodeval_get("webmobile-options-footertext"),"text"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("redirect มายัง mobile web อัตโนมัติ::l::auto redirect to Mobile web");?></td>
  <td  align=center class=table_td><?php  form_quickedit("useredirect",barcodeval_get("webmobile-options-useredirect"),"yesno"); ?></td>
 </tr>

  <tr valign = "top">
	<td class=table_head> <?php  echo getlang("ขนาดกว้างของจอสูงสุดของผู้เยี่ยมชมที่จะเป็นขนาด mobile::l::Maximum screen width for mobile device");?></td>
  <td  align=center class=table_td><?php  form_quickedit("redirectscreendecis",barcodeval_get("webmobile-options-redirectscreendecis"),"number"); ?></td>
 </tr>



	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '></td>
</tr></form>
</table>
<?php 
				foot();
?>