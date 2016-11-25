<?php 
include("cfg.inc.php");/*
print_r($_SESSION);
if ($_tmid=="peace") {
	$s=tmq("select * from acqn_sub");
	while ($r=tfa($s)) {
		$now=time();
		$x="insert into acqn_sub_clog set subid='$r[id]',dt='$now',stat='$r[stat]' ";
		tmq( $x);
	}
}
*/
/*?><link rel="stylesheet" type="text/css" href="<?php  echo $dcrURL;?>/xlscss/excel-2007.css" />
<?php */

$s="select * from acqn where id=$pid";
$s=tmq($s);
$s=tfa($s);
$bystore=trim($bystore);
$bystore=addslashes($bystore);
$s2="select * from acqn_sub where pid=$pid";
if ($mode!="") {
	$s2.=" and stat='$mode' ";
}
if ($dateafter!="") {
	//echo ymd_datestr($dateafter);
	$s2.=" and id in (SELECT subid from acqn_sub_clog where dt>=$dateafter) ";
}
if ($budget!="") {
	if ($budget=="[blank]") {
		$budget="";
	}
	$s2.=" and budget='$budget' ";
}
if ($subj!="") {
	if ($subj=="[blank]") {
		$subj="";
	}
	$s2.=" and s_subj='$subj' ";
}
if ($bystore!="") {
	if ($bystore=="[blank]") {
		$bystore="";
	}
	$s2.=" and s_store='$bystore' ";

	//transid s
	$st=tmq("select * from acqn_sub where transid=0 and s_store='$bystore' order by id");
	if (tnr($st)!=0) {
		$strun=tmq("select * from acqn_sub where s_store='$bystore' order by transid desc limit 1");
		$strun=tfa($strun);
		$strun=floor($strun[transid]);
		//echo "[strun=$strun;]";die;
		while ($str=tfa($st)) {
			$strun=$strun+1;
			tmq("update acqn_sub set transid='$strun' where id='$str[id]' ");
		}
	}
	//transid e
}
//echo $s2;
$s2.=" order by id";
$s2=tmq($s2);
	$tmpname=$s[name]." (".$_s[$mode][name].")";
	if ($bystore!="") {
		$tmpname.= " ร้าน ".$bystore;
	}
	if ($subj!="") {
		$tmpname.= " คณะ ".$subj;
	}
$tmpname=str_replace("()","",$tmpname);

function tis620_to_utf8($text) {
$utf8 = "";
for ($i = 0; $i < strlen($text); $i++) {
$a = substr($text, $i, 1);
$val = ord($a);

if ($val < 0x80) {
$utf8 .= $a;
} elseif ((0xA1 <= $val && $val < 0xDA) || (0xDF <= $val && $val <= 0xFB)) {
$unicode = 0x0E00+$val-0xA0; $utf8 .= chr(0xE0 | ($unicode >> 12));
$utf8 .= chr(0x80 | (($unicode >> 6) & 0x3F));
$utf8 .= chr(0x80 | ($unicode & 0x3F));
}
}
return $utf8;
}

$filename=$tmpname.".xls";

//print_r($_GET);die;
if ($xlsviewonly=="") {
	$xlsviewonly="yes";
}
//$xlsviewonly="yes";
if ($submittype=="ดูตัวอย่าง" || $viewonly=="yes") {
	$xlsviewonly="yes";
}


if ($xlsviewonly!="yes") {
	header("Content-Type: application/vnd.ms-excel;");
	header("Content-Disposition: attachment; filename='$filename'");
	header("Pragma: no-cache");
	header("Expires: 0");
	   echo "\xEF\xBB\xBF"; //UTF-8 BOM
}


?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php 

