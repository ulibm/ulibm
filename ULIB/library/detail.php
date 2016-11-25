<?php 
    ;
    ini_set("error_report", "E_ALL");
    $useradminid2=$id;
                                include_once ("../inc/config.inc.php");
								head();
								mn_lib();
                                connDB();
                                $sql="select * from member where UserAdminID='$useradminid2' ";
                                $result=tmq($sql);
                                $nnnn=tmq_num_rows($result);
                                if ($nnnn == 0)
                                    {
                                    echo "ไม่พบรหัสนิสิตนี้! กรุณาระบุใหม่ ";
                                    die();
                                    }


member_showinfo($useradminid2);
member_showhold($useradminid2);
member_showrequest($useradminid2);
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