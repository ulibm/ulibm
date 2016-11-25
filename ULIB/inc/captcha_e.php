<?php // พ
function captcha_e() {
	@session_start();
	global $_POST;
	global $dcrs;
	global $_SESSION;
	//if (isset($_POST['captchatry'])) {
	if (isset($_POST['captchatry_activated'])) {
		include("$dcrs/inc/phpcaptcha/securimage.php");
		$img = new Securimage();
		$valid = $img->check($_POST['captchatry']);

		if($valid == true) {
			filelogs("captcha_correct","[captcha=$try]","captcha_correct");
			//die('captcha pass');
		} else {
			filelogs("captcha_incorrect","[captcha=$try]","captcha_incorrect");
			echo "<TABLE bgcolor=f5f5f5>
			<TR>
				<TD><B>FATAL ERROR</B>:Captcha error, please click <A HREF='javascript:history.go(-1)'>back</A> to continue; <BR>
				Enter=".$_POST['captchatry']."</TD>
			</TR>
			</TABLE>";
			die;
		}
	} else {
		filelogs("captcha_skipping","[captcha=$try]","captcha_skipping");
	}
}
?>