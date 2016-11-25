<?php  // พ
function umail_mail($to,$subj,$body,$setheaders="") {
	//echo "umail_mail($to,$subj,$body,$setheaders)";
	global $umail_mail_libid;
	global $useradminid;
	if ($umail_mail_libid=="") {
		$umail_mail_libid=$useradminid;
	}
	global $mail_autocc;
	global $email_ini_called;
	$mail_autocc=trim($mail_autocc);
	global $mail_ReturnPath;
	global $mail_Organization;
	global $mail_from;
	global $mail_attatchline;

	global $mail_mailsmtp;
	global $mail_mailsmtpu;
	global $mailmodefunction;
	global $mail_mailsmtpp;
	global $dcrs;
	global $mail_sendmail_path;

	global $mail_forcelocal;
	global $_ISULIBMASTER;

	if ($email_ini_called!="yes") {
		include_once($dcrs."inc/email/ini.php");
		//die("Please include inc/email/ini.php before call umail_mail(); ");
	}
	$res="";
	$body.="
$mail_attatchline";
	if ($setheaders=="") {
		$headers = "From: $mail_from" . "\r\n" .
		"Reply-To: $mail_from";
		if ($mail_autocc!="") {
			$headers .="Bcc: $mail_autocc";
		}
	} else {
		$headers=$setheaders;
	}
	//add logs s
	tmq("insert into email_log
	set
	dt='".time()."',
	toemail='".addslashes($to)."',
	libid='".addslashes($umail_mail_libid)."',
	subj='".addslashes($subj)."',
	body='".addslashes($body)."'
	");


	//add logs e
	if (barcodeval_get("mailsetting-mailsystem")=="local" || $mail_forcelocal=="yes") {
	//echo "here";
		if (barcodeval_get("mailsetting-mailmodefunction")=="mail") {
			if (mail($to, $subj, $body,$headers)) {
				$res="success";
			} else {
				$res="error";
			} 
		} else {
			//Create a new PHPMailer instance
			$mail = new PHPMailer();
			//Tell PHPMailer to use SMTP
			$mail->isSMTP();
			//Enable SMTP debugging
			// 0 = off (for production use)
			// 1 = client messages
			// 2 = client and server messages
			$mail->SMTPDebug = 0;
			//Ask for HTML-friendly debug output
			$mail->Debugoutput = 'html';
			//Set the hostname of the mail server
			$mail->Host = $mail_mailsmtp;
			//Set the SMTP port number - likely to be 25, 465 or 587
			$mail->Port = $mail_mailsmtpport;
			//Whether to use SMTP authentication
			if ($mail_mailsmtpu!="" || $mail_mailsmtpp!="") {
				$mail->SMTPAuth = true;
				//Username to use for SMTP authentication
				$mail->Username = $mail_mailsmtpu;
				//Password to use for SMTP authentication
				$mail->Password = $mail_mailsmtpp;
				//echo "$mail_mailsmtpu/$mail_mailsmtpp";
			}
			//echo "mail_mailsmtp=$mail_mailsmtp;mail_mailsmtpport=$mail_mailsmtpport; u=$mail_mailsmtpu; p=$mail_mailsmtpp";
			$mail->addCustomHeader("X-userid: $to");
			//Set who the message is to be sent from
			$mail->setFrom($mail_from);
			//Set an alternative reply-to address
			$mail->addReplyTo($mail_ReturnPath);
			//Set who the message is to be sent to
			$mail->addAddress($to);
			//Set the subject line
			$mail->Subject = $subj;
			//Read an HTML message body from an external file, convert referenced images to embedded,
			//convert HTML into a basic plain-text alternative body
			//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
			$mail->msgHTML($body);
			//Replace the plain text body with one created manually
			$mail->AltBody =$body;
			//Attach an image file
			//$mail->addAttachment('images/phpmailer_mini.png');

			//send the message, check for errors
			if (!$mail->send()) {
				// echo "Mailer Error: " . $mail->ErrorInfo;
				$res="error";
			} else {
				$res="success";
			}
		}
		/*if (mail($to, $subj, $body,$headers)) {
			$res="success";
		} else {
			$res="error";
		} */
		filelogs("umail-local",$to.$subj.$body.$headers,"umail");
		return $res;
	} else {
//echo "herexx";return "xx";
		$refcode=barcodeval_get("activateulib-refcode");
		if ($_ISULIBMASTER=="yes") {
			$refcode="MASTER";
		}
		$url = barcodeval_get("mailsetting-centralurl").'_mailclient/index.php';
		/*$myvars = 'to=' . base64_encode($to) .
			'subj=' . base64_encode($subj) .
			'refcode=' . base64_encode($refcode) .
			'body=' . base64_encode($body) .
			'headers=' . base64_encode($headers);*/
		$data = array('to' => base64_encode($to),
			'subj' => base64_encode($subj),
			'refcode' => base64_encode($refcode),
			'body' => base64_encode($body),
			'headers' => base64_encode($headers));
		$ch = curl_init(  );
		//echo "[URL=$url;]"; 		echo "[data=";printr($data);echo "]";
		//$url="http://www.ulibm.net/ULIB6/inex.php";
		$url=$url."?rand=".randid();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST , false);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: text/html')); 
      curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');


      curl_setopt($ch, CURLOPT_REFERER, 'http://www.ulibm.net/ULIB6/inex.php');
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt( $ch, CURLOPT_HEADER, 0);
		curl_setopt($ch,CURLOPT_POST,true);
		curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($data, '', '&'));
		//curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);

		$response = curl_exec( $ch );
		//$h = curl_getinfo($ch); printr($h);
		filelogs("umail-central","$to.$subj.$body.$headers","umail");
		///if ($response==true) echo "its true";
		//if ($response==false) echo "its false";
		//echo "resp=[$response]"; printr($response); //echo "here";
		return "".$response;
	}
	/*,"Return-Path: $mail_ReturnPath
From: $mail_from
To: $to
Organization: $mail_Organization
"*/

}
?>