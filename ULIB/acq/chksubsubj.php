<?php 
include("./cfg.inc.php");
html_start();
?>

<center>

คณะ <b class=smaller><?php echo $subj;
?></b><br>
เลือกเฉพาะประเภท
:
	<?php 
		echo "<a href=\"xls.php?pid=$pid&mode=&subj=$subj\" target=_blank>".$_s[all][name]."</a> ".number_format(tnr(tmq("select id from acqn_sub where pid='$pid' and s_subj='$subj'")));
		echo " : <a href=\"xls.php?pid=$pid&mode=ordering&subj=$subj\" target=_blank>".$_s[ordering][name]."</a> ".number_format(tnr(tmq("select id from acqn_sub where pid='$pid' and stat='ordering' and s_subj='$subj'")));
		echo " : <a href=\"xls.php?pid=$pid&mode=reject&subj=$subj\" target=_blank>".$_s[reject][name]."</a> ".number_format(tnr(tmq("select id from acqn_sub where pid='$pid' and stat='reject' and s_subj='$subj'")));
		echo " : <a href=\"xls.php?pid=$pid&mode=duplicate&subj=$subj\" target=_blank>".$_s[duplicate][name]."</a> ".number_format(tnr(tmq("select id from acqn_sub where pid='$pid' and stat='duplicate' and s_subj='$subj'")));
		echo " : <a href=\"xls.php?pid=$pid&mode=suggest&subj=$subj\" target=_blank>".$_s[suggest][name]."</a> ".number_format(tnr(tmq("select id from acqn_sub where pid='$pid' and stat='suggest' and s_subj='$subj'")));
		echo " : <a href=\"xls.php?pid=$pid&mode=bookrecieve&subj=$subj\" target=_blank>".$_s[bookrecieve][name]."</a> ".number_format(tnr(tmq("select id from acqn_sub where pid='$pid' and stat='bookrecieve' and s_subj='$subj'")));
	?><style>
body {
	background-color: #E2E2E2;
}	
	</style>
	<form method="post" target=_blank action="xls.php" style="margin: 0px  0px  0px  0px; display:inline;">
<input type="hidden" name="pid" value="<?php  echo $pid; ?>">
<input type="hidden" name="subj" value="<?php  echo $subj; ?>"><br>
	เลือกตามสำนักพิมพ์ 
	<?php 
	$ps=tmq("select SQL_CACHE distinct s_store, count(id) as cc from acqn_sub where pid='$pid' and s_subj='$subj' group by s_store order by s_store");
	?><select name="bystore" ID=bystore onchange="selectstorechange(this);">
	<option value="">ไม่กำหนด
	<?php 
	while ($psr=tfa($ps)) {
	?>
		<option value="<?php  echo $psr[s_store]?>" rel="yes"><?php  echo $psr[s_store]?> (<?php  echo $psr[cc];?>)
	<?php }?>
	</select> สถานะ 
	<select name="mode">
	<option value="" >ทุกสถานะ
	<option value="suggest" style="background-color:<?php  echo $_s[suggest][bg]?>;"><?php  echo $_s[suggest][name]?>
	<option value="ordering" style="background-color:<?php  echo $_s[ordering][bg]?>;" ><?php  echo $_s[ordering][name]?>
	<option value="reject" style="background-color:<?php  echo $_s[reject][bg]?>;" ><?php  echo $_s[reject][name]?>
	<option value="duplicate" style="background-color:<?php  echo $_s[duplicate][bg]?>;"><?php  echo $_s[duplicate][name]?>
	<option value="bookrecieve" style="background-color:<?php  echo $_s[bookrecieve][bg]?>;"><?php  echo $_s[bookrecieve][name]?>
</select><br>
เฉพาะที่กำหนดสถานะตั้งแต่วันที่ 
<?php  
$dateafter=tmq("SELECT distinct FROM_UNIXTIME(dt, '%d/%m/%Y') as ddd ,count(distinct subid) as ccc from acqn_sub_clog 
	where  subid in (select id from acqn_sub where pid='$pid' and s_subj='$subj')
	group by FROM_UNIXTIME(dt, '%d/%m/%Y')  ");
?>
<select name="dateafter"><option value="" >ไม่กำหนด
<?php 
while ($dateafterr=tfa($dateafter)) {
	$dateafteri=explode("/",$dateafterr[ddd]);

	echo "<option value='".mktime(0, 0, 0, $dateafteri[1], $dateafteri[0], $dateafteri[2])."' >".ymd_datestr(mktime(0, 0, 0, $dateafteri[1], $dateafteri[0], $dateafteri[2]),'date')." (".$dateafterr[ccc].")";
	//print_r($dateafteri);
	//echo ymd_datestr(mktime(0, 0, 0, $dateafteri[1], $dateafteri[0], $dateafteri[2]));
}
?>
</select>
	<input type="submit" name='submittype' value='ดูตัวอย่าง'>
	<input type="submit" name='submittype' value='ส่งออก'>
	</form> 
	</center>