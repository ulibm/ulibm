<?php 
session_start();
include("../cfg.inc.php");
//print_r($_COOKIE);
if ($issave=="yes") {
	$s_storec = $s_store;
	$s_subjc = $s_subj;
	setcookie('s_storec',$s_storec,time() + (86400 * 7)); // 86400 = 1 day
	setcookie('s_subjc',$s_subjc,time() + (86400 * 7)); // 86400 = 1 day

	$code=date("Y-m");
	$c=tmq("select * from acqn where suggestid='$code' ",false);
	//echo tnr($c); 
	if (tnr($c)!=1) {
		tmq("insert into acqn set suggestid='$code', name='คำแนะนำสั่งซื้อ $code',showtovote='no' ",false);
		$c=tmq("select * from acqn where suggestid='$code' ");
	}
	$c=tfa($c);

$price=str_replace(",","",$price);
$price=str_replace(" ","",$price);
$price=trim($price);
//echo $ffdat[price];die;
$dis=$pricedis;
//echo floor($ffdat[pricenet])."-$dis<br>";
$dis2=($pricedis/100);
//echo ($ffdat[pricedis]/100)."=$dis2<br>";
$pricedis=$price*$dis2;
//echo "$ffdat[price]*$dis2=$pricedis<br>";
$pricenet=$price-$pricedis;
//echo "net=$pricenet<br>";
//copy
$copy=floor($copy);
if ($copy==0) {
	?><script type="text/javascript">
	<!--
		alert("ไม่อนุญาต : จำนวนสำเนา (copy) ต้องไม่เป็น 0");
	//-->
	</script><a href="suggest.php">back</a><?php 
	$ffe_issave="";
	die;
}
$finalpricenet=$pricenet*$copy;
//echo "copy $pricenet*$copy=$finalpricenet<br>";
$pricenet=$finalpricenet;


	tmq("insert into acqn_sub set
	pid=$c[id],
	titl='".addslashes($titl)."',
	auth='".addslashes($auth)."',
	isn='".addslashes($isn)."',
	copy='".addslashes($copy)."',
	price='".addslashes($price)."',
	pricedis='".addslashes($pricedis)."',
	pricedis_percent='".addslashes($_POST[pricedis])."',
	pricenet='".addslashes($pricenet)."',
	yea='".addslashes($yea)."',
	pub='".addslashes($pub)."',
	s_name='".addslashes($s_name)."',
	s_email='".addslashes($s_email)."',
	s_dt='".time()."',
	s_tel='".addslashes($s_tel)."',
	s_stat='".addslashes($s_stat)."',
	s_subj='".addslashes($s_subj)."',
	stat='suggest',
	s_store='".addslashes($s_store)."'
	");

	?><script type="text/javascript">
	<!--
		alert("บันทึกคำแนะนำไว้ในฐานข้อมูลเรียบร้อยแล้ว");
	//-->
	</script><?php 
}
html_start();

?><br><script type="text/javascript">
<!--
	
function chktitle() {
	titl=getobj("titl");
	auth=getobj("auth");
	isn=getobj("isn");
	//alert(tmp.value);
	ifr=getobj("mainif");
	ifr.src="chkinfo.php?titl="+titl.value+"&isn="+isn.value+"&auth="+auth.value;
}
//-->
</script>
<table align=center width=800>
<tr>
	<td><center><b style='font-size: 14px;'>แบบฟอร์มแนะนำสั่งซื้อ / Book Order Request </b></center><br>
สำนักวิทยบริการ มหาวิทยาลัยมหาสารคาม ขอสงวนสิทธิ์การให้บริการแนะนำสั่งซื้อหนังสือนี้สำหรับอาจารย์, นิสิต/นักเรียนโรงเรียนสาธิตฯ และบุคลากรของมหาวิทยาลัยมหาสารคามเท่านั้น หากท่านประสงค์แนะนำสั่งซื้อหนังสือเข้าห้องสมุดกรุณากรอกรายละเอียดหนังสือที่ต้องการลงในแบบฟอร์มออนไลน์นี้ หรือหากประสงค์ขอข้อมูลเพิ่มเติมกรุณาติดต่อฝ่ายพัฒนาทรัพยากรฯ e-mai: phakanuch@msu.ac.th, nuntanit77@gmail.com<br><br>
This Service is only available to Faculty, students and staff of MSU. If you would like to recommend a book to purchase books for the library collection, please fill in the information in this online form. 
And If you would like more information, please contact phakanuch@msu.ac.th, nuntanit77@gmail.com<br><br>
</td>
</tr>
</table>
<script type="text/javascript">
<!--
function keytrap(evt){
	 var charCode = (evt.which) ? evt.which : evt.keyCode;
	 //alert(charCode);
	  if(charCode==13)return false;

	  return true;
}
//-->
</script>
<form method="post" action="suggest.php">
<table align=center width=800>
	<tr valign=top>
		<td>	<table class=table_border align=center width=700>
<tr>
	<td colspan=2 class=table_head style="background-color: #E6F5FF">รายละเอียดทรัพยากรที่ต้องการแนะนำสั่งซื้อ<br>
Fill in bibliographic information for purchase
</td>
</tr>
<tr>
	<td class=table_td>ชื่อหนังสือ *<br>Title </td>
	<td><input type="text" name="titl" ID="titl" size=50 onKeyUp="chktitle();" onkeydown="return keytrap(event);">
</td>
</tr>
<tr>
	<td class=table_td>ชื่อผู้แต่ง* <br>
Author
</td>
	<td><input type="text" name="auth" ID="auth" size=40 onKeyUp="chktitle();" onkeydown="return keytrap(event);"></td>
</tr>
<tr>
	<td class=table_td>ISBN*</td>
	<td><input type="text" name="isn" ID="isn" size=40 onKeyUp="chktitle();" onkeydown="return keytrap(event);"><br>
	โปรดระบุเฉพาะหมายเลข (Please in fill numeric) ex. 9789742662592</td>
</tr>
<tr>
	<td class=table_td>ปีพิมพ์*<br>Year
</td>
	<td><input type="text" name="yea" size=40 onkeydown="return keytrap(event);"></td>
</tr>
<tr>
	<td class=table_td>สำนักพิมพ์*<br>
Publisher 
 </td>
	<td><input type="text" name="pub" size=40 onkeydown="return keytrap(event);"></td>
</tr>
<tr>
	<td class=table_td>ราคา<br>
Price
  </td>
	<td><input type="text" name="price" ID="price" size=20 style='text-align:right;' onkeydown="return keytrap(event);"> บาท/฿</td>
</tr>
<tr>
	<td class=table_td>ลดราคา  </td>
	<td><input type="text" name="pricedis" ID="pricedis" size=10 style='text-align:right;' value=0 onkeydown="return keytrap(event);"> %</td>
</tr>
<tr>
	<td class=table_td>ข้อเสนอแนะเพิ่มเติม<br>
Additional comments or suggestions
  </td>
	<td><textarea name="s_oth" rows="3" cols="60"></textarea></td>
</tr>
<tr>
	<td class=table_td>ต้องการจำนวน  </td>
	<td><input type="text" name="copy" id=icopy size=5 value=1 style='text-align:right;' onkeydown="return keytrap(event);"> เล่ม</td>
</tr>
<tr>
	<td class=table_td>ราคาสุทธิ  </td>
	<td><b><div ID=pres onkeydown="return keytrap(event);"></div></b></td>
</tr>
<script type="text/javascript">
<!--
function localdsp() {
	dspobj=getobj("pres");
	icopy =getobj("icopy");
	priceobj=getobj("price");
	pricedisobj=getobj("pricedis");
	pricedisobj=pricedisobj.value/100;
	pricedisobj2=pricedisobj*priceobj.value;
	res=priceobj.value-pricedisobj2;
	res=res*icopy.value;
	dspobj.innerHTML=res;
	//dspobj.innerHTML=res
}
setInterval("localdsp()",200);

//-->
</script>
<tr>
	<td class=table_td>ใช้ในคณะ </td>
	<td>
	<?php 
$slist=",สำนักวิทยบริการ,คณะมนุษยศาสตร์และสังคมศาสตร์,คณะศึกษาศาสตร์,คณะการบัญชีและการจัดการ,คณะศิลปกรรมศาสตร์,คณะการท่องเที่ยวและการโรงแรม,วิทยาลัยการเมืองการปกครอง,วิทยาลัยดุริยางคศิลป์,คณะวัฒนธรรมศาสตร์,คณะวิทยาศาสตร์,คณะเทคโนโลยี,คณะวิศวกรรมศาสตร์,คณะสถาปัตยกรรมศาสตร์-ผังเมือง-นฤมิตศิลป์,คณะสิ่งแวดล้อมและทรัพยากรศาสตร์,คณะวิทยาการสารสนเทศ,สถาบันวิจัยวลัยรุกขเวช,คณะพยาบาลศาสตร์,คณะเภสัชศาสตร์,คณะสาธารณสุขศาสตร์,คณะแพทยศาสตร์,คณะสัตวแพทยศาสตร์และสัตวศาสตร์,สถาบันวิจัยศิลปะและวัฒนธรรมอีสาน,ศูนย์วิจัยและการศึกษาบรรพชีวินวิทยา,โรงเรียนประถมสาธิตมหาวิทยาลัยมหาสารคาม,โรงเรียนสาธิตมหาวิทยาลัยมหาสารคาม,ทดสอบ";
$slist=explode(",",$slist);
@reset($slist);
$subjchk=$_COOKIE['s_subjc'];
if ($s_subj!="") {
	$subjchk=$s_subj;
}
?><select name="s_subj"><?php 
while (list($k,$v)=each($slist)) {
	$v=trim($v);
	$sl="";
	if ($v==$subjchk) {
		$sl=" selected checked ";
	}
	echo "<option value='$v' $sl>$v";
}

?></select>

</td>
</tr>

<tr>
	<td colspan=2 class=table_head style="background-color: #E6F5FF">รายละเอียดผู้แนะนำ<br>
 Please fill in your information
</td>
</tr>
<tr>
	<td class=table_td>ชื่อ-สกุล*<br>
Name-Surname
 </td>
	<td><input type="text" name="s_name" size=40 ></td>
</tr>
<tr>
	<td class=table_td>สถานภาพ* <br>
Status 
  </td>
	<td><select name="s_stat">
		<option selected>นิสิตระดับปริญญาตรี (Bachelor's Degree)
		<option >นิสิตระดับปริญญาโท (master's degree)
		<option >นิสิตระดับปริญญาเอก (doctor's degree)
		<option >นักเรียนโรงเรียนสาธิตฯ (MSU Demonstration School)
		<option >อาจารย์ (Faculty)
		<option >บุคลากร มมส. (MSU Staff)
	</select></td>
</tr>
<tr>
	<td class=table_td>คณะ*<br>
Faculty, Institute, etc.

  </td>
	<td><select name="s_fac" style="width: 300px;">
		<option selected>คณะมนุษยศาสตร์และสังคมศาสตร์ Faculty of Humanities and Social Sciences
		<option >คณะศึกษาศาสตร์ Faculty of Education
		<option >คณะการบัญชีและการจัดการ Mahasarakham Business School
		<option >คณะศิลปกรรมศาสตร์ Faculty of Fine and Applied Arts
		<option >คณะการท่องเที่ยวและการโรงแรม Faculty of Tourism and Hotel Management
		<option >วิทยาลัยการเมืองการปกครอง College of Politics and Governance
		<option >วิทยาลัยดุริยางคศิลป์ College of Music MSU
		<option >คณะวัฒนธรรมศาสตร์ Faculty of Cultural Science
		<option >คณะวิทยาศาสตร์ Faculty of Science
		<option >คณะเทคโนโลยี Faculty of Technology
		<option >คณะวิศวกรรมศาสตร์ Faculty of Engineering
		<option >คณะสถาปัตยกรรมศาสตร์-ผังเมือง-นฤมิตศิลป์ Faculty of Architecture Urban Design and Creative Arts
		<option >คณะสิ่งแวดล้อมและทรัพยากรศาสตร์ Faculty of Environment and Resource Studies
		<option >คณะวิทยาการสารสนเทศ Faculty of Informatics
		<option >สถาบันวิจัยวลัยรุกขเวช Walai Rokhavej Botanical Research Institute
		<option >คณะพยาบาลศาสตร์ Faculty of Nursing
		<option >คณะเภสัชศาสตร์ Faculty of Pharmacy
		<option >คณะสาธารณสุขศาสตร์ Faculty of Public Health
		<option >คณะแพทยศาสตร์ Faculty of Medicine
		<option >คณะสัตวแพทยศาสตร์และสัตวศาสตร์ Faculty of Veterinary Sciences
		<option >สถาบันวิจัยศิลปะและวัฒนธรรมอีสาน The Research Institute of North-Eastern Art and Culture
		<option >โรงเรียนสาธิตฯ MSU Demonstration School
		<option >สำนักงานอธิการบดี Office of the President
		<option >สำนักคอมพิวเตอร์ Computer Center
		<option >สำนักวิทยบริการ AREC
	</select></td>
</tr>
<tr>
	<td class=table_td>อีเมล์*<br>
E-Mail 
</td>
	<td><input type="text" name="s_email" size=40 ><br>(โดยระบุเพื่อการแจ้งกลับข้อมูล)</td>
</tr>
<tr>
	<td class=table_td>เบอร์โทรติดต่อ/Tel.</td>
	<td><input type="text" name="s_tel" size=40 ></td>
</tr>
<tr>
	<td colspan=2 class=table_head style="background-color: #E6F5FF">อื่น ๆ</td>
</tr>
<tr>
	<td class=table_td>จากร้านค้า</td>
	<td><!-- <input type="text" name="s_store" size=40 >  -->
<?php 
$slist=",ภาดาเอ็ดดูเคชั่น,เพรลูดมิวสิคจำกัด,เอเชียบุ๊ค,ร้านบุ๊คเชนจ์,ร้านปรีชาพาณิชย์,ร้าน เอ็มเอ บุ๊ค,NP book,แอ๊ดว้านซ์ มีเดีย,ร้านบุ๊คทาวน์,ชาญชัยบุ๊คสโตร์,เอ็กเปอร์เน็ท,ซีเค บุ๊ค,พีเอ็มบี บุ๊คช๊อป,เมดซายน์บุ๊ค,สปาร์คไอเดีย,นิวบุ๊คกรุ๊ป ,สารพันธ์ศึกษา,บุ๊คส์ทูเดย์,เกรทบุ๊ค,คุ้มหนังสือ,นิพนธ์ จำกัด,ซีบุ๊คส์,มติชน (งานดี),พีบีฟอร์บุ๊คส์,big tiger,พีเอสบุ๊ค,ฟาร์อีสต์ พับลิเกชั่น,สถาพรบุ๊คส์,BookNet,ชยาพัธ บุ๊คส์,คิโนะคุนิยะ,Book and Print supply";
$slist=explode(",",$slist);
@reset($slist);
$storechk=$_COOKIE['s_storec'];
if ($s_store!="") {
	$storechk=$s_store;
}
?><select name="s_store"><?php 
while (list($k,$v)=each($slist)) {
	$v=trim($v);
	$sl="";
	if ($v==$storechk) {
		$sl=" selected checked ";
	}
	echo "<option value='$v' $sl>$v";
}

?></select>

	
	*กรณีแนะนำหนังสือในงาน Bookfair</td>
</tr>

<tr>
	<td colspan=2 class=table_head ><input type="submit" value="ส่งคำขอ" style="font-size: 22px;">
	
	
	</td>
</tr>
<input type="hidden" name="issave" value="yes">
</table>
</td>
		<td><iframe width=200 height=500 frameborder=no ID=mainif></iframe></td>
	</tr>
	</table>
	
	<center><b><a href="listbystatus.php"><img src="clickview.jpg" width="250" height="100" border="0" alt="คลิกเพื่อดูสถานะการสั่งซื้อ"></a></b>
</center>
</form>
<?php 
foot();
?>