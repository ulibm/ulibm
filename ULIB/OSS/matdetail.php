<?php 
	;
	include ("../inc/config.inc.php");
//	include ("./inc.php");
html_start();
	include("../library.oss/inc.php");

	$s=tmq("select * from oss_req where id='$id' ");
	$s=tfa($s);
	$now=time();

	$pickupatdb=tmq_dump2("oss_pickuptype","classid","name");
	$sourcesdb=tmq_dump2("oss_sources","classid","name");
?><style>
.tdul {
	border: #cdcdcd solid 0px;
	border-bottom-width:1px;
}
</style>
<table width=1000 align=center>
<tr>
	<td>
	<center><b><!--  -->คำขอที่ <?php  echo $s[id]?></b></center>
	<table cellspacing=5 >
	<tr>
		<td class=tdul>
	<?php 
	$s[mat_info]=dspmarc($s[mat_info]);
	$s[mat_info]=str_replace("\n","</td>	</tr><tr><td class=tdul>",$s[mat_info]);
	$s[mat_info]=str_replace("Title:","Title:</td><td class=tdul>",$s[mat_info]);
	$s[mat_info]=str_replace("Author:","Author:</td><td class=tdul>",$s[mat_info]);
	$s[mat_info]=str_replace("Detail:","Detail:</td><td class=tdul>",$s[mat_info]);

	echo stripslashes($s[mat_info]);?>

</td>
	</tr>	
	<!--  -->
	<tr><td class=tdul>โน๊ต/ข้อความถึงบรรณารักษ์: </td><td class=tdul><?php  echo getlang(stripslashes($s[bknote]));
	
	if ($s[reftrans]!="") {
		echo "<i style='color:darkred'> รายการนี้ระบบสร้างขึ้นอัตโนมัติ จากการชำระแบบไม่เต็มจำนวน</i>";
	}
	
	?></td>	</tr>
	<tr><td class=tdul>	ทรัพยากรของ: </td><td class=tdul><?php  
	$tmpsource= getlang(stripslashes($sourcesdb[$s[sources]]));
if ($tmpsource=="") {
	echo getlang($s[sources]);
} else {
	echo $tmpsource;
}
?></td>	</tr>
	<tr><td class=tdul> การรับเอกสาร: </td><td class=tdul><?php  
	if ($s[servicetypeoptions]=="0") {
		echo getlang(" ส่งทางอีเมล์ ::l:: Send to my Email");
	} else {
		echo getlang(stripslashes($pickupatdb[$s[pickupat]]));
	}?></td>	</tr>
	<tr><td class=tdul>สถานะปัจจุบัน:</td><td class=tdul> <b><?php  
	echo $statusdb[$s[stat]];
	echo "</b>";

	if ($s[stat]=="waitpayment") {
		echo " (<i>".number_format($s[fee],2)."</i> บาท)";
	}
	
	?></td>	</tr>
	
	</table>
	
	</td>
</tr>
</table>

<style>
BODY {
height: 100px!important;
}
</style>
 </body>
</html>
