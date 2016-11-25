<?php 
	; 
        include ("../inc/config.inc.php");
		if (barcodeval_get("answerpoint_isenable")!="yes") {
			html_dialog("","this module disabled");
			die;
		}
		head();
        mn_web("answerpoint");
		if ($id=="" || library_gotpermission("answerpoint")==false) {
			die('die perm or id');
		}
			$now=time();
			$answer=addslashes($answer);
			$tags=@implode($tags,',');
			$tags=",,$tags,,";
			tmq("update webpage_answerpoint set 
			lastmovedt='$now',
			loginid='$useradminid',
			answer='$answer',
			taglist='$tags',
			cate='$setcateforans'
			where id='$id'
			");

		$dr="$dcrs/answerpoint/attatch/$id-";
		if (strlen($_FILES['img01']['tmp_name'])!=0) { 
			@unlink("$dr" . "a1.jpg");
		   copy($_FILES['img01']['tmp_name'], "$dr" . "a1.jpg"); 
		   fso_image_fixsize("$dr" . "a1.jpg","jpg",500);
		}
		if (strlen($_FILES['img02']['tmp_name'])!=0) { 
			@unlink("$dr" . "a2.jpg");
		   copy($_FILES['img02']['tmp_name'], "$dr" . "a2.jpg"); 
		   fso_image_fixsize("$dr" . "a2.jpg","jpg",500);
		}
		if (strlen($_FILES['img03']['tmp_name'])!=0) { 
			@unlink("$dr" . "a3.jpg");
		   copy($_FILES['img03']['tmp_name'], "$dr" . "a3.jpg"); 
		   fso_image_fixsize("$dr" . "a3.jpg","jpg",500);
		}

?>
<TABLE cellpadding=0 cellspacing=0 border=0 width="<?php  echo $_TBWIDTH?>" align=center>
<TR valign=top>
	<TD width=200><?php include("menu.php");?></TD>
<FORM METHOD=POST ACTION="addaction.php">
		<TD align=center><BR>
		<?php 


			html_dialog("",getlang("คำตอบได้ถูกบันทึกไว้แล้ว ::l::Answer saved"));

		?><BR><B><A HREF="view.php?id=<?php  echo $id?>"><?php echo getlang("คลิกเพื่อดูข้อความที่โพสท์::l::Click to view");?></A></B>
		</TD>

</FORM></TR>
</TABLE>
<?php 
				foot();
?>