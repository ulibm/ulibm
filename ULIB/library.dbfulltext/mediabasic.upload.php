<?php 
include("../inc/config.inc.php");
	 include("_REQPERM.php");
	 loginchk_lib();
	 html_start();
barcodeval_set("TMP-ftcontent-$useradminid-mid",$mid);
barcodeval_set("TMP-ftcontent-$useradminid-FTCODE",$FTCODE);

	 ?>

<FORM METHOD=POST ACTION="uploadScript.php" enctype="multipart/form-data">
<INPUT TYPE="hidden" NAME="uploadDir" value="yes">
<INPUT TYPE="hidden" NAME="redirback" value="yes">
	 <TABLE width=300 align=center>
			 <TR>
		<TD><span ID="uploading" style="display:none">Uploading: <IMG SRC="../neoimg/uploading.gif" WIDTH="128" HEIGHT="15" BORDER="0" ALT="" align=absmiddle> <A HREF="mediabasic.upload.php?FTCODE=<?php  echo $FTCODE?>&mid=<?php  echo $mid?>" ><?php  echo getlang("ยกเลิก::l::Cancel");?></A></span>
		
		<span ID="uploadbtn"><INPUT TYPE="file" NAME="Filedata" 
		onchange="submitchk(this)"
		onkeydown="return false;"></span></TD>
		<!-- <TD><INPUT TYPE="submit" value=" Upload "></TD> -->
	 </TR>
	 </TABLE>
	 </FORM>
<SCRIPT LANGUAGE="JavaScript">
<!--
pic1= new Image(100,25); 
pic1.src="../neoimg/uploading.gif"; 

function submitchk(wh) {
	if (wh.value=="") {
		return;
	}
	tmp=getobj("uploadbtn");
	tmp.style.display="none";
	tmp=getobj("uploading");
	tmp.style.display="inline";
	document.forms[0].submit();
}
//-->
</SCRIPT>
	 <?php 
	 if ($fname!="") {
		echo "<B><FONT COLOR=darkgreen><CENTER>$fname uploaded</CENTER></FONT></B>";
	 }
	 ?>
