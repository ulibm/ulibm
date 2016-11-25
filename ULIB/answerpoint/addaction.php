<?php  
	; 
        include ("../inc/config.inc.php");
        include ("../inc/email/ini.php");
		if (barcodeval_get("answerpoint_isenable")!="yes") {
			html_dialog("","this module disabled");
			die;
		}
		head();
        mn_web("answerpoint");
		if ($_memid!="") {
			$now=time();
			$title=addslashes($title);
			$text=addslashes($text);
			tmq("insert into webpage_answerpoint set 
			dt='$now',
			title='$title',
			text='$text',
			memid='$_memid',
			cate='new'
			");
			$newid=tmq_insert_id();
		$dr="$dcrs/answerpoint/attatch/$newid-";
		if (strlen($_FILES['img01']['tmp_name'])!=0) { 
		   copy($_FILES['img01']['tmp_name'], "$dr" . "1.jpg"); 
		   fso_image_fixsize("$dr" . "1.jpg","jpg",500);
		}
		if (strlen($_FILES['img02']['tmp_name'])!=0) { 
		   copy($_FILES['img02']['tmp_name'], "$dr" . "2.jpg"); 
		   fso_image_fixsize("$dr" . "2.jpg","jpg",500);
		}
		$mailto=barcodeval_get("answerpoint_respemail");
		$mailto=trim($mailto);
		if ($mailto!="") {
			$modulename=barcodeval_get("answerpoint_name");
			$body="New message:modulename
Topic: $title
----------------------------
$text	";		
			umail_mail($mailto,"New message:modulename",$body);
		}
//
		}
?>
<TABLE cellpadding=0 cellspacing=0 border=0 width=780 align=center>
<TR valign=top>
	<TD width=200><?php  include("menu.php");?></TD>
<FORM METHOD=POST ACTION="addaction.php">
		<TD align=center><BR>
		<?php  
		if ($_memid=="") {
			echo getlang("การตั้งคำถาม จะต้องล็อกอินเข้าระบบก่อน::l::Please login before open a question.");
			echo "<BR><A HREF='../member/index.php?backto=".urlencode("$dcrURL/answerpoint/add.php")."'>".getlang("ล็อกอินที่นี่::l::Login here")."</A>";
		} else {

			html_dialog("",getlang("คำถามได้ถูกบันทึกไว้แล้ว กรุณารอการตรวจสอบจากเจ้าหน้าที่ครับ::l::Question saved, please wait officer to solve this."));
		}
		?>
		</TD>

</FORM></TR>
</TABLE>
<?php  
				foot();
?>