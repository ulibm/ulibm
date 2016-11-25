<?php 

        $sql="update bkedit set $item='$val'  where id='$mid'";

        //         echo $sql;

        if (tmq( $sql))

            {

            echo "<CENTER><font face ='ms sans serif'  size ='3'>";

            echo getlang("<b>Update Successfully</b><BR>เมื่อมีการเปลี่ยนแปลงโครงสร้างการ Index <BR>จะต้องทำการ Reindex ข้อมูลเก่าก่อน จึงจะสามารถสืบค้นจากระบบ UPAC ได้::l::<b>Update Successfully</b><BR>If Indexing changes <BR>Administrator have to Re-index Database to update searching database");

            echo "</font></CENTER>";

            }

        else

            {

            echo "<CENTER><font face ='ms sans serif'  size ='3'>";

            echo "<b>Error </b>.";

            echo "</font></CENTER>";


            }

?>