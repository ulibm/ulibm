<?php  
    ;
	include ("../inc/config.inc.php");
	loginchk_lib();

    // คำสั่งบันทึกลงฐานข้อมูล

	$refcode=rand(10000,99999);
     

     $sql ="insert into acq_media 
	 set
setbudget='$setbudget',
d_titl='$d_titl',
d_auth='$d_auth',
refcode='$refcode',
d_yea='$d_yea',
d_publ='$d_publ',
d_isbn='$d_isbn',
d_edition='$d_edition',
d_imprint='$d_imprint',
d_mdtype='$d_mdtype',
amount='$amount',
price='$Fprice',
note='$note'
	 ";

tmq($sql);
redir("media_type.php");
?>