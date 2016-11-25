<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
		$_REQPERM="memberspic";
        mn_lib();

			pagesection(getlang("ตั้งค่าภาพสมาชิก::l::Member Photo configuration"));

if ($issave=="yes") {
	barcodeval_set("memberpic-wheresave",$wheresave);
	barcodeval_set("memberpic-local-prefix",$local_pre);
	barcodeval_set("memberpic-local-suffix",$local_suf);
	barcodeval_set("memberpic-global-prefix",$global_pre);
	barcodeval_set("memberpic-global-suffix",$global_suf);
	?><BR><BR><CENTER><FONT SIZE="" COLOR="darkgreen"><B><?php  echo getlang("บันทึกข้อมูลเรียบร้อยแล้ว::l::Configuration Saved"); ?></B></FONT></CENTER><BR><?php 
}

?><BR><table width="770" border="0" cellspacing="1" cellpadding="3" align=center>
<form name="form1" method="post" action="index.php">
  <tr>
    <td colspan="2" bgcolor=#E1E1E1><B><?php  echo getlang("กรุณาเลือกการเก็บ::l::Choose Photo place"); ?></B></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor=#F0F0F0>
      <strong>
      <input name="wheresave" type="radio" value="local" style="border: 0"  <?php  if (barcodeval_get("memberpic-wheresave")=="local") { echo "checked";}?>> 
      Local (Recommended) </strong><BR>
     <FONT style="font-size: 14px;"> <?php  echo getlang("การเก็บแบบนี้ ให้นำภาพมาเก็บไว้ที่โฟลเดอร์ /pic/ ภายในโฟลเดอร์ของโปรแกรม และให้ตั้งชื่อไฟล์ตามรหัสสมาชิก (บาร์โค้ด) ::l::Put photo files in folder /pic/ within ULIB folder the n named files as member barcode."); ?></FONT></td>
  </tr>
  <tr>
    <td width="156">&nbsp;</td>
    <td width="609"><FONT style="font-size: 14px;"><?php  echo getlang("หากมีข้อความในชื่อไฟล์ ก่อนรหัส กรุณาใส่ที่นี่ ::l::Enter file prefix here (If have)"); ?>
      <input name="local_pre" type="text" size="15" value="<?php  echo barcodeval_get("memberpic-local-prefix"); ?>">
      <br>
	  <?php  echo getlang("นามสกุลของไฟล์ เป็นไฟล์ประเภท JPEG เท่านั้น แต่กรุณาเลือกตัวพิมพ์ใหญ่-เล็กให้เรียบร้อย ::l::Accept only JPEG image , please specify file suffix (CASE SENSITIVE)"); ?>
      
      <input name="local_suf" type="text" size="15" value="<?php  echo barcodeval_get("memberpic-local-suffix"); ?>"></FONT></td>
    </tr>
  <tr>
    <td colspan="2"  bgcolor=#F0F0F0><strong>
      <input name="wheresave" type="radio" value="global" style="border: 0"  <?php  if (barcodeval_get("memberpic-wheresave")=="global") { echo "checked";}?>> 
      Global</strong><BR>
  <FONT style="font-size: 14px;"><?php  echo getlang("การเก็บแบบนี้ จะเป็นการเก็บว่า URL ของภาพสมาชิกนั้นอยู่ที่ไหน ในกรณีที่เก็บภาพไว้ต่างเซิร์ฟเวอร์::l::Put member's photo anywhere on internet "); ?></FONT></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td><FONT style="font-size: 14px;"><?php  echo getlang("กรุณาใส่ URL ที่เก็บไฟล์ที่นี่ ::l::Enter photos URL here"); ?>
      <input name="global_pre" type="text" size="40" value="<?php  echo barcodeval_get("memberpic-global-prefix"); ?>">
      <br>

  <?php  echo getlang("นามสกุลของไฟล์ เป็นไฟล์ประเภท JPEG เท่านั้น แต่กรุณาเลือกตัวพิมพ์ใหญ่-เล็กให้เรียบร้อย ::l::Accept only JPEG image , please specify file suffix (CASE SENSITIVE)"); ?><input name="global_suf" type="text" size="15" value="<?php  echo barcodeval_get("memberpic-global-suffix"); ?>"></FONT></td>
    </tr>
  <tr align="center">
    <td colspan="2">
	<INPUT TYPE="hidden" name=issave value="yes">
	<input type="submit" name="Submit" value=" <?php  echo getlang("บันทึกข้อมูล::l::Save"); ?> "></td>
    </tr>
</form>
</table>

<BR><BR>

</TD>
</TR>
</TABLE><BR><?php 
foot();
?>