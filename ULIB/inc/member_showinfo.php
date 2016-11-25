<?php 
function member_showinfo($id) {
	global $_TBWIDTH;
                                $sql2="select * from member where UserAdminID='$id'";
                                //echo ($sql2);
                                $result2=tmq($sql2);
                                $row=tmq_fetch_array($result2);
                                $nnnn=tmq_num_rows($result2);
                                if ($nnnn == 0)
                                    {
                                    echo getlang("ไม่พบรหัสนิสิตนี้! กรุณาระบุใหม่ ::l::Barcode id not found!");
                                    die();
                                    }
                                $libname=$row2[UserAdminName];
                                echo "<TABLE width=780 align=center> <TR valign=top>	 ";
                                echo "	<TD width=''>";
                                if (substr($SCRIPT_NAME, -10) != "detail.php")
                                    {
                                    echo "<table border=0 cellspacing=0 width='$_TBWIDTH' 
align='center' bordercolor=#666666 cellpadding=1 bgcolor=f2f2f2 ><tr><td  width=50%><B> 
  ".getlang("บาร์โค้ด::l::Barcode")." :  $id &nbsp; ".getlang("ชื่อ::l::Name")." : <a href='../library.member/editMedia.php?ID=$id' target=_blank>$row[UserAdminName]</a></b> &nbsp;&nbsp;(".get_libsite_name($row[libsite]).")</td></tr></table>";
                                    }
                                echo "</td><tr>";
                                echo "</table>";
}
?>