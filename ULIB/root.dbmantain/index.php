<?php 
	; 
		
        include ("../inc/config.inc.php");
		head();
        mn_root("dbmantain");

			pagesection(getlang("บำรุงรักษาฐานข้อมูล::l::DB miantainience "));

?><BR><TABLE width=500 align=center>
<TR>
	<TD><B>Select Options</B></TD>
</TR>
<?php 
$tblist=tmq("show tables");
$t="";
while ($r=tmq_fetch_array($tblist)) {
	$t=$t . ", $r[0]";
}
$t=trim($t,",");

?>



<FORM METHOD=POST ACTION="../root.sqlexec/index.php" onsubmit="return confirm('ANALYZE confirmation')">
<INPUT TYPE="hidden" name=issave value="yes">
<INPUT TYPE="hidden" name=sqlentered value="ANALYZE TABLES <?php  echo $t;?>">
<TR>
	<TD><INPUT TYPE="submit"value="ANALYZE TABLES"></TD>
</TR>
</FORM>

<FORM METHOD=POST ACTION="../root.sqlexec/index.php" onsubmit="return confirm('CHECK confirmation')">
<INPUT TYPE="hidden" name=issave value="yes">
<INPUT TYPE="hidden" name=sqlentered value="CHECK TABLES <?php  echo $t;?>">
<TR>
	<TD><INPUT TYPE="submit"value="CHECK TABLES"></TD>
</TR>
</FORM>

<FORM METHOD=POST ACTION="../root.sqlexec/index.php" onsubmit="return confirm('OPTIMIZE confirmation')">
<INPUT TYPE="hidden" name=issave value="yes">
<INPUT TYPE="hidden" name=sqlentered value="OPTIMIZE TABLES <?php  echo $t;?>">
<TR>
	<TD><INPUT TYPE="submit"value="OPTIMIZE TABLES"></TD>
</TR>
</FORM>

<FORM METHOD=POST ACTION="../root.sqlexec/index.php" onsubmit="return confirm('REPAIR confirmation')">
<INPUT TYPE="hidden" name=issave value="yes">
<INPUT TYPE="hidden" name=sqlentered value="REPAIR TABLES <?php  echo $t;?>">
<TR>
	<TD><INPUT TYPE="submit"value="REPAIR TABLES"></TD>
</TR>
</FORM>

<FORM METHOD=POST ACTION="../root.sqlexec/index.php" onsubmit="return confirm('CHECKSUM  confirmation')">
<INPUT TYPE="hidden" name=issave value="yes">
<INPUT TYPE="hidden" name=sqlentered value="CHECKSUM TABLES <?php  echo $t;?>">
<TR>
	<TD><INPUT TYPE="submit"value="CHECKSUM  TABLES"></TD>
</TR>
</FORM>




<TR>
	<TD></TD>
</TR>


</TABLE><BR><?php 
foot();
?>