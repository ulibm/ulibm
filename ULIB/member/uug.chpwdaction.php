<?php 
    ;
		        include("../inc/config.inc.php");
	if ($_ISULIBMASTER!="yes") {
		get404();
		die;
	}
    if ($_memid == "")
        {
        		form_member_login();
        echo "<center><font face ='ms sans serif' size =2 color = red>";
        echo "Login หรือ Password ไม่ถูกต้อง โปรดตรวจสอบอีกครั้ง";
        echo "</font></center>";
        }
    else
        {
 			member_log($_memid,"uug-chinfo");



        $sql="update ulib_clientlogins set  email='$eml', passwd='$pwd' , tel='$tel' 
				 , address='$address'  ,
				 name='$name' 
				where loginid='".substr($_memid,4)."'";
        //echo $sql;
        if (tmq( $sql))
            {
            echo "<font face ='ms sans serif'  size ='3'>";
            echo "<b>Update Successfully</b>";
            echo "</font>";
			redir($dcrURL,1);
			}
        else
            {
            echo "<font face ='ms sans serif'  size ='3'>";
            echo "<b>Error </b> <br>Please Back  to check data.";
            echo "</font>";
            echo "<form><font face='ms sans serif' size=-2><input type=button value=' < Back' onclick=history.back()></form>";
            }
        }
?>