<?php 
	; 
        include ("../inc/config.inc.php");
		if (barcodeval_get("lostandfound_isenable")!="yes") {
			html_dialog("","this module disabled");
			die;
		}
		head();
        mn_web("lostandfound");
		if ($id=="" || library_gotpermission("lostandfound")==false) {
			die('die perm or id');
		}
			$now=time();
			$answer=addslashes($answer);
			$tags=implode($tags,',');
			$tags=",,$tags,,";

			tmq("update webpage_lostandfound set 
			lastmovedt='$now',
			loginid='$useradminid',
			taglist='$tags',
			answer='$answer',
			cate='$setcateforans'
			where id='$id'
			");
?>
<TABLE cellpadding=0 cellspacing=0 border=0 width=780 align=center>
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