<?php 
function form_pickdate($formname,$tim=0,$isallownonspec="no",$datemode="normal") {
	//echo "[form_pickdate-$formname,$tim,$isallownonspec,$datemode]";
	global $_MSTARTY;
	global $_MENDY;
	global $dcrURL;
	global $form_pickdate_initialized;
	//echo ymd_datestr($tim);
	if ($tim<=0) {
		$tim=0;
	}
	if ($datemode=="normal" || $datemode=="") {
		$_XSTARTY=$_MSTARTY;
		$_XENDY=$_MENDY;
	}
	if ($datemode=="birthday") {
		$_XSTARTY=1930+543;
		$_XENDY=@date('Y')+540;
	}
	$localid="a".randid();
	$_XSTARTY2=$_XSTARTY-543;
	$_XENDY2=$_XENDY-543;
	////func("form_pickdate($formname,$tim");
	if ($tim=="" || $tim==0) {
		$tim=time();
	}
	global $thaimonstr;
	$_YMD_thmon=$thaimonstr;
	if ($form_pickdate_initialized=="") {
		$form_pickdate_initialized="yes";
		?>
	<link href="<?php  echo $dcrURL?>js/datepicker/rfnet.css.php" rel="stylesheet" type="text/css">
   <script type="text/javascript" src="<?php  echo $dcrURL?>js/datepicker/js.php?fake=thisfile.js"></script><?php 
	}
?>
<select name ="<?php echo $formname?>_dat" id="<?php  echo $localid?>_dat"><?php 
	if ($isallownonspec!="no") {
		echo "<option value='' >ไม่ระบุ";
	}
		for ($i=1; $i <= 31; $i++) {
			$sl = "";
			if (date("j",$tim) == $i) {
				$sl="selected";
			}
			print "<option value='$i' $sl>$i";
		}
	?></select>
<select name = "<?php echo $formname?>_mon" id="<?php  echo $localid?>_mon"><?php 
	if ($isallownonspec!="no") {
		echo "<option value='' >ไม่ระบุ";
	}

		for ($i=1; $i <= 12; $i++) {
			$sl = "";
			$sw=@date("n",$tim);
			if ($sw == $i) {
				$sl="selected";
			}
			print "<option value='$i' $sl> ";
			echo $_YMD_thmon[$i];
		}
	?></select>
<select name ="<?php echo $formname?>_yea" id="<?php  echo $localid?>_yea"><?php 
	if ($isallownonspec!="no") {
		echo "<option value='' >ไม่ระบุ";
	}

		for ($i=$_XSTARTY2; $i <= $_XENDY2; $i++){
			$sl = "";
			$sw=(@date("Y",$tim) );
			//echo "$sw==$i";
			if ($sw == $i) {
				$sl="selected";
			}
			print "<option value='$i' $sl>".($i+543);
		}
	?></select>
	<img src="<?php  echo $dcrURL;?>/neoimg/IMPITEM.GIF" width=16 height=16 style="cursor: hand; cursor: pointer;" alt="ตั้งวันที่ปัจจุบัน" border=0
	onclick="<?php  echo $localid?>_today()"	> 	
	<a href="javascript:NewCssCal('<?php  echo $localid;?>','ddmmyyyy','arrow')"><img src="<?php  echo $dcrURL?>js/datepicker/images/cal.gif" width="16" height="16" alt="Pick a date" border=0></a>

<SCRIPT LANGUAGE="JavaScript">
	<!--
		function <?php  echo $localid?>_today() {
			var d = new Date();
			var curr_date = d.getDate();
			var curr_month = d.getMonth();
			var curr_year = d.getFullYear();
			tmp=getobj('<?php  echo $localid?>_dat');
			for (i=0;i<tmp.options.length;i++) {
				if (tmp.options[i].value==curr_date) {
					tmp.options[i].selected=true
				}
			}
			tmp=getobj('<?php  echo $localid?>_mon');
			for (i=0;i<tmp.options.length;i++) {
				if (tmp.options[i].value==curr_month+1) {
					tmp.options[i].selected=true
				}
			}
			tmp=getobj('<?php  echo $localid?>_yea');
			for (i=0;i<tmp.options.length;i++) {
				if (tmp.options[i].value==curr_year) {
					tmp.options[i].selected=true
				}
			}
		}
	//-->
	</SCRIPT>
<?php 
		return $localid;
}

?>