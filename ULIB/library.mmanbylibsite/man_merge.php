<?php 
    ;
	include ("../inc/config.inc.php");
	if ($ID=="[EMPTY]") {
		 $ID="";
	}
if ($issave=="yes") {
	tmq("update member set 
	libsite='$targetlibsite'


	where libsite='$ID'
	");
	redir("media_type.php");
	die;
}
	head();
	include("_REQPERM.php");
	mn_lib();
?><BR><BR>

<CENTER>
<B><?php  echo getlang("กรุณาตรวจสอบให้แน่ใจก่อนทำการตั้งค่า เพราะการตั้งค่าไม่สามารถยกเลิกได้::l::Please re-check this operation, this operation cannot be undone."); ?>
</B><BR><BR><?php  echo getlang("กรุณาเลือกสาขาปลายทาง::l::Please choose destination campus"); ?> <HR width=770><BR>
<TABLE width=770 align=center>
<FORM METHOD=POST ACTION="man_merge.php">
<INPUT TYPE="hidden" name='ID' value='<?php  echo $ID?>'>
<INPUT TYPE="hidden" name='issave' value='yes'>
                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "50%" valign = "middle">
                                                <font face = "MS Sans Serif" size = "2"><?php  echo getlang("กรุณาเลือกสาขาที่จะนำสมาชิก"."ที่เลือกไว้ ไปรวมด้วย::l::Destination campus"); ?><br> </font></td>
                                            <td width = "50%">
                                                <font face = "MS Sans Serif" size = "2">
                                                <select name = targetlibsite><?php 
													$s=tmq("select * from library_site where code<>'$ID' order by name");
                                                        while ($r=tmq_fetch_array($s)) {
															echo "<option value='$r[code]'>".getlang($r[name]);
															echo " (". number_format(tmq_num_rows(tmq("select * from member where libsite='$r[code]' "))) . ")";

														}
                                                    ?></select>
</TD>
</TR>
<TR>
	<TD align=center colspan=2><INPUT TYPE="submit" value="  Update "></TD>
</TR>

</FORM></TABLE>
<BR><BR><BR>
</CENTER>
<?php 
	foot();
?>