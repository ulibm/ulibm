<?php 
    ;
	include ("../inc/config.inc.php");
	loginchk_lib();// พ

        $sql="update acq_media 
	 set
setbudget='$setbudget',
d_titl='$d_titl',
d_auth='$d_auth',
d_yea='$d_yea',
d_publ='$d_publ',
d_isbn='$d_isbn',
d_edition='$d_edition',
d_imprint='$d_imprint',
d_mdtype='$d_mdtype',
amount='$amount',
price='$Fprice',
note='$note'
		where id='$mid'";

        //         echo $sql;

		tmq($sql);
redir("media_type.php");

			?>