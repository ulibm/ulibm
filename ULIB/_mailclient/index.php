<?php 
include("../inc/config.inc.php");
function local_gen404() {
header("HTTP/1.0 404 Not Found");
echo "[404]";
die;
}
// พ 
if ($_ISULIBMASTER!="yes") {
	 local_gen404();
}
//printr($_POST);
$mail_forcelocal="yes";
$to=base64_decode($to);
$subj=base64_decode($subj);
$refcode=base64_decode($refcode);
$body=base64_decode($body);
$headers=base64_decode($headers);
$to=stripslashes($to);
$subj=stripslashes($subj);
$refcode=stripslashes($refcode);
$body=stripslashes($body);
$headers=stripslashes($headers);

if ($refcode=="") {
	die("no Referrence code (Please register ULibM)");
}
if ($subj=="") {
	die("no title for email");
}
if ($to=="") {
	die("no Recipient Email");
}
//echo "$to,$subj,$body,$headers";
$tmp=umail_mail($to,$subj,$body,$headers);
echo $tmp;

?>