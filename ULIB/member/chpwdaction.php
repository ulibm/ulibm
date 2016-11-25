<?php 
    ;
		        include("../inc/config.inc.php");
    if ($_memid == "")
        {
        		form_member_login();
        echo "<center><font face ='ms sans serif' size =2 color = red>";
        echo "Login หรือ Password ไม่ถูกต้อง โปรดตรวจสอบอีกครั้ง";
        echo "</font></center>";
        }
    else
        {
        // ตรวจสอบว่าเป็น Root Admin หรือไม่ 
        //เขียนข้อมูลลงฐานข้อมูล 

 			member_log($_memid,"chinfo");


        $sql="update member set  email='$eml', Password='$pwd' , tel='$tel' 
				 , cust01='$cust01'  ,
				 cust02='$cust02'  ,
				 cust03='$cust03'  ,
				 cust04='$cust04'  ,
				 cust05='$cust05' ,
				 publishbookinfo='$publishbookinfo'
				where UserAdminID='$_memid'";
				tmq("update webpage_memfavbook set ispublish='$publishbookinfo' where memid='$_memid' ");
        //echo $sql;
        if (tmq( $sql))
            {
            echo "<font face ='ms sans serif'  size ='3'>";
            echo "<b>Update Successfully</b>";
            echo "</font>";
            echo "<meta name='Generator' content='EditPlus'>";
            echo "<META HTTP-EQUIV='Content-Type' content='text/html; charset=unknown'>";
            echo "<META HTTP-EQUIV='REFRESH' CONTENT='1; URL=mainadmin.php?sid=$sid'>";
            }
        else
            {
            echo "<font face ='ms sans serif'  size ='3'>";
            echo "<b>Error </b> <br>Please Back  to check data.";
            echo "</font>";
            echo "<form><font face='ms sans serif' size=-2><input type=button value=' < Back' onclick=history.back()></form>";
            }
        
        //} 
        //ปิดตรวจสอบ Root Admin 
        }
    // จบการตวจสอบ Root Admin 
?>
