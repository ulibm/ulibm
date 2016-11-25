<?php 
     include("../inc/config.inc.php");
	 head();
	 include("_REQPERM.php");
	 mn_lib();
?><TABLE width=780 align=center>
<FORM METHOD=POST ACTION="editLIBSITEOWNERAction.php?<?php 
echo "keyword=$keyword&isbn=$isbn&sbc=$sbc&startrow=$startrow&authorname=$authorname";
?>">
	<TR>
	<TD><?php 
	pagesection("แก้ไขเจ้าของ Bib::l::Edit Bib. Owner");
	res_brief_dsp($editLIBSITEOWNER);	
?></TD>
</TR>
<TR>
	<TD align=center><?php 
	$rules=tmq("select * from media where ID='$editLIBSITEOWNER' ");
	$rules=tmq_fetch_array($rules);
  if ($rules[LIBSITE]==$LIBSITE || getlibsitebibrule($LIBSITE,$rules[LIBSITE],"permission-chowner")=="yes") {
	frm_libsite("setLIBSITE",$rules[LIBSITE]);
	?><BR><BR> <INPUT TYPE="submit"><?php 
  } else {
	html_dialog("Error!",getlang("คุณไม่มีสิทธิ์เปลี่ยนเจ้าของ Bib::l::You have no permission to change Bib. owner"));	
}
?><HR width=450><B><A HREF="DBbook.php?<?php 
echo "keyword=$keyword&isbn=$isbn&sbc=$sbc&startrow=$startrow&authorname=$authorname";
?>" class=a_btn>Back</A></B></TD>
</TR><INPUT TYPE="hidden" NAME="editLIBSITEOWNER" value="<?php  echo $editLIBSITEOWNER;?>">
</FORM>
</TABLE><BR><BR><?php 

	foot();
?>