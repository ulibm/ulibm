<?php  
include("./cfg.inc.php");
limitpage_var();
html_start();
//print_r($_GET);
?><form method="post" action="_acqdupchecker.php">
	ค้นหาด้วย <input type="text" 
	name="titl"
	value="<?php echo $titl?>"
	> <input type="submit" value="ค้นหา">
<input type="hidden" name="kid_ID" value="<?php echo $kid_ID;?>">
</form><?php  
if ($titl=="") {
	die();
}
$titl=addslashes($titl);$titl=trim($titl);
$auth=addslashes($auth);$auth=trim($auth);
$isn=addslashes($isn);$isn=trim($isn);
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
		echo "<font  color=darkgreen>ยังไม่มีซ้ำกับข้อมูลในฐานข้อมูลสั่งซื้อ</font><br><br>
		อย่างไรก็ดี ควรสืบค้นในฐานข้อมูลระบบห้องสมุดอัตโนมัติ 
		โดยคลิกลิงค์ด้านล่าง<br>";
		if ($titl!="") {
			echo "&nbsp;&nbsp;&bull; ชื่อเรื่อง <u><a href=\"http://lib3.msu.ac.th/search/?searchtype=t&SORT=D&searcharg=$titl\" target=_blank>$titl</a></u><br>";
		}
		if ($auth!="") {
			echo "&nbsp;&nbsp;&bull; ผู้แต่ง <u><a href=\"http://lib3.msu.ac.th/search/?searchtype=a&SORT=D&searcharg=$auth\" target=_blank>$auth</a></u><br>";		
		}
		if ($isn!="") {
			echo "&nbsp;&nbsp;&bull; ISBN <u><a href=\"http://lib3.msu.ac.th/search/i?SEARCH=$isn&sortdropdown=-&submit=Submit\" target=_blank>$isn</a></u><br>";
		}

		die;
	}
	echo "<font color=darkred>พบข้อมูลคล้ายคลึงกันในฐานข้อมูลแนะนำสั่งซื้อแล้ว</font><br>";
	$i=1;
	while ($r=tnr($s)) {
		$i++;
		if ($i %2 ==0 ){
			$c="#F0F0F0";
		} else {
			$c="white";
		}

		echo "<div style=\"display:inline-block; width:100%; background-color: $c\">&bull; <a href='./viewsub.php?id=$r[id]' target=_blank style='font-size: 11px;'>$r[titl] / $r[auth] / $r[isn]</a>";
		echo " <font style='font-size: 11px;'>สถานะ: ".$_s[$r[stat]][name]."</font>";
		echo "</div>";
	}
?>