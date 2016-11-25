<?php 
    ;
			include("inc/config.inc.php");
head();
?><BR><BR><center>
<table width = "500" border = "0" align = center cellspacing = "0" ><TR><TD ><?php 
echo stripslashes(getval("_SETTING","holdrequestannouce"));
?>
</td></tr></table><BR><BR></center><table width = "340" border = "1" align = center cellspacing = "0" bgcolor = 666666>
                                <TR>
                                    <TD colspan=2>
                                        <font face = 'MS Sans Serif' size = 2 color = fffffff><B><?php  echo getlang("ทำรายการการจอง::l::Send request"); ?></B>&nbsp;&nbsp;</TD>
                                </TR>
                                <FORM METHOD = POST ACTION = "/<?php 
echo $dcr;
?>/member/addRequestItemAction.php">
                                    <TR bgcolor = white>
                                        <TD>
                                            <font face = 'MS Sans Serif' size = 2><?php  echo getlang("บาร์โค้ดหนังสือ::l::Item barcode"); ?>&nbsp;&nbsp;</TD> <TD> <INPUT TYPE = "hidden" NAME = "media_id" value="<?php  echo $ID;?>"><B><?php  echo $ID;?></B></td>
                                    </TR>
                                    <TR bgcolor = white>
                                        <TD><nobr>
                                            <font face = 'MS Sans Serif' size = 2><?php  echo getlang("รหัสบาร์โค้ดห้องสมุดของคุณ::l::Your barcode"); ?> &nbsp;&nbsp;</TD> <TD><INPUT TYPE = "text" NAME = "useradminidx" value="<?php  echo $_memid?>"></td>
                                    </TR>
                                    <TR bgcolor = white>
                                        <TD>
                                            <font face = 'MS Sans Serif' size = 2><?php  echo getlang("รหัสผ่าน::l::Password"); ?> </TD> <TD><INPUT TYPE = "password" NAME = "passwordadminx" value=""></td>
                                    </TR>
									                                    <TR bgcolor = white>
                                        <TD>
                                            <font face = 'MS Sans Serif' size = 2>&nbsp;<INPUT TYPE="submit" value="<?php  echo getlang(" ตกลง ::l:: Submit "); ?>">&nbsp;<INPUT TYPE="reset" value=" <?php  echo getlang("ยกเลิก::l::Cancel"); ?> " onclick="history.go(-1)"> </TD> <TD></td>
                                    </TR>
                                </FORM>
                            </TABLE><BR><?php 
							foot();
							?>