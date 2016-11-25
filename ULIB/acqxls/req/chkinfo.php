<?php 
include("../../inc/config.inc.php");
include("../cfg.inc.php");
html_start();
$titl=addslashes($titl);$titl=trim($titl);
$auth=addslashes($auth);$auth=trim($auth);
$isn=str_replace("-","",$isn);
$isn=str_replace(" ","",$isn);
$isn=str_replace(".","",$isn);
$isn=str_replace(" ","",$isn);
$isn=addslashes($isn);$isn=trim($isn);
//echo strlen($isn);
//check isbn
if (strlen($isn)==10 || strlen($isn)==13) {
	$smaster="select * from index_db where 1  ";
	$smaster.=" and isbn like '%$isn%' ";
	$smaster.=" order by id asc ";

	$s=tmq($smaster);
	if (tnr($s)!=0) { 
          //echo "ยังไม่พบ ISBN นี้ในฐานข้อมูล<BR>";
   } else {
       echo "<font style='color:darkgreen; font-weight:bold; font-size:18px;'>ไม่พบทรัพยากร ISBN นี้ในฐานข้อมูล</font><BR><BR>";
       ?><a href="getinfo.php?isn=<?php echo $isn?>">ดึงข้อมูลจาก GoogleBook</a><BR><BR><?php
   }   
      
}

	$s="select * from acqn_sub where 1";
	if ($titl!="") {
		$s.=" and titl like '%$titl%' ";
	}
	if ($auth!="") {
		$s.=" and auth like '%$auth%' ";
	}
	if ($isn!="") {
		$s.=" and isn like '%$isn%' ";
	}
		$s.=" limit 20";
	$s=tmq($s);
	if (tnr($s)==0) {


		die;
	}
	echo "<font color=darkred>พบข้อมูลคล้ายคลึงกันในฐานข้อมูลแนะนำสั่งซื้อแล้ว</font><br>";
	$i=1;
	while ($r=tfa($s)) {
		$i++;
		if ($i %2 ==0 ){
			$c="#F0F0F0";
		} else {
			$c="white";
		}

		echo "<div style=\"display:inline-block; width:100%; background-color: $c\">&bull; <a href='../viewsub.php?id=$r[id]' target=_blank style='font-size: 11px;'>$r[titl] / $r[auth] / $r[isn]</a>";
		echo " <font style='font-size: 11px;'>สถานะ: ".$_s[$r[stat]][name]."</font>";
		echo "</div>";
	}



		echo "<br>";
	$smaster="select * from index_db where 1  ";
	if ($titl!="") {
		$smaster.=" and titl like '%$titl%' ";
	}
	if ($auth!="") {
		$smaster.=" and auth like '%$auth%' ";
	}
	if ($isn!="") {
		$smaster.=" and isn like '%$isn%' ";
	}
	$smaster.=" order by id asc ";

	$s=tmq($smaster);
	if (tnr($s)!=0) { 
		echo "<br><font  color=darkred>ค้นพบในฐานข้อมูล ".tnr($s)." รายการ</font><BR>";
	} else {
		echo "<br><FONT  color=darkgreen style='font-size:11; font-weight:bold;'>ไม่พบข้อมูลซ้ำซ้อนในฐานข้อมูล</FONT>";
	}
if (tnr($s)>10) { 
	echo "<font class=smaller2>แสดงผลการค้นหา 10 รายการแรก</font><BR>";
}

		$countdsp=0;
	while ($r=tfa($s) ) {
		$countdsp++;
		if ($countdsp>10) continue;
		?> &bull;<a href="<?php  echo $dcrURL?>dublin.php?ID=<?php  echo $r[mid]?>" target=_blank class=smaller2><?php 
			echo marc_gettitle($r[mid]);

		?></a><br><?php 
	}
	//print_r("$v");

?>