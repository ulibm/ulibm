<?php 
session_start();
include("./cfg.inc.php");
//print_r($_COOKIE);
if ($issave=="yes") {
	$s="update acqn_sub set s_subj='$newsubj' where s_subj='$oldsubj' and pid='104' ";
	tmq($s);
	//echo $s;
	echo "<hr>เสร็จแระ<hr>";
}
html_start();
?><form method="post" action="tmp.php">
	
		เลือกสำนักพิมพ์ 
	<?php 
	//$ps=tmq("select  distinct s_subj, count(id) as cc from acqn_sub where pid='4'  group by s_subj order by s_subj");
	$ps=tmq("select  distinct s_subj, count(id) as cc from acqn_sub where pid='104'  group by s_subj order by s_subj");
	?><select name="oldsubj" ID=oldsubj >
	<option value="">ไม่กำหนด
	<?php 
	while ($psr=tfa($ps)) {
	?>
		<option value="<?php  echo $psr[s_subj]?>" rel="yes"><?php  echo $psr[s_subj]?> (<?php  echo $psr[cc];?>)
	<?php }?>
	</select> 
	
	เปลี่ยนเป็น
	<?php 
$slist="มนุษยศาสตร์และสังคมศาสตร์,ศึกษาศาสตร์,การบัญชีและการจัดการ,ศิลปกรรมศาสตร์,การท่องเที่ยวและการโรงแรม,วิทยาลัยการเมืองการปกครอง,วิทยาดุริยางคศิลป์,วัฒนธรรมศาสตร์,วิทยาศาสตร์,เทคโนโลยี,สถาปัตยกรรมศาสตร์,สิ่งแวดล้อมและทรัพยากรศาสตร์,วิทยาการสารสนเทศ,สถาบันวิจับวลัยรุกขเวช,พยาบาลศาสตร์,แพทยศาสตร์,สาธารณสุขศาสตร์,เภสัชศาสตร์,สัตวแพทยศาสตร์,โรงเรียนสาธิต มมส.,สำนักวิทยบริการ,คณะวิศวกรรมศาสตร์,หน่วยงานอื่นๆ,";
$slist=explode(",",$slist);
@reset($slist);
?><select name="newsubj"><?php 
while (list($k,$v)=each($slist)) {
	$v=trim($v);
	$sl="";
	if ($v==$subjchk) {
		$sl=" selected checked ";
	}
	echo "<option value='$v' $sl>$v";
}

?></select>
<input type="hidden" name="issave" value="yes">
<input type="submit" value="ลงมือ">
</form>
<?php 
foot();
?>