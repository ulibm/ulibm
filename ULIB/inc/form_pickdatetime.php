<?php // พ
function form_pickdatetime($formname,$tim="",$datemode="normal") {
	////func("form_pickdatetime($formname,$tim");
	if ($tim=="" || $tim==0) {
		$tim=time();
	}
	form_pickdate($formname,$tim,"no",$datemode);
	?>

	<INPUT TYPE="text" NAME="<?php echo $formname?>_hou" size=2 maxlength=2 value="<?php  echo date("H",$tim);?>" style="text-align:center">:
	<INPUT TYPE="text" NAME="<?php echo $formname?>_min" size=2 maxlength=2  value="<?php  echo date("i",$tim)?>" style="text-align:center"> 
	<INPUT TYPE="hidden" NAME="<?php echo $formname?>_sec" size=2 maxlength=2  value="0">
	<?php 
}
?>