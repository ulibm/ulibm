<?php  //พ
    ;
	include ("../inc/config.inc.php");
	include("_REQPERM.php");
mn_lib();

        $sql="update bkedit_authority set name='$name' ,fid='$fid',example='$example',descr='$descr',ordr='$ordr',defindi1='$defindi1',defindi2='$defindi2'

		where id='$mid'";

        //         echo $sql;

        if (tmq( $sql))

            {

            echo "<font face ='ms sans serif'  size ='3'>";

            echo "<b>Update Successfully</b>";

            echo "</font>";

            echo "<meta name='Generator' content='EditPlus'>";

            echo "<META HTTP-EQUIV='Content-Type' content='text/html; charset=unknown'>";

            echo "<META HTTP-EQUIV='REFRESH' CONTENT='0; 

URL=media_type.php?sid=$sid'>";

            }

        else

            {

            echo "<font face ='ms sans serif'  size ='3'>";

            echo "<b>Error </b> <br>Please Back  to check data.";

            echo "</font>";

            echo "<form><font face='ms sans serif' size=-2><input type=button value=' < Back' onclick=history.back()></form>";

            }

        
				?>