<?php 
include("./cfg.inc.php");
html_start();
$origbudget=$budget;
	if ($budget=="[blank]") {
		$budget="";
	}

?>

<center>

งบประมาณ <b class=smaller><?php echo $budget;
?></b><br>
เลือกเฉพาะประเภท
:
	<?php 
		echo "<a class=smaller href=\"xls.php?pid=$pid&mode=&budget=$origbudget\" target=_blank>".$_s[all][name]."</a> ".number_format(tnr(tmq("select id from acqn_sub where pid='$pid' and budget='$budget'")));
		echo " : <a  class=smaller href=\"xls.php?pid=$pid&mode=ordering&budget=$origbudget\" target=_blank>".$_s[ordering][name]."</a> ".number_format(tnr(tmq("select id from acqn_sub where pid='$pid' and stat='ordering' and budget='$budget'")));
		echo " : <a  class=smaller href=\"xls.php?pid=$pid&mode=reject&budget=$origbudget\" target=_blank>".$_s[reject][name]."</a> ".number_format(tnr(tmq("select id from acqn_sub where pid='$pid' and stat='reject' and budget='$budget'")));
		echo " : <a  class=smaller href=\"xls.php?pid=$pid&mode=duplicate&budget=$origbudget\" target=_blank>".$_s[duplicate][name]."</a> ".number_format(tnr(tmq("select id from acqn_sub where pid='$pid' and stat='duplicate' and budget='$budget'")));
		echo " : <a  class=smaller href=\"xls.php?pid=$pid&mode=suggest&budget=$origbudget\" target=_blank>".$_s[suggest][name]."</a> ".number_format(tnr(tmq("select id from acqn_sub where pid='$pid' and stat='suggest' and budget='$budget'")));
		echo " : <a  class=smaller href=\"xls.php?pid=$pid&mode=bookrecieve&budget=$origbudget\" target=_blank>".$_s[bookrecieve][name]."</a> ".number_format(tnr(tmq("select id from acqn_sub where pid='$pid' and stat='bookrecieve' and budget='$budget'")));
	?><br>
<style>
body {
	background-color: #E2E2E2;
}	
	</style></center>