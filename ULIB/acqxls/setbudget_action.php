<?php 
    ;
include("./cfg.inc.php");
include("./head.php");
if ($issave=="yes") {
	tmq("update acqn_sub set 
	budget='$targetroom'


	where pid='$ID'
	");
	redir("index.php");
	die;
}
?><BR><BR>

<CENTER>
<B><?php  echo getlang("กรุณาตรวจสอบให้แน่ใจก่อนทำการตั้งค่า เพราะการตั้งค่าไม่สามารถยกเลิกได้::l::Please re-check this operation, this operation cannot be undone."); ?>
</B><BR><BR><?php  echo getlang("กรุณาเลือกงบประมาณ::l::Please choose budget"); ?> <HR width=770><BR>
<TABLE width=770 align=center>
<FORM METHOD=POST ACTION="setbudget_action.php">
<INPUT TYPE="hidden" name='ID' value='<?php  echo $ID?>'>
<INPUT TYPE="hidden" name='issave' value='yes'>
                                        <tr bgcolor = "#f3f3f3">
                                            <td width = "50%" valign = "middle">
                                                <font face = "MS Sans Serif" size = "2"><?php  echo getlang("กรุณาเลือกงบประมาณ::l::Please choose budget"); ?><br> </font></td>
                                            <td width = "50%">
                                                <font face = "MS Sans Serif" size = "2">
                                                <select name = targetroom><?php 
													$s=tmq("select * from acqn_budget where 1 order by name");
                                                        while ($r=tmq_fetch_array($s)) {
				$remains=tmq("select sum(pricenet) as cc from acqn_sub where budget='$r[code]' ");
				$remains=tfa($remains);
				$remains=$remains[cc];
				$remains=$r[amnt]-$remains;
				echo "<OPTION VALUE='".$r[code]."' ";
				if ($remains<0) {
						echo " style='background-color: #ffe7e6; font-weight:bold;' ";
				}
				echo ">".getlang($r[name]); 
				echo " (".number_format($remains)."/".number_format($r[amnt]).")";
				
				
														}
                                                    ?></select>
</TD>
</TR>
<TR>
	<TD align=center colspan=2><INPUT TYPE="submit" value="  Update  "></TD>
</TR>

</FORM></TABLE>
<BR><BR><BR>
</CENTER>
<?php 
	foot();
?>