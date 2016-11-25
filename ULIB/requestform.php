<?php 
    ;
			include("inc/config.inc.php");
head();
?><BR><table width = "340" border = "1" align = center cellspacing = "0" class=table_border>
                                <TR>
                                    <TD colspan=2  class=table_head>
                                       <?php  echo getlang("ทำการขอยืม::l::Send request"); ?></TD>
                                </TR>
                                <FORM METHOD = POST ACTION = "/<?php 
echo $dcr;
?>/member/addRequestIListAction.php">
                                    <TR bgcolor = white>
                                        <TD  class=table_head>
                                            <font face = 'MS Sans Serif' size = 2><?php  echo getlang("บาร์โค้ดวัสดุสารสนเทศ::l::Item barcode"); ?>&nbsp;&nbsp;</TD> <TD> <INPUT TYPE = "hidden" NAME = "media_id" value="<?php  echo $ID;?>"><B><?php  echo $ID;?></B></td>
                                    </TR>
                                    <TR bgcolor = white>
                                        <TD  class=table_head><nobr>
                                            <font face = 'MS Sans Serif' size = 2><?php  echo getlang("รหัสบาร์โค้ดห้องสมุดของคุณ::l::Your barcode"); ?> &nbsp;&nbsp;</TD> <TD><INPUT TYPE = "text" NAME = "useradminidx" value=""></td>
                                    </TR>
                                    <TR bgcolor = white>
                                        <TD class=table_head>
                                            <font face = 'MS Sans Serif' size = 2><?php  echo getlang("รหัสผ่าน::l::Password"); ?> </TD>
											<TD><INPUT TYPE = "password" NAME = "passwordadminx" value=""></td>
                                    </TR>
									                                    <TR bgcolor = white>
                                        <TD class=table_td align=center colspan=2>
                                            <font face = 'MS Sans Serif' size = 2>&nbsp;<INPUT TYPE="submit" value="<?php  echo getlang(" ตกลง ::l:: Submit "); ?>">&nbsp;<INPUT TYPE="reset" value=" <?php  echo getlang("ยกเลิก::l::Cancel"); ?> " onclick="history.go(-1)"> </TD> <TD></td>
                                    </TR>
                                </FORM>
                            </TABLE><BR><?php 
							foot();
							?>