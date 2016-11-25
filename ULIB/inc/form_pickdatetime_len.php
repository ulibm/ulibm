<?php // พ
function form_pickdatetime_len($formname,$dt) {
	////func("form_pickdatetime_len($formname,$dt) ");
	if ($dt=="" || $dt==0) {
		//$dt=time();
	}
	$dayl=60*60*24;
	$hourl=60*60;
	$minl=60;
	$secl=1;
echo "[$dt]";

	?>	day<INPUT TYPE="text" NAME="<?php echo $formname?>_day" size=2 maxlength=2  value="<?php  echo floor($dt/$dayl)?>"><?php 
	?>	hour<INPUT TYPE="text" NAME="<?php echo $formname?>_hou" size=2 maxlength=2  value="<?php  echo floor(($dt % $dayl)/$hourl)?>"><?php 
	?>	min<INPUT TYPE="text" NAME="<?php echo $formname?>_min" size=2 maxlength=2  value="<?php  echo floor(($dt % $hourl)/$minl)?>"><?php 
	?>	sec<INPUT TYPE="text" NAME="<?php echo $formname?>_sec" size=2 maxlength=2  value="<?php  echo floor(($dt % $minl)/$secl)?>"><?php 
}
?>