<?php  //พ
    ;
	include ("../inc/config.inc.php");
	include("_REQPERM.php");
	$tmp=mn_lib();
	pagesection($tmp);
	$val=stripslashes($val);
     $val=stripslashes($val);
     $val=addslashes($val);

        $sql="update bkdsp set name='$name', ordr='$ordr', val='$val' , replacewith='$replacewith',
	hidefid='$hidefid',hidestr='$hidestr' ,trimthis='$trimthis' ,linkrow='$linkrow',linksubf='$linksubf',boundwith='$boundwith',formatisn='$formatisn' where id='$mid'";
        //         echo $sql;
        if (tmq( $sql))
            {
            echo "<font face ='ms sans serif'  size ='3'>";
            echo "<b>Update Successfully</b>";
            echo "</font>";
            echo "<meta name='Generator' content='EditPlus'>";
            echo "<META HTTP-EQUIV='Content-Type' content='text/html; charset=unknown'>";
           echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=media_type.php?sid=$sid'>";
            }
        else
            {
            echo "<font face ='ms sans serif'  size ='3'>";
            echo "<b>Error </b> <br>Please Back  to check data.";
            echo "</font>";
            echo "<form><font face='ms sans serif' size=-2><input type=button value=' < Back' onclick=history.back()></form>";
            }
        
        //} 
?>