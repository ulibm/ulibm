<?php  // พ
    function scol()
        {
        global $tid;
        $tid=$tid + 1;
        //echo $tid;
        if ($tid % 2 == 0)
            {
            return "#f2f2f2";
            }
        else
            {
            return "#e2e2e2";
            }
        }

?>