<?php             include ("../inc/config.inc.php");
				include("./_REQPERM.php");
					loginchk_lib();
html_start();// พ
$s=get_member_name($bc);
echo "[$bc]=" ;
echo $s;
?>