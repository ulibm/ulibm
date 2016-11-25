<?php 
function form_quickedit($kid,$oldval,$fftmode) {
	//echo "form_quickedit($kid,$oldval,$fftmode)"; return;
	global $_MSTARTY;
	global $_MENDY;
	global $dcrURL;
	global $thaimonstr;
	global $fixform_editor_i_colorpicker_initialized;

	global $host;
	global $user;
	global $passwd;

$oldval=stripslashes($oldval);
//$oldval=stripslashes($oldval);
$kid_ID="kid".randid();
 //type=addcontrol,text,readonlytext,password,longtext,yesno,number,autotime,list:,foreign:,medtext,verylongtext,checkbox
 //linkout:../view.php?valid=[value-id],_blank
//foreign:DB-name,TABLE-name,REF-key,FIELD-value
	//printr($val);
	if ($fftmode=="year")	 {
		$tmptype="";
		for ($i=$_MSTARTY;$i<=$_MENDY;$i++) {
			$tmptype.=",$i";
		}
		$tmptype=trim($tmptype,',');
		$fftmode="list:,$tmptype";
	}	
	if ($fftmode=="month")	 {
		echo "<select name='$kid'>";
		echo "<option value='' >-</option>";		
		for ($i=1;$i<=12;$i++) {
		  $sl="";
			if ($i==floor($oldval)) {
				 $sl="selected";
			}
			echo "<option value='$i' $sl>".$thaimonstr[$i]."</option>";
		}
		echo "</select>";
	}	
	if ($fftmode=="day")	 {
		echo "<select name='$kid'>";
		echo "<option value='' >-</option>";
		for ($i=1;$i<=31;$i++) {
		  $sl="";
			if ($i==floor($oldval)) {
				 $sl="selected";
			}
			echo "<option value='$i' $sl>".$i."</option>";
		}
		echo "</select>";
	}	
	if ($fftmode=="date")	 {
		if (floor($oldval)==0) {
			$oldval=1;
		}
		form_pickdate("$kid",$oldval);
		//use form_pickdt_get() later yourself
	}
	if ($fftmode=="html")	 {
		html_htmlareajs();
		echo "<TEXTAREA NAME='$kid' style=\"width: 450px; height: 400px;\">$oldval</TEXTAREA>";
		html_htmlarea_gen("$kid");
	}
	if ($fftmode=="smallhtml")	 {
		html_htmlareajs();
		echo "<TEXTAREA NAME='$kid' style=\"width: 450px; height: 200px;\">$oldval</TEXTAREA>";
		html_htmlarea_gen("$kid");
	}
	if ($fftmode=="text")	 {
		$oldval=str_replace('"',"&quot;",$oldval);
		echo "<INPUT TYPE='text' NAME='$kid' value=\"".($oldval)."\" size=35 >";
	}
	if ($fftmode=="year")	 {
		echo "<INPUT TYPE='text' NAME='$kid' value='".($oldval)."' size=35 >";
	}
	if ($fftmode=="readonlytext")	 {
		echo "<INPUT TYPE='hidden' NAME='$kid' value='".($oldval)."' size=35 > $oldval";
	}	
	if ($fftmode=="readonlytext_base64")	 {
		echo "<INPUT TYPE='hidden' NAME='$kid' value='".base64_encode($oldval)."' > $oldval";
	}	
	if ($fftmode=="password")	 {
		echo "<INPUT TYPE='password' NAME='$kid' value='".($oldval)."' size=35 >";
	}
	if ($fftmode=="medtext")	 {
		$oldval=str_replace('</TEXTAREA>','&lt;/TEXTAREA>',$oldval);
		echo "<TEXTAREA NAME='$kid' ROWS=4 COLS=40 >".($oldval)."</TEXTAREA>";
	}
	if ($fftmode=="longtext")	 {
		$oldval=str_replace('</TEXTAREA>','&lt;/TEXTAREA>',$oldval);
		echo "<TEXTAREA NAME='$kid' ROWS=7 COLS=40 >".($oldval)."</TEXTAREA>";
	}
	if ($fftmode=="verylongtext")	 {
		$oldval=str_replace('</TEXTAREA>','&lt;/TEXTAREA>',$oldval);
		echo "<TEXTAREA NAME='$kid' ROWS=14 COLS=40 style='width:100%'>".($oldval)."</TEXTAREA>";
	}
	if ($fftmode=="color")	 {
		$oldval=trim($oldval,'#');
		if ($fixform_editor_i_colorpicker_initialized=="") {
			$fixform_editor_i_colorpicker_initialized="yes";
			?> <link rel="stylesheet" href="<?php  echo $dcrURL?>js/colorpicker/COLOURloversColorPicker.css" type="text/css" media="all" /> 
<script type="text/JavaScript" src="<?php  echo $dcrURL?>js/colorpicker/COLOURloversColorPicker.php?fake=colpicker.js"></script>
<div id="CLCP" class="CLCP"></div>
<?php }?>
<input name="<?php echo $kid?>" ID="<?php echo $kid_ID?>" style="width: 100px; border-left-width:15px; border-style:solid;" maxlength="6" value="<?php  echo $oldval?>" />
<a href="JavaScript:_whichField='<?php echo $kid_ID?>';_CLCPinitHex='<?php  echo $oldval?>';CLCPshowPicker({_hex: document.getElementById('<?php echo $kid_ID?>').value});"><?php  echo getlang("เลือกสี::l::Pick color");?></a>

<script type="text/JavaScript">
  _whichField = "<?php echo $kid_ID?>";
  CLCPHandler = function(_hex) {
    // This function gets called by the picker when the sliders are being dragged. The variable _hex contains the current hex value from the picker
    // This code serves as an example only, here we use it to do three things:
    // Here we simply drop the variable _hex into the input field, so we can see what the hex value coming from the picker is:
        document.getElementById(_whichField).value = _hex;
    // Here is where we color the BG of a div to preview the color:
		document.getElementById(_whichField).style.borderColor = ("#" + _hex);
    // Giving you control over this function really puts the reigns in your hands. Rewrite this function as you see fit to really take control of this color picker.
  }
  // Settings:
  _CLCPdisplay = "none"; // Values: "none", "block". Default "none"
  _CLCPisDraggable = true; // Values: true, false. Default true
  _CLCPposition = "absolute"; // Values: "absolute", "relative". Default "absolute"
  _CLCPinitHex = "<?php  echo $oldval?>"; // Values: Any valid hex value. Default "ffffff"
  CLCPinitPicker();
</script><?php 
		/*
?>
		<SELECT NAME="<?php echo $kid?>" >
			<?php 
		$coldata=explode(',','#FFFFFF,#000000,#003300,#006600,#009900,#00CC00,#00FF00,#000033,#003333,#006633,#009933,#00CC33,#00FF33,#000066,#003366,#006666,#009966,#00CC66,#00FF66,#000099,#003399,#006699,#009999,#00CC99,#00FF99,#0000CC,#0033CC,#0066CC,#0099CC,#00CCCC,#00FFCC,#0000FF,#0033FF,#0066FF,#0099FF,#00CCFF,#00FFFF,#330000,#333300,#336600,#339900,#33CC00,#33FF00,#330033,#333333,#336633,#339933,#33CC33,#33FF33,#330066,#333366,#336666,#339966,#33CC66,#33FF66,#330099,#333399,#336699,#339999,#33CC99,#33FF99,#3300CC,#3333CC,#3366CC,#3399CC,#33CCCC,#33FFCC,#3300FF,#3333FF,#3366FF,#3399FF,#33CCFF,#33FFFF,#660000,#663300,#666600,#669900,#66CC00,#66FF00,#660033,#663333,#666633,#669933,#66CC33,#66FFCC,#660066,#663366,#666666,#669966,#66CC66,#66FF66,#660099,#663399,#666699,#669999,#66CC99,#66FF99,#6600CC,#6633CC,#6666CC,#6699CC,#66CCCC,#66FFCC,#6600FF,#6633FF,#6666FF,#6699FF,#66CCFF,#66FFFF,#990000,#993300,#996699,#999900,#99CC00,#99FF00,#990033,#993333,#996633,#999933,#99CC33,#99FF33,#990066,#993366,#996666,#999966,#99CC66,#99FF66,#990099,#993399,#996699,#999999,#99CC99,#99FF99,#9900CC,#9933CC,#9966CC,#9999CC,#99CCCC,#99FFCC,#9900FF,#9933FF,#9966FF,#9999FF,#99CCFF,#99FFFF,#CC0000,#CC3300,#CC6600,#CC9900,#CCCC00,#CCFF00,#CC0033,#CC3333,#CC6633,#CC9933,#CCCC33,#CCFF33,#CC0066,#CC3366,#CC6666,#CC9966,#CCCC66,#CCFF66,#CC0099,#CC3399,#CC6699,#CC9999,#CCCC99,#CCFF99,#CC00CC,#CC33CC,#CC66CC,#CC99CC,#CCCCCC,#CCFFCC,#CC00FF,#CC33FF,#CC66FF,#CC99FF,#CCCCFF,#CCFFFF,#FF0000,#FF3300,#FF6600,#FF9900,#FFCC00,#FFFF00,#FF0033,#FF3333,#FF6633,#FF9933,#FFCC33,#FFFF33,#FF0066,#FF3366,#FF6666,#FF9966,#FFCC66,#FFFF66,#FF0099,#FF3399,#FF6699,#FF9999,#FFCC99,#FFFF99,#FF00CC,#FF33CC,#FF66CC,#FF99CC,#FFCCCC,#FFFFCC,#FF00FF,#FF33FF,#FF66FF,#FF99FF,#FFCCFF,#FFFFFF,#DADADA,#C3C3C3,#A2A2A2,#838383,#616161,#3C3C3C,#1D1D1D');
		reset ($coldata); 
				while (list ($lkey, $lval) = each ($coldata)) { 
					$select="";
					if ($lval==$oldval) {
						$select=" selected ";
					}
				   echo "<OPTION VALUE='$lval' $select style='background-color:$lval;'>$lval"; 
				} 	
		?>
		</SELECT><?php 
			*/
	}
	if ($fftmode=="yesno")	 {
		if (strtolower($oldval)=="yes") {
			$defyes="checked";
			$defno=" ";
		} else {
			$defyes=" ";
			$defno="checked";
		}
		echo "<label><INPUT TYPE='radio' NAME='$kid' value='yes' $defyes style='border-width: 0' > ".getlang("ใช่::l::Yes")."</label> &nbsp;";
		echo "<label><INPUT TYPE='radio' NAME='$kid' value='no' $defno style='border-width: 0'> ".getlang("ไม่::l::No")."</label> &nbsp;";

	}
	
	if ($fftmode=="checkbox")	 {
		if (strtolower($oldval)=="yes") {
			$defyes="checked";
			$defno=" ";
		} else {
			$defyes=" ";
			$defno="checked";
		}
		echo "<INPUT TYPE='checkbox' NAME='$kid'  $defyes style='border-width: 0' >";
	}	
	if ($fftmode=="number")	 {
		echo "<INPUT TYPE='text' NAME='$kid' value='$oldval' size=20 style='text-align:right' >";
	}
	if ($fftmode=="autotime")	 {
		echo "<INPUT TYPE='hidden' NAME='$kid' value='".time()."'>".ymd_datestr(time());
	}

	$tmpchk=substr($fftmode,0,5);
	if ($tmpchk=="list:") {
		$listdat=substr($fftmode,5);
		$listdata=explode(',',$listdat);
		//print_r($listdata);
		if (@count($listdata)>5) {
		?>
		<SELECT NAME="<?php echo $kid?>" ID='<?php echo $kid_ID?>'>
			<?php 
		reset ($listdata); 
				while (list ($lkey, $lval) = each ($listdata)) { 
					$select="";
					if ($lval==$oldval) {
						$select=" selected ";
					}
				   echo "<OPTION VALUE='$lval' $select>$lval"; 
				} 	
		?>
		</SELECT><?php 
		} else { // option radio instead
		 $listdataclone=$listdata;
		@reset($listdata); 
		    $ilistitem=0;
				while (list ($lkey, $lval) = each ($listdata)) { 
				  $ilistitem++;
				  $select="";
				  if ($ilistitem==1 && !in_array($oldval,$listdataclone)) {
				     //force 1st item
				     $select=" selected checked ";
				  } else {
					if ($lval==$oldval) {
						$select=" selected checked ";
					}
				  }
				   echo "<label style=\"border: solid 1px transparent;\"
				   onmouseover=\"this.style.border='#888888 solid 1px';\"
				   onmouseout=\"this.style.border='transparent solid 1px';\"				   
				   onclick=\"this.style.border='transparent solid 1px'; return true;\"
				   ><input type=radio name='$kid' VALUE='$lval' $select>$lval</label> "; 
				} 	
		}
	}
	$tmpchk=substr($fftmode,0,8);
	if ($tmpchk=="foreign:") {
		$listdat=substr($fftmode,8);
		$listdata=explode(',',$listdat);

		if ($listdata[5]=="") {
			 $listdata[5]=$listdata[3];
		}
		$localconn=tmq_connect($host, $user, $passwd,true); 
		//echo "tmq_select_db($listdata[0], $localconn);";
		$localconn=tmq_select_db($listdata[0], $localconn);

		$cdefault=tmq("select $listdata[2],$listdata[3] from $listdata[1] where $listdata[2]='$oldval' order by $listdata[5]",false,$localconn);

		?>
		<SELECT NAME="<?php echo $kid?>" ID='<?php echo $kid_ID?>'>
			<?php 
			if (tmq_num_rows($cdefault)==1) {
				$cdefault=tmq_fetch_array($cdefault);
			   echo "<OPTION VALUE='".$oldval."' selected>" . getlang($cdefault[$listdata[3]]); 
			}
			if ($listdata[4]=="allowblank") {
				if ($listdata[6]=="") {
					$listdata[6]=getlang("ไม่กำหนด::l::Not specific");
				}
			   echo "<OPTION VALUE='' >" . $listdata[6]; 
			}

			$call=tmq("select $listdata[2],$listdata[3] from $listdata[1] where $listdata[2]<>'$oldval' order by $listdata[5]",false,$localconn);
			while ($callr=tmq_fetch_array($call)) { 
			   echo "<OPTION VALUE='".$callr[$listdata[2]]."'>".getlang($callr[$listdata[3]]); 
			} 	
		?>
		</SELECT><?php 
	}
?>

	<?php 
	return $kid_ID;
}
?>