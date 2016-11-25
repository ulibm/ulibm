<?php // พ
function umail_que($setid,$email,$title,$body) {
	//echo "umail_que($setid,$email,$title,$body)";die;
	global $useradminid;
	$title=addslashes($title);
	$body=addslashes($body);
	if ($setid=="") {
		die("umail_que need setid");
	}
	if ($title=="") {
		die("umail_que need title");
	}
	if ($body=="") {
		die("umail_que need body");
	}
	tmq("insert into umail_que set
		setid='$setid' ,
		email='$email' ,
		mail_title='$title' ,
		mail_body='$body' ,
		status='wait' ,
		libid='$useradminid' 
	",false);
}
?>