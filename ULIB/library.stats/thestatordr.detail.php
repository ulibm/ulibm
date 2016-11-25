<?php  //พ
$dsp[2][text]="Statistic";
$dsp[2][field]="head";
$dsp[2][width]="30%";
$dsp[2][filter]="module:localheaddsp";

$dsp[3][text]="Counted";
$dsp[3][field]="cc";
$dsp[3][width]="10%";
$dsp[3][align]="center";

$dsp[7][text]="Last Update";
$dsp[7][field]="lastdt";
$dsp[7][filter]="datetime";
$dsp[7][align]="center";
$dsp[7][width]="30%";


function localheaddsp($wh) {
	global $db;
	global $sdb;
	return local_getdspstr($wh[head],$sdb[$db][headmode]);
}


$tbname=$tbl;
$yea=floor($yea);
$mon=floor($mon);
if (floor($yea)==0 || floor($mon)==0) {
	 $yea=date("Y");
	 $mon=date("m");
}
$limit=" yea='$yea' and mon='$mon'  ";

?><table align=center width=<?php  echo $_TBWIDTH?>>
<tr>
	<td align=center><?php 
	$ylist=tmq("select distinct yea from $tbname order by yea",false);
	while ($ylistr=tfa($ylist)) {
		echo "<b>$ylistr[yea]</b><br>";
		$mlist=tmq("select distinct mon from $tbname where yea='$ylistr[yea]' order by mon",false);
		while ($mlistr=tfa($mlist)) {
			echo "<a ";
			if (floor($ylistr[yea])==$yea && floor($mlistr[mon])==$mon) {
				echo " class=a_btn";
			}
			echo " href='$PHP_SELF?db=$db&yea=$ylistr[yea]&mon=$mlistr[mon]'>".$thaimonstr[floor($mlistr[mon])]."</a> ";
		}
		echo "<hr noshade>";
	}
	?></td>
</tr>
</table><?php 

fixform_tablelister($tbname," $limit ",$dsp,"no","no","no","db=$db&$addquery",$c," cc desc ");

?>