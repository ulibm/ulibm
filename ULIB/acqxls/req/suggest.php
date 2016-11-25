<?php 
include("../../inc/config.inc.php");
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
head();
mn_web("acq");

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
	<td><center><b style='font-size: 14px;'><?php 
	echo str_webpagereplacer(stripslashes(barcodeval_get("acqxls-suggestionform_head")));
	?></b></center><br>
<?php 
	echo str_webpagereplacer(stripslashes(barcodeval_get("acqxls-suggestionform_body")));
	?><br><br>
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
<table align=center width=1000>
	<tr valign=top>
		<td>	<table class=table_border align=center width=750>
<tr>
	<td colspan=2 class=table_head style="background-color: #E6F5FF">รายละเอียดทรัพยากรที่ต้องการแนะนำสั่งซื้อ<br>
Fill in bibliographic information for purchase
</td>
</tr>
<tr>
	<td class=table_td>ISBN*</td>
	<td><input type="text" name="isn" ID="isn" size=40 onKeyUp="chktitle();" onkeydown="return keytrap(event);"><br>
	โปรดระบุเฉพาะหมายเลข (Please in fill numeric) ex. 9789742662592</td>
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
	<td class=table_td>ปีพิมพ์*<br>Year
</td>
	<td><input type="text" name="yea" ID="yeaID" size=40 onkeydown="return keytrap(event);"></td>
</tr>
<tr>
	<td class=table_td>สำนักพิมพ์*<br>
Publisher 
 </td>
	<td><input type="text" name="pub" ID="pubID" size=40 onkeydown="return keytrap(event);"></td>
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
	form_quickedit("s_subj",$s_subj,"foreign:-localdb-,acqn_faculty,name,name,allowblank");?>
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
	<td>
	<?php 

$slist=explodenewline("\n".barcodeval_get("acqxls-suggestionform_memstatus"));
@reset($slist);
$storechk=$_COOKIE['s_stat'];
if ($s_store!="") {
	$storechk=$s_store;
}
?><select name="s_stat"><?php 
while (list($k,$v)=each($slist)) {
	$v=trim($v);
	$sl="";
	if ($v==$storechk) {
		$sl=" selected checked ";
	}
	echo "<option value='$v' $sl>$v";
}

?></select>

</td>
</tr>
<tr>
	<td class=table_td>คณะ*<br>
Faculty, Institute, etc.

  </td>
	<td><?php 
	form_quickedit("s_fac",$s_fac,"foreign:-localdb-,acqn_faculty,name,name,allowblank");?></td>
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
form_quickedit("s_storec",$s_fac,"foreign:-localdb-,acqn_company,name,name,allowblank");
?>
</td>
</tr>

<tr>
	<td colspan=2 class=table_head ><input type="submit" value="ส่งคำขอ" style="font-size: 22px;">
	
	
	</td>
</tr>
<input type="hidden" name="issave" value="yes">
</table>
</td>
		<td><iframe width=250 height=700 frameborder=no ID=mainif></iframe></td>
	</tr>
	</table>
	
	<center><b><a href="listbystatus.php"><img src="clickview.jpg" width="250" height="100" border="0" alt="คลิกเพื่อดูสถานะการสั่งซื้อ"></a></b>
</center>
</form>
<?php 
foot();
?>