/*
include('ExcelWriterXML/ExcelWriterXML.php');

$xml = new ExcelWriterXML;
$xml->sendHeaders('charset=UTF-8');
$xml->docAuthor('Suntiparp Plienchote');

$format = $xml->addStyle('StyleHeader');
$format->fontBold();
$format->alignHorizontal('Center');
$format->fontName("Tahoma");

$format1 = $xml->addStyle('moneydsp');
$format1->alignHorizontal('Right');

$format2 = $xml->addStyle('justcenter');
$format2->alignHorizontal('Center');


//$format->alignRotate(45);
$sheet = $xml->addSheet('My Sheet');
$stitle=$s[name]." (".$_s[$mode][name].") <img src='../../../Desktop/_weblogo.png' width='261' height='66' border='0' alt=''>";
	if ($bystore!="") {
		$stitle. " ร้าน ".$bystore;
	}
$sheet->writeString(2,1,tis620_to_utf8($stitle));

$sheet->columnWidth(2,100);
$sheet->columnWidth(3,130);
$sheet->columnWidth(4,100);
$sheet->columnWidth(7,80);
$sheet->columnWidth(9,80);

$sheet->writeString(3,1,tis620_to_utf8('ลำดับ ','StyleHeader'));
$sheet->writeString(3,2,tis620_to_utf8('รหัส '),'StyleHeader');
$sheet->writeString(3,3,tis620_to_utf8('ชื่อหนังสือ '),'StyleHeader');
$sheet->writeString(3,4,tis620_to_utf8('ผู้แต่ง '),'StyleHeader');
$sheet->writeString(3,5,tis620_to_utf8('ปีพิมพ์ '),'StyleHeader');
$sheet->writeString(3,6,tis620_to_utf8('จำนวน '),'StyleHeader');
$sheet->writeString(3,7,tis620_to_utf8('ราคา '),'StyleHeader');
$sheet->writeString(3,8,tis620_to_utf8('ส่วนลด '),'StyleHeader');
$sheet->writeString(3,9,tis620_to_utf8('สุทธิ '),'StyleHeader');



$i=0;
while ($r=tfa($s2)) {
	$i++;
	$r[pricenet]=floor($r[pricenet]);
	if (floor($r[pricenet])==0) {
		$r[pricenet]="-";
	}

	$s_copy=$s_copy+$r[copy];
	$s_price=$s_price+$r[price];
	$s_pricenet=$s_pricenet+$r[pricenet];
	$rownum=3+$i;
	$sheet->writeString($rownum,1,tis620_to_utf8(number_format($r[id])),'justcenter');
	$sheet->writeString($rownum,2,tis620_to_utf8($r[isn]));
	$sheet->writeString($rownum,3,tis620_to_utf8(stripslashes($r[titl])));
	$sheet->writeString($rownum,4,tis620_to_utf8(stripslashes($r[auth])));
	$sheet->writeString($rownum,5,tis620_to_utf8(stripslashes($r[yea])));
	$sheet->writeString($rownum,6,tis620_to_utf8($r[copy]),'justcenter');
	$sheet->writeString($rownum,7,tis620_to_utf8(number_format($r[price],2)),'moneydsp');
	$sheet->writeString($rownum,8,tis620_to_utf8(number_format($r[pricedis],2)),'moneydsp');
	$sheet->writeString($rownum,9,tis620_to_utf8(number_format($r[pricenet],2)),'moneydsp');
 }


 //sum
 $rownum=$rownum+1;

	$sheet->writeString($rownum,5,tis620_to_utf8('รวม '),'StyleHeader');

	$sheet->writeString($rownum,6,tis620_to_utf8($s_copy),'justcenter');
	$sheet->writeString($rownum,7,tis620_to_utf8(number_format($s_price,2)),'moneydsp');

	$sheet->writeString($rownum,9,tis620_to_utf8(number_format($s_pricenet,2)),'moneydsp');



$xml->sendHeaders();
$xml->writeData();
die;
*/


?>
<table width=100% border=1>
<tr>
	<td colspan=11 align=center height=82 style="text-align:center; border-width:0px;"><?php 
	echo str_webpagereplacer(stripslashes(barcodeval_get("acqxls-excelheader")));
	?>
	</td>
</tr>
<tr>
	<td colspan=12 align=center><?php 
	
echo "<B>$tmpname</B> <a href=\"xls.php?xlsviewonly=download&bystore=$bystore&subj=$subj&budget=$budget&dateafter=$dateafter&pid=$pid&mode=$mode\">Download</a>";
/*
if ($bystore!="") {
	echo " รายงานสำหรับ ".stripslashes($bystore)."\n";;
}*/

	?></td>
</tr>
<tr>
	<td colspan=12 align=center><?php 
	
	echo "<FONT style='font-size:12px'>สร้างเมื่อ:".ymd_datestr(time())."</FONT>";
	?></td>
