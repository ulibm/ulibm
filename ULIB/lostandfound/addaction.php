<?php 
	; 
        include ("../inc/config.inc.php");
		if (barcodeval_get("lostandfound_isenable")!="yes") {
			html_dialog("","this module disabled");
			die;
		}

		head();
        mn_web("lostandfound");
		if (library_gotpermission("lostandfound")) {
			$now=time();
			$title=addslashes($title);
			$text=addslashes($text);
			$tags=@implode($tags,',');
			$tags=",,$tags,,";

			tmq("insert into webpage_lostandfound set 
			dt='$now',
			title='$title',
			taglist='$tags',
			text='$text',
			memid='$useradminid',
			cate='new'
			");
			$newid=tmq_insert_id();
		//printr($_FILES);
		$dr="$dcrs/lostandfound/attatch/$newid-";
		if (strlen($_FILES['img01']['tmp_name'])!=0) { 
		   copy($_FILES['img01']['tmp_name'], "$dr" . "1.jpg"); 
		   fso_image_fixsize("$dr" . "1.jpg","jpg",500);
		}
		if (strlen($_FILES['img02']['tmp_name'])!=0) { 
		   copy($_FILES['img02']['tmp_name'], "$dr" . "2.jpg"); 
		   fso_image_fixsize("$dr" . "2.jpg","jpg",500);
		}

		}
?>
<TABLE cellpadding=0 cellspacing=0 border=0 width=780 align=center>
<TR valign=top>
	<TD width=200><?php include("menu.php");?></TD>
<FORM METHOD=POST ACTION="addaction.php">
		<TD align=center><BR>
		<?php 
		if (library_gotpermission("lostandfound")!=true) {
			echo getlang("เฉพาะเจ้าหน้าที่ที่ได้รับสิทธิ์ จึงจะโพสท์รายการใหม่ได้::l::Only granted officer can post new item.");
		} else {

			html_dialog("",getlang("รายการได้ถูกบันทึกแล้ว::l::Record saved."));
		}
		?>
		</TD>

</FORM></TR>
</TABLE>
<?php 
				foot();
?>