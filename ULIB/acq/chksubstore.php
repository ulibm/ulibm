<?php 
include("./cfg.inc.php");
html_start();
?>

<center>

สำนักพิมพ์ <b class=smaller><?php echo $store;
?></b><br>
เลือกเฉพาะประเภท
:
	<?php 
		echo "<a href=\"xls.php?pid=$pid&mode=&bystore=$store\" target=_blank>".$_s[all][name]."</a> ".number_format(tnr(tmq("select id from acqn_sub where pid='$pid' and s_store='$store'")));
		echo " : <a href=\"xls.php?pid=$pid&mode=ordering&bystore=$store\" target=_blank>".$_s[ordering][name]."</a> ".number_format(tnr(tmq("select id from acqn_sub where pid='$pid' and stat='ordering' and s_store='$store'")));
		echo " : <a href=\"xls.php?pid=$pid&mode=reject&bystore=$store\" target=_blank>".$_s[reject][name]."</a> ".number_format(tnr(tmq("select id from acqn_sub where pid='$pid' and stat='reject' and s_store='$store'")));
		echo " : <a href=\"xls.php?pid=$pid&mode=duplicate&bystore=$store\" target=_blank>".$_s[duplicate][name]."</a> ".number_format(tnr(tmq("select id from acqn_sub where pid='$pid' and stat='duplicate' and s_store='$store'")));
		echo " : <a href=\"xls.php?pid=$pid&mode=suggest&bystore=$store\" target=_blank>".$_s[suggest][name]."</a> ".number_format(tnr(tmq("select id from acqn_sub where pid='$pid' and stat='suggest' and s_store='$store'")));
		echo " : <a href=\"xls.php?pid=$pid&mode=bookrecieve&bystore=$store\" target=_blank>".$_s[bookrecieve][name]."</a> ".number_format(tnr(tmq("select id from acqn_sub where pid='$pid' and stat='bookrecieve' and s_store='$store'")));
	?><br>
<style>
body {
	background-color: #E2E2E2;
}	
	</style></center>