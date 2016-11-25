<?php 
;
     include("../inc/config.inc.php");
	 head();
	 include("_REQPERM.php");
	 mn_lib();
$libsitedb=tmq_dump2("library_site","code","name");
?>

<TABLE width="<?php  echo $_TBWIDTH?>" align=center>
<FORM METHOD=POST ACTION="addDBbook.php">
	<TR>
	<TD align=center><TEXTAREA NAME="THEMARC" ID="THEMARC" style="width: 100%; height: 300"></TEXTAREA>
	
	</TD>
</TR>
<TR>
	<TD><INPUT TYPE="submit"> <INPUT TYPE="reset" value="<?php  echo getlang("ยกเลิก::l::Cancel");?>" onclick="self.location='DBbook.php'"></TD>
</TR><INPUT TYPE="hidden" NAME="usethemarc" value='yes'>
</FORM>
</TABLE>
  <?php 
  foot();
  ?>