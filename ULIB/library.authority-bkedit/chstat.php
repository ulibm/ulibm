<?php  //พ

        $sql="update bkedit_authority set $item='$val'  where id='$mid'";

        //         echo $sql;

        if (tmq( $sql))

            {

            echo "<CENTER><font face ='ms sans serif'  size ='3'>";

            echo getlang("<b>Update Successfully</b>::l::<b>Update Successfully</b>");

            echo "</font></CENTER>";

            }

        else

            {

            echo "<CENTER><font face ='ms sans serif'  size ='3'>";

            echo "<b>Error </b>.";

            echo "</font></CENTER>";


            }

?>