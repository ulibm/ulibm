<?php 
    ;
	include ("../inc/config.inc.php");
if ($issave=="yes") {
	tmq("update member set 
	room='$targetroom'


	where room='$ID'
	",true);
	redir("media_type.php");
	die;
}
	head();
	include("_REQPERM.php");
	mn_lib();
?><BR><BR>

<CENTER>
<B><?php  echo getlang("กรุณาตรวจสอบให้แน่ใจก่อนทำการตั้งค่า เพราะการตั้งค่าไม่สามารถยกเลิกได้::l::Please re-check this operation, this operation cannot be undone."); ?>
</B><BR><BR><?php  echo getlang("กรุณาเลือก$_ROOMWORDปลายทาง::l::Please choose destination $_ROOMWORD"); ?> <HR width=770><BR>
<TABLE width=770 align=center>
<FORM METHOD=POST ACTION="man_merge.php">
<INPUT TYPE="hidden" name='ID' value='<?php  echo $ID?>'>
<INPUT TYPE="hidden" name='issave' value='yes'>
                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "50%" valign = "middle">
                                                <font face = "MS Sans Serif" size = "2"><?php  echo getlang("กรุณาเลือกห้องที่จะนำ$_ROOMWORD"."ที่เลือกไว้ ไปรวมด้วย::l::Destination $_ROOMWORD"); ?><br> </font></td>
                                            <td width = "50%">
                                                <font face = "MS Sans Serif" size = "2">
                                                
                                                <select name="targetroom"><?php 
													$s=tmq("select * from room where id<>$ID order by pid,name");
                                                        while ($r=tmq_fetch_array($s)) {
															echo "<option value='$r[id]'>".get_room_name($r[id]);
															echo " (". number_format(tmq_num_rows(tmq("select * from member where room='$r[id]' "))) . ")";

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