</tr>
<tr bgcolor="#E4E4E4" style="font-size: 14pt; font-family: 'TH SarabunPSK'">					  	  	  

	<th>ลำดับ</th>
	<th>รายการหนังสือ</th>
	<th>ผู้แต่ง</th>
	<th>ISBN</th>
	<th>ครั้งที่/ปีพิมพ์</th>
	<th>ราคา</th>
	<th>ส่วนลด</th>
	<th>สุทธิ</th>
	<th>จำนวน</th>
	<!-- <th>คณะ</th> -->
	<th>ผู้แนะนำ</th>
	<td   align=center style="width:35px; <?php  echo $ccss;?>"><?php 
if ($bystore!="") {
	echo "คณะ";
} else {
	echo "ร้านค้า";
}?></td>
	<th>-</th>
</tr>
<?php  
$i=0;
$ccss="font-size: 16pt; font-family: 'TH SarabunPSK'";
$ccss2="font-size: 14pt; font-family: 'TH SarabunPSK'";
$ccsssmall="font-size: 10pt; font-family: 'TH SarabunPSK'";
while ($r=tfa($s2)) {
	$i++;
	$r[pricenet]=floor($r[pricenet]);
	if (floor($r[pricenet])==0) {
		$r[pricenet]="-";
	}

	$s_copy=$s_copy+$r[copy];
	$s_price=$s_price+$r[price];
	$s_pricenet=$s_pricenet+$r[pricenet];
	?>

<tr>
	<td   align=center style="width:35px; <?php  echo $ccss;?>"><?php 
/*if ($bystore!="") {
	echo number_format($r[transid]);
} else {
	//echo number_format($r[id]);
	echo number_format($i);
}*/
	echo number_format($i);

?></td>
	<td style="width:250px; <?php  echo $ccss;?>"><?php  echo stripslashes($r[titl]);
if ($xlsviewonly=="yes") {
	?> <a href="sub.php?pid=<?php  echo $r[pid]?>&orderby=dt&searchkw=&bystore=&bysubj=&limitstat=&subj=&fftmode=edit&ffteditid=<?php  echo $r[id]?>&startrow=0" target=_blank>แก้ไข</a><?php 
}
?></td>
	<td style="width:150px; <?php  echo $ccss;?>"><?php  echo stripslashes($r[auth]);?></td>
	<td style="width:120px; <?php  echo $ccss2;?>">&nbsp;<?php  echo $r[isn]?></td>
	<td style="width:70px; <?php  echo $ccss;?>">&nbsp;<?php  echo stripslashes($r[yea]);?></td>
	<td style="width:70px; <?php  echo $ccss2;?>" align=right>&nbsp;<?php  echo number_format($r[price],2);?></td>
	<td style="width:50px; <?php  echo $ccss2;?>" align=right>&nbsp;<?php  echo number_format($r[pricedis],2);?></td>
	<td style="width:70px; <?php  echo $ccss2;?>" align=right>&nbsp;<?php  echo number_format($r[pricenet],2);?></td>
	<td style="width:45px; <?php  echo $ccss2;?>" align=center>&nbsp;<?php  echo stripslashes($r[copy]);?></td>
	<!-- <td style="width:70px; <?php  echo $ccss2;?>" align=center>&nbsp;<?php  echo stripslashes($r[s_subj]);?></td> -->
	<td style="width:100px; <?php  echo $ccss2;?>" align=center>&nbsp;<?php  echo stripslashes($r[s_name]);?><font style=" <?php  echo $ccsssmall;?>"> <?php  echo stripslashes($r[s_tel]. " ".$r[s_email]);?></font></td>
	<td style="width:70px; <?php  echo $ccss2;?>" align=center>&nbsp;<?php 
	if ($bystore!="") {
		echo stripslashes($r[s_subj]);
	} else {
		echo stripslashes($r[s_store]);
	}?></td>
	<td style="width:40px; <?php  echo $ccss2;?>" align=center><?php  echo stripslashes($r[id]);?></td>
</tr>
<?php  } ?>
<tr bgcolor="#E4E4E4">
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td >รวม</td>
	<!-- <td align=center><?php  echo stripslashes($s_copy);?></td> -->
	<td align=right colspan=2><?php  echo number_format($s_price,2);?></td>
	<td align=right colspan=2><?php  echo number_format($s_pricenet,2);?></td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
</tr>
</table>
