<?php 
;
     include("../inc/config.inc.php");
	 head();
	 include("_REQPERM.php");
	 mn_lib();

	pagesection(getlang("รายงานการรับชำระค่าปรับ แยกตามสาขาห้องสมุด::l::Fine reports, group by campus"));

include("local_dispfinebylib.php");
include("local_fineform.php");

if ($deletefinedone!="") {
	$onemonth=time()-(60*60*24*30);
	$s="delete from finedone where ". sql_gotallliblimit_bylibmember($deletefinedone,"lib") .
		" and dt<$onemonth";
	tmq($s);
	//echo ymd_datestr(1216800069);
	//echo "<BR>";
	//echo ymd_datestr($onemonth);
}

	local_dispfinebylib("LISTALLLIB","สถิติรวมทุกสาขาห้องสมุด::l::Overview all campus",$Fdat,$Fmon,$Fyea);
	$s=tmq("select * from library_site order by name");
	while ($r=tmq_fetch_array($s)) {
		local_dispfinebylib($r[code],$r[name],$Fdat,$Fmon,$Fyea);

	}

	 ?>
<BR>

<?php 
foot();
?>