<?php 
     include("../inc/config.inc.php");
	 head();
	 include("_REQPERM.php");
	 mn_lib();

	$rules=tmq("select * from media where ID='$editLIBSITEOWNER' ");
	$rules=tmq_fetch_array($rules);
  if ($rules[LIBSITE]==$LIBSITE || getlibsitebibrule($LIBSITE,$rules[LIBSITE],"permission-chowner")=="yes") {
	  tmq("update media set LIBSITE='$setLIBSITE' where ID='$editLIBSITEOWNER'  limit 1");
  } else {
	html_dialog("Error!",getlang("คุณไม่มีสิทธิ์เปลี่ยนเจ้าของ Bib::l::You have no permission to change Bib. owner"));	
}
redir("DBbook.php?keyword=$keyword&isbn=$isbn&sbc=$sbc&startrow=$startrow&IDEDIT=$editLIBSITEOWNER&authorname=$authorname");
?>