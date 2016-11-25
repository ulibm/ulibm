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
	<TD><INPUT TYPE="submit"> <INPUT TYPE="reset" value="<?php  echo getlang("ยกเลิก::l::Cancel");?>" onclick="self.location='DBbook.php'"><br />
	<label><input type="checkbox" name="noformat" value="yes" /> <?php  echo getlang("ไม่มีรูปแบบ::l::No format") ;?></label> 
	 <a href="noformat.php" class='smaller a_btn'><?php  echo getlang("จัดการตัวเลือก::l::No format Setting") ;?></a>
	</TD>
</TR><INPUT TYPE="hidden" NAME="usethemarc" value='yes'>
</FORM>
</TABLE>
  <?php 
  foot();
  ?>