<?php  //พ
if ($file=="") {
	die;
}
$time=floor($time);
if ($time==0) {
	 $time=3;
}
?><meta http-equiv=refresh content="<?php  echo $time?>;URL=<?php echo $file?>">

<font color="#808080"><b>Loading..</b></font>