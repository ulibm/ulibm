<?php 
function captcha_s() {
	global $dcrURL;
	global $_SESSION;
	global $PHP_SELF;

	?><iframe src="<?php  echo $dcrURL;?>inc/phpcaptcha/face.php?picker=<?php  echo randid();?>" align=absmiddle FRAMEBORDER="no" BORDER=0
 SCROLLING=NO width=300 height=90 style="float:left"></iframe> Enter the letters: 
 <INPUT TYPE="text" NAME="captchatry" value="" style="font-weight: bold;" size=5>
 <INPUT TYPE="hidden" NAME="captchatry_activated" value="yes"><BR>
	<FONT SIZE="-2" COLOR="#5D5D5D" class=smaller>* <?php  echo getlang("ไม่แยกตัวพิมพ์เล็กใหญ่::l::cast insensitive");?></FONT><?php 
}
?>