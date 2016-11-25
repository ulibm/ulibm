<?php // พ
function ddx($sdat8,$smon8,$syea8,$edat8,$emon8,$eyea8) {
	 //แสดงจำนวนต่างระหว่างวันสองวัน
	//echo "ddx($sdat8,$smon8,$syea8,$edat8,$emon8,$eyea8)";
	//date differance from start and end
	//echo "$sdat8,$smon8,$syea8,$edat8,$emon8,$eyea8";
	$d111=GregorianToJD2($smon8,$sdat8,$syea8);
	$d222=GregorianToJD2($emon8,$edat8,$eyea8);
	return $d222-$d111;
}
?>