<?php 
;
include("./inc/config.inc.php");
head();
mn_web("requestroom");
?>
<table border="0" cellpadding="0" cellspacing="0" width=780 align=center class=table_border>
<tr><td class=table_head width=30%><?php  echo getlang("ทำการจองห้อง::l::Request for room")?></td>
<td class=table_td><?php 
$s=tmq("select * from rqroom_maintb where code='$roomid' ");
$s=tmq_fetch_array($s);
echo "<b>$s[name]</b><br />";
echo  "$s[descr]";
?></td></tr>
<tr><td class=table_head width=30%><?php  echo getlang("วันที่::l::Date")?></td>
<td class=table_td><?php 
echo ymd_datestr(ymd_mkdt($dat,$mon,$yea),'date');
?></td></tr>
<tr><td class=table_head width=30%><?php  echo getlang("ช่วงเวลา::l::Time")?></td>
<td class=table_td><?php 
$s=tmq("select * from rqroom_periodinfo where code='$periodid' ");
$s=tmq_fetch_array($s);
echo "<b>$s[name]</b> $s[time]<br />";
echo  "$s[descr]";
?></td></tr>
</table>
<br />

<table width = "340" border = "1" align = center cellspacing = "0" bgcolor = 666666>
                                <TR>
                                    <TD colspan=2 class=table_head><B><?php  echo getlang("ทำรายการการจอง::l::Send request"); ?></B>&nbsp;&nbsp;</TD>
                                </TR>
                                <FORM METHOD = POST ACTION = "/<?php 
echo $dcr;?>/member/addRequestRoomction.php">
                                    <TR bgcolor = white>
                                        <TD  class=table_td><nobr>
                                            <font face = 'MS Sans Serif' size = 2><?php  echo getlang("รหัสบาร์โค้ดห้องสมุดของคุณ::l::Your barcode"); ?> &nbsp;&nbsp;</TD> <TD><INPUT TYPE = "text" NAME = "useradminidx" value="<?php  echo $_memid?>" autocomplete=off></td>
                                    </TR>
                                    <TR bgcolor = white>
                                        <TD  class=table_td>
                                          <font face = 'MS Sans Serif' size = 2><?php  echo getlang("รหัสผ่าน::l::Password"); ?> </TD> <TD><INPUT TYPE = "password" NAME = "passwordadminx" value=""></td>
                                    </TR>
									                   <TR bgcolor = white>
<input type="hidden" name="dat" value="<?php  echo $dat?>" />
<input type="hidden" name="mon" value="<?php  echo $mon?>" />
<input type="hidden" name="yea" value="<?php  echo $yea?>" />
<input type="hidden" name="periodid" value="<?php  echo $periodid?>" />
<input type="hidden" name="roomsub" value="<?php  echo $roomsub?>" />
<input type="hidden" name="roomid" value="<?php  echo $roomid?>" />
                                        <TD colspan=2 align=center>
                                            
																						<INPUT TYPE="submit" value="<?php  echo getlang(" ตกลง ::l:: Submit "); ?>">&nbsp;<INPUT TYPE="reset" value=" <?php  echo getlang("ยกเลิก::l::Cancel"); ?> " onclick="self.location='<?php  echo $dcrURL?>'"> </TD> 
																						
																						
                                    </TR>
                                </FORM>
                            </TABLE>
<?php 

foot();
?>