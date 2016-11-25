<?php // พ
	$email_ini_called="yes";

	$mail_ReturnPath=barcodeval_get("mailsetting-ReturnPath");
	$mail_Organization=barcodeval_get("mailsetting-Organization");
	$mail_from=barcodeval_get("mailsetting-from");
	$mail_attatchline=barcodeval_get("mailsetting-attatchline");
	$mail_mailmodefunction=barcodeval_get("mailsetting-mailmodefunction");
	$mail_mailsmtp=barcodeval_get("mailsetting-mailsmtp");
	$mail_mailsmtpu=barcodeval_get("mailsetting-mailsmtpu");
	$mail_mailsmtpp=barcodeval_get("mailsetting-mailsmtpp");
	$mail_mailsmtpport=barcodeval_get("mailsetting-mailsmtpport");
	$mail_autocc=barcodeval_get("mailsetting-mail_autocc");
	$mail_sendmail_path=barcodeval_get("mailsetting-sendmail_path");

	ini_set("SMTP","$mail_mailsmtp"); //win
	ini_set("sendmail_path","$mail_sendmail_path"); // *nix

	ini_set("sendmail_from","$mail_from");
	ini_set("SMTP","$mail_mailsmtp");
	include_once($dcrs."inc/PHPMailer-master/PHPMailerAutoload.php");

?>