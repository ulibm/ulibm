<?php 
    ;
	include("../inc/config.inc.php");
	if ($_memid!="") {
	  redir($dcrURL."member/mainadmin.php");
	  die;
	}

	head();
	mn_web("member");
?>
            <table width = "780" align=center border = "0" cellspacing = "0" cellpadding = "0">
                <tr>
                    <td>
				<?php pagesection(getlang("กรุณาใส่รหัสสมาชิกและรหัสผ่าน::l::Please enter your barcode and password"));?><BR>
                        <table width = "100%" border = "0" cellspacing = "0" cellpadding = "0">
                            <tr>
                                <td width = "112">
                                    <iasdmg src = "/<?php echo "$dcr"; ?>/images/index_14.jpg" width = "112" height = "140"></td>
                                <td width = "535">
    <?php 
form_member_login();
?>
                                </td>
                                <td width = "123">
                                    &nbsp;</td>
                            </tr>
                        </table><BR><BR><CENTER><A HREF="../index.php"><?php  echo getlang("กลับ::l::Back"); ?></A></CENTER>
                    </td>
                </tr>
            </table><?php  foot();?>