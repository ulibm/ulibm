<?php 
include("../../inc/config.inc.php");
include("./_conf.php");
head();
        mn_root("activateulib");
$tbname="ulib_clientlogins";


$c[2][text]="Login ID";
$c[2][field]="loginid";
$c[2][fieldtype]="text";
$c[2][descr]="";
$c[2][defval]="";

$c[3][text]="Password";
$c[3][field]="passwd";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]=rand(1000,9999);

$c[4][text]="Name";
$c[4][field]="name";
$c[4][fieldtype]="text";
$c[4][descr]="";
$c[4][defval]="";

$c[17][text]="ประเภทหน่วยงาน";
$c[17][field]="orgtype";
$c[17][fieldtype]="foreign:-localdb-,ulib_clientlogins_cate,name,name";
$c[17][descr]="";
$c[17][defval]="หน่วยงานรัฐ";

$c[12][text]="Allow";
$c[12][field]="isallowed";
$c[12][fieldtype]="yesno";
$c[12][descr]="";
$c[12][defval]="yes";

$c[14][text]="อีเมล์";
$c[14][field]="email";
$c[14][fieldtype]="text";
$c[14][descr]="";
$c[14][defval]="";

$c[15][text]="เบอร์โทรศัพท์";
$c[15][field]="tel";
$c[15][fieldtype]="text";
$c[15][descr]="";
$c[15][defval]="";

$c[16][text]="ที่อยู่";
$c[16][field]="address";
$c[16][fieldtype]="longtext";
$c[16][descr]="";
$c[16][defval]="";

//dsp

$dsp[3][text]="Name";
$dsp[3][field]="name";
$dsp[3][filter]="module:local_dsp";
$dsp[3][width]="70%";
function local_dsp($wh) {
	$c1=tmq("select * from ulib_clientlogins_support where uug='$wh[loginid]' ");
	$c1=tmq_num_rows($c1);
	$p1=tmq("select sum(price) as aa from ulib_clientlogins_support where uug='$wh[loginid]' ");
	$p1=tmq_fetch_array($p1);
	$p1=$p1[aa];

	$s="<b>".$wh[name]."</b> - $wh[orgtype]<br>
	&gt; <a href='uug.support.php?id=$wh[loginid]'>ประวัติ support ($c1 = ".number_format($p1)." ฿)</a> :  <a href='uug.ma.php?id=$wh[loginid]'>ประวัติ M/A</a>
	<font class=smaller>";
	$p1=tmq("select sum(price) as aa from ulib_clientlogins_ma where uug='$wh[loginid]' ");
	$p1=tmq_fetch_array($p1);
	$p1=number_format($p1[aa]);
	$c2=tmq("select * from ulib_clientlogins_ma where uug='$wh[loginid]' ");
	$c2=tmq_num_rows($c2);
	$s.=" ($c2)";

	$s1=tmq("select * from ulib_clientlogins_ma where uug='$wh[loginid]' and matype='เริ่มM-A' ");
	if (tmq_num_rows($s1)==0) {
		$s.=" : ยังไม่เคย M/A";
	} else {
		$s1=tmq_fetch_array($s1);
		$dts=$s1[dt];
		$s1=tmq("select * from ulib_clientlogins_ma where uug='$wh[loginid]' and matype<>'เริ่มM-A' ");
		//echo "<br>$dts";
		while ($r=tmq_fetch_array($s1)) {
			$dts=$dts+floor(60*60*24*30*floor($r[month]));
			//echo "<br>".floor(60*60*24*30*floor($r[month]));
		}
		//echo "<br>$dts";
		$s.="<br> &nbsp;&nbsp;&nbsp; คุ้มครองถึง ".ymd_datestr($dts,"date");;
	}
	$s.=" = ".($p1)." ฿</font><br>";
	$c3=tmq("select * from ulib_clientlogins_contact where uug='$wh[loginid]' ");
	$c3=tmq_num_rows($c3);
	$s.=" &gt; <a href='uug.contact.php?id=$wh[loginid]'>ชื่อผู้ติดต่อ ".number_format($c3)."</a><br>";
	$s3=tmq("select * from ulib_clientlogins_contact where uug='$wh[loginid]' order by name ");
	while ($r3=tmq_fetch_array($s3)) {
		$s.=" &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($r3[name])." <font class=smaller2>" .($r3[email])." ".$r3[tel]."</font> (รับผิดชอบด้าน: $r3[role])<br>";

	}
   $s.="<br><a href='print.php?id=$wh[id]' target=_blank>Print permission form</a>";
	 return $s;
}


$dsp[12][text]="ล็อกอินรหัสผ่าน";
$dsp[12][field]="isallowed";
$dsp[12][filter]="module:local_login";
$dsp[12][width]="20%";

function local_login($wh) {
	return  "[$wh[loginid]][$wh[passwd]]";
}

$dsp[14][text]="อนุญาตแล้ว?";
$dsp[14][field]="isallowed";
$dsp[14][filter]="switchsingle";
$dsp[14][width]="10%";

?>
<center> Search <form action="<?php echo $PHP_SELF;?>" meghod=get>
<input type=text name=kw value="<?php echo $kw;?>">
<?php form_quickedit("stype",$stype,"foreign:-localdb-,ulib_clientlogins_cate,name,name");?> <input type=submit>
</form>
<?php
$limit=" 1 ";
$kw=addslashes($kw);
if ($kw!="") {
   $chk=tmq("select * from $tbname where loginid='$kw' ");
   if (tnr($chk)==1) {
      $limit=" loginid='$kw' ";
   } else {
      $limit=" (name like '%$kw%' 
      or address like '%$kw%' 
      or email like '%$kw%' 
      or tel like '%$kw%' )
       ";
   }
   
   
}
if ($stype!="") {
   $limit.=" and orgtype='$stype' ";
}
fixform_tablelister($tbname," $limit ",$dsp,"yes","yes","yes","mi=$mi",$c);

foot();
?>