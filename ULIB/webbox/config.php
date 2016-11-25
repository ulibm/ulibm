<?php  //พ
$tablayouts["2_Column_Right_big"][colnum]=2;
$tablayouts["2_Column_Right_big"][colwidth][1]="300";
$tablayouts["2_Column_Right_big"][colwidth][2]="570";

$tablayouts["2_Column"][colnum]=2;
$tablayouts["2_Column"][colwidth][1]="435";
$tablayouts["2_Column"][colwidth][2]="435";

$tablayouts["3_Column_big_center"][colnum]=3;
$tablayouts["3_Column_big_center"][colwidth][1]="235";
$tablayouts["3_Column_big_center"][colwidth][2]="400";
$tablayouts["3_Column_big_center"][colwidth][3]="235";

$tablayouts["3_Column"][colnum]=3;
$tablayouts["3_Column"][colwidth][1]="290";
$tablayouts["3_Column"][colwidth][2]="290";
$tablayouts["3_Column"][colwidth][3]="290";

$tablayouts["4_Column"][colnum]=4;
$tablayouts["4_Column"][colwidth][1]="217";
$tablayouts["4_Column"][colwidth][2]="217";
$tablayouts["4_Column"][colwidth][3]="217";
$tablayouts["4_Column"][colwidth][4]="217";

$tablayouts[Full_Width][colnum]=1;
$tablayouts[Full_Width][colwidth][1]="870";

$tablayouts[Two_Column_Left_big][colnum]=2;
$tablayouts[Two_Column_Left_big][colwidth][1]="570";
$tablayouts[Two_Column_Left_big][colwidth][2]="300";

$tablayouts[noneWebpage][colnum]=0;
$tablayouts[noneWebpage][colwidth][1]="870";

// convert for flexible val
 @reset($tablayouts);
 while (list($tablayoutsk,$tablayoutsv)=each($tablayouts)) {
	for ($tablayoutsi=1;$tablayoutsi<=$tablayouts[$tablayoutsk][colnum];$tablayoutsi++) {
		$tmppercent=percent_cal(1000-130,$tablayouts[$tablayoutsk][colwidth][$tablayoutsi]); // base calc menu width=130
		$tmppercent=$tmppercent/100;
		$tmppercent=(1000-floor(barcodeval_get("webboxoptions-menuwidth")))*$tmppercent;
		$tablayouts[$tablayoutsk][colwidth][$tablayoutsi]=floor($tmppercent);
	}
 }

 //printr($tablayouts);
?>