<?php 
;
	include_once ("../inc/config.inc.php");
$useradminid2=$id;
	head();
	include("_REQPERM.php");
	mn_lib();

	t("select","*");
	t("from","member");
	t("where","UserAdminID","=","$useradminid2");
	$result=t("e");
	$nnnn=tnr($result);
	if ($nnnn == 0)
		{
		html_dialog(getlang("ผิดพลาด::l::Error"),getlang("ไม่พบรหัสสมาชิกนี้ กรุณาระบุใหม::l::Member's ID not found , please try again่"));
	 	$s=tmq("select * from member_bin where UserAdminID='$useradminid2' ",false);
		if (loginchk_lib('check')==true && tnr($s)!=0) {
		    pagesection(getlang("รายการอดีตสมาชิกที่มีรหัสบาร์โค้ดตรงกัน::l::Deleted member with same barcode"));
         while ($r=tfa($s)) {
            memberbin_showlonginfo($useradminid2,$r[UserAdminName]);
            echo "<BR>";
         }
		
		}
		foot();
		die();
		}


member_showlonginfo($useradminid2);
member_showhold($useradminid2);
member_showrequest($useradminid2);
member_showrequestlist($useradminid2);
member_showfine($useradminid2);

                                echo "<br>";
?>
                        </TD>
                    </TR>
                </TABLE>
                </font>
                </font>
                </td>
                </tr>
                </table>

<?php foot();?>