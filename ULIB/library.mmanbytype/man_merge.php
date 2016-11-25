<?php 
    ;
	include ("../inc/config.inc.php");
	if ($ID=="[EMPTY]") {
		 $ID="";
	}
if ($issave=="yes") {
	tmq("update member set 
	type='$targetlibsite'


	where type='$ID'
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
</B><BR><BR><?php  echo getlang("กรุณาเลือกประเภทสมาชิกปลายทาง::l::Please choose destination Type"); ?> <HR width=770><BR>
<TABLE width=770 align=center>
<FORM METHOD=POST ACTION="man_merge.php">
<INPUT TYPE="hidden" name='ID' value='<?php  echo $ID?>'>
<INPUT TYPE="hidden" name='issave' value='yes'>
                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "50%" valign = "middle">
                                                <font face = "MS Sans Serif" size = "2"><?php  echo getlang("กรุณาเลือกประเภทสมาชิกที่จะนำสมาชิก"."ที่เลือกไว้ ไปรวมด้วย::l::Destination Type"); ?><br> </font></td>
                                            <td width = "50%">
                                                <font face = "MS Sans Serif" size = "2">
                                                <select name = targetlibsite><?php 
													$s=tmq("select * from member_type where type<>'$ID' order by descr");
                                                        while ($r=tmq_fetch_array($s)) {
															echo "<option value='$r[type]'>".getlang($r[descr]);
															echo " (". number_format(tmq_num_rows(tmq("select * from member where type='$r[type]' "))) . ")";

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