<?php 
function fixform_editor_i($val,$tb) {
	global $fftmode;
	global $thaimonstr;
	global $useradminid;
	global $fixform_editor_i_colorpicker_initialized;
	global $ffe_limitsql;
	global $_MSTARTY;
	global $_MENDY;
	global $dcrURL;
	global $host;
	global $user;
	global $passwd;
	global $dcrs;
	global $ffteditid; //first use on globalupload:: && singlefile

	global $kid_ID; // share last kid_ID defined

	//printr($val);

		$kid="ffdat[$val[field]]";
	if ($val[fieldtype]=="addcontrol")	 {
		if ($fftmode=="add") {
			echo "<INPUT TYPE='hidden' NAME='$kid' value='$val[defval]' >";
			return;
		}
		if ($fftmode=="edit") {
			return;
		}
	}
	$kid_ID=$kid."-".randid();
	$kid_IDjs=str_remspecialsign($kid_ID);
	?>
		<TR>
		<TD class=table_head><LABEL FOR='<?php  echo $kid_ID;?>'><?php  echo getlang($val[text])?></LABEL></TD>
		<TD class=table_td> <?php 
	if ($val[fieldtype]=="color")	 {
		$val[defval]=trim($val[defval],'#');
		if ($fixform_editor_i_colorpicker_initialized=="") {
			$fixform_editor_i_colorpicker_initialized="yes";
			?> <link rel="stylesheet" href="<?php  echo $dcrURL?>js/colorpicker/COLOURloversColorPicker.css" type="text/css" media="all" />
<script type="text/JavaScript" src="<?php  echo $dcrURL?>js/colorpicker/COLOURloversColorPicker.php?fake=colpicker.js"></script>
<div id="CLCP" class="CLCP"></div>
<?php }?>
<input name="<?php echo $kid?>" ID="<?php echo $kid_ID?>" style="width: 100px; border-left-width:15px; border-style:solid;" maxlength="6" value="<?php  echo $val[defval]?>" />
<a href="JavaScript:_whichField='<?php echo $kid_ID?>';_CLCPinitHex='<?php  echo $val[defval]?>';CLCPshowPicker({_hex: document.getElementById('<?php echo $kid_ID?>').value});"><?php  echo getlang("เลือกสี::l::Pick color");?></a>

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
  _CLCPinitHex = "<?php  echo $val[defval]?>"; // Values: Any valid hex value. Default "ffffff"
  CLCPinitPicker();
</script>

<?php 
		/*
?>
		<SELECT NAME="<?php echo $kid?>" ID='<?php echo $kid_ID?>'>
			<?php 
		$coldata=explode(',','#FFFFFF,#000000,#003300,#006600,#009900,#00CC00,#00FF00,#000033,#003333,#006633,#009933,#00CC33,#00FF33,#000066,#003366,#006666,#009966,#00CC66,#00FF66,#000099,#003399,#006699,#009999,#00CC99,#00FF99,#0000CC,#0033CC,#0066CC,#0099CC,#00CCCC,#00FFCC,#0000FF,#0033FF,#0066FF,#0099FF,#00CCFF,#00FFFF,#330000,#333300,#336600,#339900,#33CC00,#33FF00,#330033,#333333,#336633,#339933,#33CC33,#33FF33,#330066,#333366,#336666,#339966,#33CC66,#33FF66,#330099,#333399,#336699,#339999,#33CC99,#33FF99,#3300CC,#3333CC,#3366CC,#3399CC,#33CCCC,#33FFCC,#3300FF,#3333FF,#3366FF,#3399FF,#33CCFF,#33FFFF,#660000,#663300,#666600,#669900,#66CC00,#66FF00,#660033,#663333,#666633,#669933,#66CC33,#66FFCC,#660066,#663366,#666666,#669966,#66CC66,#66FF66,#660099,#663399,#666699,#669999,#66CC99,#66FF99,#6600CC,#6633CC,#6666CC,#6699CC,#66CCCC,#66FFCC,#6600FF,#6633FF,#6666FF,#6699FF,#66CCFF,#66FFFF,#990000,#993300,#996699,#999900,#99CC00,#99FF00,#990033,#993333,#996633,#999933,#99CC33,#99FF33,#990066,#993366,#996666,#999966,#99CC66,#99FF66,#990099,#993399,#996699,#999999,#99CC99,#99FF99,#9900CC,#9933CC,#9966CC,#9999CC,#99CCCC,#99FFCC,#9900FF,#9933FF,#9966FF,#9999FF,#99CCFF,#99FFFF,#CC0000,#CC3300,#CC6600,#CC9900,#CCCC00,#CCFF00,#CC0033,#CC3333,#CC6633,#CC9933,#CCCC33,#CCFF33,#CC0066,#CC3366,#CC6666,#CC9966,#CCCC66,#CCFF66,#CC0099,#CC3399,#CC6699,#CC9999,#CCCC99,#CCFF99,#CC00CC,#CC33CC,#CC66CC,#CC99CC,#CCCCCC,#CCFFCC,#CC00FF,#CC33FF,#CC66FF,#CC99FF,#CCCCFF,#CCFFFF,#FF0000,#FF3300,#FF6600,#FF9900,#FFCC00,#FFFF00,#FF0033,#FF3333,#FF6633,#FF9933,#FFCC33,#FFFF33,#FF0066,#FF3366,#FF6666,#FF9966,#FFCC66,#FFFF66,#FF0099,#FF3399,#FF6699,#FF9999,#FFCC99,#FFFF99,#FF00CC,#FF33CC,#FF66CC,#FF99CC,#FFCCCC,#FFFFCC,#FF00FF,#FF33FF,#FF66FF,#FF99FF,#FFCCFF,#FFFFFF,#DADADA,#C3C3C3,#A2A2A2,#838383,#616161,#3C3C3C,#1D1D1D');
		reset ($coldata); 
				while (list ($lkey, $lval) = each ($coldata)) { 
					$select="";
					if ($lval==$val[defval]) {
						$select=" selected ";
					}
				   echo "<OPTION VALUE='$lval' $select style='background-color:$lval;'>$lval"; 
				} 	
		?>
		</SELECT><?php 
			*/
	}
	if ($val[fieldtype]=="frm_itemplace")	 {
		frm_itemplace($kid,$val[defval],"yes","",$kid_ID);
	}	
	if ($val[fieldtype]=="frm_restype")	 {
		frm_restype($kid,$val[defval],"YES",$kid_ID);
	}	
	if ($val[fieldtype]=="month")	 {
		?><select name="<?php echo $kid;?>" >
		<?php for($i=1;$i<=12;$i++) {
		$sl="";
		if ($val[defval]==$i) {
		 $sl=" selected checked ";
		};
		 echo "<option value='$i' $sl>$i. ".$thaimonstr[$i];
		}?>
		</select><?php
	}	
	if ($val[fieldtype]=="text")	 {
		$val[defval]=str_replace('"','&quot;',$val[defval]);
		$val[defval]=stripslashes($val[defval]);
		echo "<INPUT TYPE='text' NAME='$kid' value=\"$val[defval]\" size=35 ID='$kid_ID'>";
	}	

	$tmpchk=substr($val[fieldtype],0,12);
	if ($tmpchk=="listimgfile:") {
		$listdat=substr($val[fieldtype],13);
		//echo "[$dcrs$listdat]";
		$listdata=fso_listfile($dcrs."$listdat");
		//print_r($listdata);
		$tmpchk=substr($val[addon],0,16);
		//echo $tmpchk;
		?>
		<SELECT NAME="<?php echo $kid?>" ID='<?php echo $kid_ID?>' <?php 
		if ($tmpchk=="list-previewimg:") {
			echo " onchange=\"ffedit_listpreview_$kid_IDjs(this)\" ";
			$listpreviewdata=explode(',',substr($val[addon],16));
		}	
		?>>
			<?php 
		reset ($listdata); 
				while (list ($lkey, $lval) = each ($listdata)) { 
					$ext=explode(".",$lval); 
					$ext=strtolower($ext[count($ext)-1]);
					if ($ext=="png" || $ext=="jpg"|| $ext=="gif") {
						$select="";
						if ($lval==$val[defval]) {
							$select=" selected ";
						}
					   echo "<OPTION VALUE='$lval' $select>$lval"; 
					}
				} 	
		?>
		</SELECT><?php 
		if ($tmpchk=="list-previewimg:") {
			if ($listpreviewdata[1]==0) {
				$listpreviewdata[1]=32;
			}
			//printr($listpreviewdata);
			?><div ID="ffedit_listpreviewform_<?php echo $kid_IDjs;?>"></div>
			<SCRIPT LANGUAGE="JavaScript">
			<!--
			function ffedit_listpreview_<?php echo $kid_IDjs;?>(wh) {
				getobj("ffedit_listpreviewform_<?php echo $kid_IDjs;?>").innerHTML="<img src='<?php  echo $listpreviewdata[0]?>/"+wh.value+"<?php  echo $listpreviewdata[2]?>' border=1 align=absmiddle width='<?php  echo $listpreviewdata[1]?>'>"
			}
			ffedit_listpreview_<?php echo $kid_IDjs;?>(getobj("<?php  echo $kid_ID;?>"));
			//-->
			</SCRIPT>
			<?php 
		}

	}
   
	if ($val[fieldtype]=="printtemplate_pos")	 {
		global $pid;
		$val[defval]=str_replace('"','&quot;',$val[defval]);
		$val[defval]=stripslashes($val[defval]);
		echo "<INPUT TYPE='text' NAME='$kid' value=\"$val[defval]\" size=35 ID='$kid_ID'>";
		?><a href="javascript:void(null);" onclick="window.open('<?php  echo $dcrURL;?>library.printtemplate/_pospicker.php?pid=<?php  echo $pid;?>&thisid=<?php  echo $ffteditid;?>&pjs=<?php  echo $kid_ID?>','printtemplate_pos','');">
		<?php  echo getlang("เลือกตำแหน่ง::l::Pick Location");
		?></a><?php 
	}	
	if ($val[fieldtype]=="memcard_pos")	 {
		global $pid;
		$val[defval]=str_replace('"','&quot;',$val[defval]);
		$val[defval]=stripslashes($val[defval]);
		echo "<INPUT TYPE='text' NAME='$kid' value=\"$val[defval]\" size=35 ID='$kid_ID'>";
		?><a href="javascript:void(null);" onclick="window.open('<?php  echo $dcrURL;?>library.memcard/_pospicker.php?pid=<?php  echo $pid;?>&thisid=<?php  echo $ffteditid;?>&pjs=<?php  echo $kid_ID?>','printtemplate_pos','');">
		<?php  echo getlang("เลือกตำแหน่ง::l::Pick Location");
		?></a><?php 
	}	
	if ($val[fieldtype]=="yesno")	 {
		$val[defval]=str_replace('"','&quot;',$val[defval]);
		$val[defval]=stripslashes($val[defval]);
		if (strtoupper($val[defval])=="YES") {
			$_localtmp_y=" checked ";
			$_localtmp_n="";
		} else {
			$_localtmp_y="";
			$_localtmp_n=" checked ";
		}
		echo "<label style='color: darkgreen;'><INPUT TYPE='radio' NAME='$kid' value='YES'  ID='$kid_ID' $_localtmp_y> ".getlang("ใช่::l::Yes")."</label>";
		echo " &nbsp; ";
		echo "<label style='color: darkred;'><INPUT TYPE='radio' NAME='$kid' value='NO' $_localtmp_n> ".getlang("ไม่ใช่::l::No")."</label>";
		//echo "<INPUT TYPE='text' NAME='$kid' value=\"$val[defval]\" size=35 ID='$kid_ID'>";
	}	
	if ($val[fieldtype]=="1or2")	 {
		$val[defval]=str_replace('"','&quot;',$val[defval]);
		$val[defval]=stripslashes($val[defval]);
		if (strtoupper($val[defval])=="1" || $val[defval]=="") {
			$_localtmp_y=" checked ";
			$_localtmp_n="";
		} else {
			$_localtmp_y="";
			$_localtmp_n=" checked ";
		}
		echo "<label style='color: darkgreen;'><INPUT TYPE='radio' NAME='$kid' value='1'  ID='$kid_ID' $_localtmp_y> 1 </label>";
		echo " &nbsp; ";
		echo "<label style='color: darkred;'><INPUT TYPE='radio' NAME='$kid' value='2' $_localtmp_n> 2 </label>";
		//echo "<INPUT TYPE='text' NAME='$kid' value=\"$val[defval]\" size=35 ID='$kid_ID'>";
	}
	if ($val[fieldtype]=="html")	 {
		html_htmlareajs();
		$val[defval]=stripslashes($val[defval]);
		echo "<TEXTAREA NAME='$kid' style=\"width:500px; height: 400px;\"  ID='$kid_ID'>$val[defval]</TEXTAREA>";
		html_htmlarea_gen("$kid");

		$tmpchk=substr($val[addon],0,14);
		if ($tmpchk=="globalupload::") {
			$globaluploadkey=substr($val[addon],14);
			if ($globaluploadkey=="") {
				$globaluploadkey="$tb-$ffteditid";
			}
			//echo "key=$globaluploadkey$fftmode;";
			if ($fftmode=="add") {
				$globaluploadkey="TEMP";
			}
			frm_globalupload($globaluploadkey,$kid);
		}
	}	
	if ($val[fieldtype]=="multiplefile")	 {
		$globaluploadkey=substr($val[addon],14);
		if ($globaluploadkey=="") {
			$globaluploadkey="$tb-$ffteditid";
		}
		//echo "key=$globaluploadkey$fftmode;";
		if ($fftmode=="add") {
			$globaluploadkey="TEMP";
		}
		frm_globalupload($globaluploadkey,$kid);
	}
	
	if ($val[fieldtype]=="year")	 {
		$tmptype="";
		for ($i=$_MSTARTY;$i<=$_MENDY;$i++) {
			$tmptype.=",$i";
		}
		$tmptype=trim($tmptype,',');
		$val[fieldtype]="list:$tmptype";
	}	
	if ($val[fieldtype]=="readonlytext")	 {
		echo "<INPUT TYPE='hidden' NAME='$kid' value='$val[defval]' size=35 ID='$kid_ID'> $val[defval]";
	}	
	if ($val[fieldtype]=="password")	 {
		//value='$val[defval]' 
		echo "<INPUT TYPE='hidden' NAME='$kid' value='passdata::passdata_$val[field]'>";
		echo "<INPUT TYPE='password' NAME='passdata_$val[field]' size=20 ID='$kid_ID' onkeyup=\"localcheckpassword$kid_IDjs(); return true;\"> ".getlang("ปล่อยว่างหากไม่ต้องการเปลี่ยน::l::Left blank to unchange");
		?>
		<div ID='<?php echo $kid_ID;?>_isthaiwarn' style='display:none; color: darkred;' class=smaller2><?php echo getlang("คำเตือน: ตรวจพบตัวอักษรภาษาไทย::l::Warning: thai character detected");?></div>
		<script>
   function localcheckpassword<?php echo $kid_IDjs;?>() {
      tmp=getobj('<?php echo $kid_ID;?>');
      tmpdsp=getobj('<?php echo $kid_ID;?>_isthaiwarn');
      tmpstr=tmp.value+"";
      //console.log(tmpstr);
      var orgi_text="ๅภถุึคตจขชๆไำพะัีรนยบลฃฟหกดเ้่าสวงผปแอิืทมใฝ๑๒๓๔ู฿๕๖๗๘๙๐ฎฑธํ๊ณฯญฐฅฤฆฏโฌ็๋ษศซฉฮฺ์ฒฬฦ";
      var str_length=tmpstr.length;
      var str_length_end=str_length-1;
      var isThai=false;
      var Char_At="";
      for(i=0;i<str_length;i++){
            Char_At=tmpstr.charAt(i);
            if(orgi_text.indexOf(Char_At)!=-1){
            isThai=true;
         }
      }  
      if (isThai==true) {
         tmpdsp.style.display="block";
      } else {
         tmpdsp.style.display="none";
      }
	}
		</script>
		<?php
	}
	if ($val[fieldtype]=="docdelivery_users")	 {
		$soffice=tmq("select * from docdelivery_office order by ordr");
		?>
		<input type="hidden" name="<?php  echo $kid;?>" value="docdellb::<?php 
			$localrandid="CBDD".randid();
		echo $localrandid;
		?>"><table width=100% cellpadding=0 cellspacing=0 border=0>
		<?php 
		//get old val
		$tmpspers=stripslashes($val[defval]);
		$tmpspers=unserialize($tmpspers);
		//printr($tmpspers);
		while ($roffice=tfa($soffice)) {
			$spers_sql="select * from docdelivery_person where office='$roffice[id]'";
			$spers=tmq($spers_sql,false);
			if (tnr($spers)==0) {
				continue;
			}
			echo "<tr><td class=table_head>";
			echo getlang($roffice[name]);	
			?> 
			<img src="../neoimg/checkbox-on.png" width="16" height="16" border="0" alt="" onclick="<?php 
			while ($rpers=tfa($spers)) {
				echo "tmp=getobj('localcb$rpers[id]'); tmp.checked=true;";
			}
			?>">  
			<img src="../neoimg/checkbox-off.png" width="16" height="16" border="0" alt="" onclick="<?php 
			$spers=tmq($spers_sql,false);
			while ($rpers=tfa($spers)) {
				echo "tmp=getobj('localcb$rpers[id]'); tmp.checked=false;";
			}
			?>">
			<?php 
			echo "</td></tr>";
			echo "<tr><td class=table_td>";
			$spers=tmq($spers_sql,false);
			while ($rpers=tfa($spers)) {
				echo "<nobr><label><input type=checkbox name='$localrandid"."[$rpers[loginid]]' value='yes' ID='localcb$rpers[id]' ";
				if ($tmpspers[$rpers[loginid]]=="yes") {
					echo "checked";
				}
				echo "> ";
				echo get_library_name($rpers[loginid]);
				echo "</label><nobr><wbr> ";
			}
			echo "</td></tr>";
		}
		?></td>
		</tr>
		</table><?php 
	}
	if ($val[fieldtype]=="longtext")	 {
		$val[defval]=str_replace('"','&quot;',$val[defval]);
		$val[defval]=stripslashes($val[defval]);
		$val[defval]=str_replace('</TEXTAREA>','&lt;/TEXTAREA>',$val[defval]);
		echo "<TEXTAREA NAME='$kid' ROWS=4 COLS=40 ID='$kid_ID'>$val[defval]</TEXTAREA>";
	}
	if ($val[fieldtype]=="switchsingle")	 {
		if ($val[defval]=="yes") {
			$defyes="checked";
			$defno=" ";
		} else {
			$defyes=" ";
			$defno="checked";
		}
		echo "<label style='color: darkgreen; font-weight:bold;'><INPUT TYPE='radio' NAME='switchsingle_$val[field]' value='yes' $defyes style='border-width: 0' ID='$kid_ID'> ".getlang("ใช่::l::Yes")."</label> &nbsp;";
		echo "<label style='color: darkred; font-weight:bold;'><INPUT TYPE='radio' NAME='switchsingle_$val[field]' value='no' $defno style='border-width: 0'> ".getlang("ไม่::l::No")."</label> &nbsp;";
		echo "<INPUT TYPE='hidden' NAME='$kid' value='switchsi::switchsingle_$val[field]'>";

	}
	if ($val[fieldtype]=="special_libmenu")	 {
		$callpdb=tmq_dump("library_modules_cate","code","name");
		//printr($callpdb);
		$cdefault=tmq("select * from library_modules where code='$val[defval]' ",false);
?>
		<SELECT NAME="<?php echo $kid?>" ID='<?php echo $kid_ID?>'>
			<?php 
			if (tmq_num_rows($cdefault)==1) {
				$cdefault=tmq_fetch_array($cdefault);
			   echo "<OPTION VALUE='".$val[defval]."' selected>" .getlang($callpdb[$cdefault[nested]])." ->".getlang($cdefault[name]); 
			}
			   echo "<OPTION VALUE='' >" . getlang("ไม่กำหนด::l::Not specific");
			$call=tmq("select * from library_modules where nested<>'' and url<>'' order by nested",false);
			while ($callr=tmq_fetch_array($call)) { 
				//getlang($callpdb[$callr[nested]])
			   echo "<OPTION VALUE='".$callr[code]."'>".getlang($callpdb[$callr[nested]])." ->".getlang($callr[name]); 
			} 	
		?>
		</SELECT><?php 	}
	if ($val[fieldtype]=="number")	 {
		echo "<INPUT TYPE='text' NAME='$kid' value='$val[defval]' size=20 style='text-align:right' ID='$kid_ID' >";
	}
	if ($val[fieldtype]=="special_eventsreg_regdata")	 {
	   //printr($val);
	   $esub=tmq("select * from eventsreg_sub  where pid=$val[special] order by ordr");
   if (tnr($esub)==0) {
		echo "<INPUT TYPE='hidden' NAME='$kid' value='$val[defval]'  ID='$kid_ID' > --";
   } else {
 		echo "<INPUT TYPE='hidden' NAME='$kid' value='special_eventsreg_regdata' '$val[defval]'  ID='$kid_ID' >";
     while ($esubr=tfa($esub)) {
         echo "<label>";
         $slstate="";
        // echo ",$esubr[id],";
         $pos = strpos("  ,,,".$val[defval],",$esubr[id],");
         if ($pos === false) {
         } else {
         //if ($regesub[$esubr[id]]!="") {
            $slstate=" selected checked ";
         }
         echo "<input type=checkbox name='special_eventsreg_regdata[]' value='$esubr[id]' $slstate > ";
        // form_quickedit("esub[$i][$esubr[id]]",$_POST["esub$i"],"checkbox");
         echo stripslashes($esubr[name]);
         echo "</label><BR>";
         
      }
   }

	}

	if ($val[fieldtype]=="special_eventsreg_reqdata")	 {
	   //printr($val);
	   $esub=tmq("select * from eventsreg_requests  where pid=$val[special] order by ordr");
   if (tnr($esub)==0) {
		echo "<INPUT TYPE='hidden' NAME='$kid' value='$val[defval]'  ID='$kid_ID' > --";
   } else {
   	echo "<INPUT TYPE='hidden' NAME='$kid' value='special_eventsreg_reqdata' '$val[defval]'  ID='$kid_ID' >";
       while ($esubr=tfa($esub)) {
       
       $req=tmq("select * from eventsreg_requests_sub where pid='$esubr[id]' order by ordr");
       $i=0;
       echo "<b>".getlang($esubr[name])."</b><BR>";
       while ($reqr=tfa($req)) {
          $chkava=tmq("select * from eventsreg_reg where reqdata like '%,$reqr[id],%' ",false);

          echo "<label >";
          $slstate="";
         $pos = strpos("  ,,,".$val[defval],",$reqr[id],");
         //echo ",$val[defval],";
         if ($pos === false) {
         } else {
            $slstate=" checked selected ";
         }

          echo "<input type=radio name='special_eventsreg_reqdata[$esubr[id]]' value='$reqr[id]' $slstate >";
          echo stripslashes($reqr[name]);
          echo "</label>";
          echo "<BR>";
         }
      }
   }

	}
	if ($val[fieldtype]=="date")	 {
		if (floor($val[defval])==0) {
			$val[defval]=1;
		}
		form_pickdate("datdata_$val[field]",$val[defval]);
		echo "<INPUT TYPE='hidden' NAME='$kid' value='datedata::datdata_$val[field]'>";
	}
	if ($val[fieldtype]=="datetime")	 {
		if (floor($val[defval])==0) {
			$val[defval]=1;
		}
		form_pickdatetime("datdata_$val[field]",$val[defval]);
		echo "<INPUT TYPE='hidden' NAME='$kid' value='datedata::datdata_$val[field]'>";
	}
	if ($val[fieldtype]=="autotime")	 {
		echo "<INPUT TYPE='hidden' NAME='$kid' value='".time()."'>".ymd_datestr(time());
	}
	if ($val[fieldtype]=="autoofficer")	 {
		echo "<INPUT TYPE='hidden' NAME='$kid' value='$useradminid'>".get_library_name($useradminid);
	}
	if ($val[fieldtype]=="file")	 {
		echo "<INPUT TYPE='file' NAME='$kid' value=''>";
	}
	//printr($ffteditid);
	if ($val[fieldtype]=="singlefile") {
		if ($ffteditid=='') {
			$ffteditid="TEMP-$useradminid";
		}
		?>
		<iframe width=100% height=25 src="<?php  echo $dcrURL;?>fft_upload.php?table=<?php  echo $tb?>&fid=<?php  echo $val[field]?>&keyid=<?php  echo $ffteditid; ?>" FRAMEBORDER="no" BORDER=0 scrolling=no></iframe>
		<?php 
	}
	if ($val[fieldtype]=="autorun")	 {
		if ($fftmode=="edit") {
			$defvaldsp=substr("00000000000$val[defval]",-6);
			echo "<INPUT TYPE='hidden' NAME='$kid' value='$val[defval]'> <B>$defvaldsp</B>";
		} else {
			$chkold=tmq("select * from $tb where $ffe_limitsql order by floor($val[field]) desc limit 1",false);
			$chkold=tmq_fetch_array($chkold);
			$chkold=floor($chkold[$val[field]])+1;
			$chkolddsp=substr("00000000000$chkold",-6);
			echo "<INPUT TYPE='hidden' NAME='$kid' value='autoruni::'> <B>$chkolddsp</B>";
		}
	}
	$tmpchk=substr($val[fieldtype],0,5);
	if ($tmpchk=="list:") {
		$listdat=substr($val[fieldtype],5);
		$listdata=explode(',',$listdat);
		//print_r($listdata);
		$tmpchk=substr($val[addon],0,16);
		//echo $tmpchk;
		?>
		<SELECT NAME="<?php echo $kid?>" ID='<?php echo $kid_ID?>' <?php 
		if ($tmpchk=="list-previewimg:") {
			echo " onchange=\"ffedit_listpreview_$kid_IDjs(this)\" ";
			$listpreviewdata=explode(',',substr($val[addon],16));
		}	
		?>>
			<?php 
		reset ($listdata); 
				while (list ($lkey, $lval) = each ($listdata)) { 
					$select="";
					if ($lval==$val[defval]) {
						$select=" selected ";
					}
				   echo "<OPTION VALUE='$lval' $select>$lval"; 
				} 	
		?>
		</SELECT><?php 
		if ($tmpchk=="list-previewimg:") {
			if ($listpreviewdata[1]==0) {
				$listpreviewdata[1]=32;
			}
			//printr($listpreviewdata);
			?><div ID="ffedit_listpreviewform_<?php echo $kid_IDjs;?>"></div>
			<SCRIPT LANGUAGE="JavaScript">
			<!--
			function ffedit_listpreview_<?php echo $kid_IDjs;?>(wh) {
				getobj("ffedit_listpreviewform_<?php echo $kid_IDjs;?>").innerHTML="<img src='<?php  echo $listpreviewdata[0]?>/"+wh.value+"<?php  echo $listpreviewdata[2]?>' border=1 align=absmiddle width='<?php  echo $listpreviewdata[1]?>'>"
			}
			ffedit_listpreview_<?php echo $kid_IDjs;?>(getobj("<?php  echo $kid_ID;?>"));
			//-->
			</SCRIPT>
			<?php 
		}	

	}
	if ($val[fieldtype]=="acqn_budget") {
		?>
		<SELECT NAME="<?php echo $kid?>" ID='<?php echo $kid_ID?>'>
			<?php 
			$listdata7a=explode('=',$listdata[7]);
			$localconn=tmq_connect($host, $user, $passwd,true);
			$localconn=tmq_select_db($listdata[0], $localconn);

			if ($val[defval]!="") {
				$cdefault=tmq("select * from acqn_budget where code='$val[defval]' ",false,$localconn);
				if (tmq_num_rows($cdefault)==1) {
					$cdefault=tmq_fetch_array($cdefault);
					$remains=tmq("select sum(pricenet) as cc from acqn_sub where budget='$cdefault[code]' ");
					$remains=tfa($remains);
					$remains=$remains[cc];
					$remains=$cdefault[amnt]-$remains;
					echo "<OPTION VALUE='".$val[defval]."' selected";
					if ($remains<0) {
						echo " style='background-color: #ffe7e6; font-weight:bold;' ";
					}
					echo ">" . getlang($cdefault[name]); 
					echo " (".number_format($remains)."/".number_format($cdefault[amnt]).")";
				}
			}
		   echo "<OPTION VALUE='' >" . getlang("ไม่กำหนด::l::Not specific");
			$call=tmq("select * from acqn_budget where code<>'$val[defval]' and isactive='yes' ",false);
			while ($callr=tmq_fetch_array($call)) { 
				$remains=tmq("select sum(pricenet) as cc from acqn_sub where budget='$callr[code]' ");
				$remains=tfa($remains);
				$remains=$remains[cc];
				$remains=$callr[amnt]-$remains;
				echo "<OPTION VALUE='".$callr[code]."' ";
				if ($remains<0) {
						echo " style='background-color: #ffe7e6; font-weight:bold;' ";
				}
				echo ">".getlang($callr[name]); 
				echo " (".number_format($remains)."/".number_format($callr[amnt]).")";
			}

		?>
		</SELECT><?php 
	}
	$tmpchk=substr($val[fieldtype],0,8);
	if ($tmpchk=="foreign:") {
		$listdat=substr($val[fieldtype],8);
		$listdata=explode(',',$listdat);
		//print_r($listdata);
		$localconn=tmq_connect($host, $user, $passwd,true);
		$localconn=tmq_select_db($listdata[0], $localconn);
		?>
		<SELECT NAME="<?php echo $kid?>" ID='<?php echo $kid_ID?>'>
			<?php 
			$listdata7a=explode('=',$listdata[7]);
			if ($listdata7a[0]==$val[defval]) {
			   echo "<OPTION VALUE='".$listdata7a[0]."' selected>";
			   echo getlang($listdata7a[1]); 
			   if ($listdata[6]=="displaykey") {
   				echo " (".$listdata7a[0].")";
			   }
			} else {
				$cdefault=tmq("select $listdata[2],$listdata[3] from $listdata[1] where $listdata[2]='$val[defval]' order by $listdata[3]",false,$localconn);
				if (tmq_num_rows($cdefault)==1) {
					$cdefault=tmq_fetch_array($cdefault);
				   echo "<OPTION VALUE='".$val[defval]."' selected>" . getlang($cdefault[$listdata[3]]); 
				}
			}
			if ($listdata[4]=="allowblank") {
				if ($listdata[5]=="") {
					$listdata[5]=getlang("ไม่กำหนด::l::Not specific");
				}
			   echo "<OPTION VALUE='' >" . $listdata[5]; 
			}
			$callorderby=$listdata[3];
			if ($listdata[6]=="displaykeyfirst") {
			   $callorderby=$listdata[2];
			}
			$call=tmq("select $listdata[2],$listdata[3] from $listdata[1] where $listdata[2]<>'$val[defval]'  order by $listdata[3]",false,$localconn);
			while ($callr=tmq_fetch_array($call)) { 
			   echo "<OPTION VALUE='".$callr[$listdata[2]]."'>";
			   if ($listdata[6]=="displaykeyfirst") {
   				echo "".$callr[$listdata[2]]."-";
			   }
			   echo getlang($callr[$listdata[3]]); 
			   if ($listdata[6]=="displaykey") {
				echo " (".$callr[$listdata[2]].")";
			   }
			}
			if ($listdata[7]!="") {
				if ($listdata7a[0]!=$val[defval]) {
				   echo "<OPTION VALUE='".$listdata7a[0]."'>".getlang($listdata7a[1]); 
				   if ($listdata[6]=="displaykey") {
					echo " (".$listdata7a[0].")";
				   }
				}
			}
		?>
		</SELECT><?php 
	}

	$tmpchk=substr($val[fieldtype],0,15);
	if ($tmpchk=="foreignwithsub:") {
	  //foreignwithsub:-localdb-,webbox_customlist_cate,id,name:-localdb-,webbox_customlist_catesub,id,name:id,cateid
		$listdat=substr($val[fieldtype],15);
		$subdate=explode(":",$listdat);
		$listdata=explode(',',$subdate[0]);
		$listdatasub=explode(',',$subdate[1]);
		$listdatarelate=explode(',',$subdate[2]);
		//print_r($listdata);
		$localconn=tmq_connect($host, $user, $passwd,true);
		$localconn=tmq_select_db($listdata[0], $localconn);
			  // $oldvals=tmq("select $listdatasub[2],$listdatasub[3] from $listdatasub[1] where $listdatasub[2]='$val[defval]' order by $listdatasub[3]",true);
			   //$oldvals=tfa($oldvals);
		//echo "select $listdata[2],$listdata[3] from $listdata[1] where ".$listdatarelate[0]."='".$oldvals[$listdatarelate[1]]."' order by $listdatasub[3]";
		?><SELECT NAME="<?php echo $kid?>" ID='<?php echo $kid_ID?>'>
			<?php 
			$iscatevalid=tmq("select * from  $listdatasub[1] where $listdatasub[2]='$val[defval]' ",true);
			if ($val[defval]!="" && floor(tnr($iscatevalid))!=0) {
			   $oldvals=tmq("select * from $listdatasub[1] where $listdatasub[2]='$val[defval]' order by $listdatasub[3]");
			   $oldvals=tfa($oldvals);
			   $oldvalsparent=tmq("select $listdata[2],$listdata[3] from $listdata[1] where ".$listdatarelate[0]."='".$oldvals[$listdatarelate[1]]."' order by $listdatasub[3]",false);
			   $oldvalsparent=tfa($oldvalsparent);
			   echo "<OPTION VALUE='".$val[defval]."' selected>".getlang($oldvalsparent[$listdata[3]])." -&gt; ".getlang($oldvals[$listdatasub[3]]); 
			} 
			if ($listdata[4]=="allowblank" || floor(tnr($iscatevalid))==0) {
				if ($listdata[5]=="") {
					$listdata[5]=getlang("ไม่กำหนด::l::Not specific");
				}
			   echo "<OPTION VALUE='' >" . $listdata[5]; 
			}
			$call=tmq("select $listdata[2],$listdata[3] from $listdata[1] where 1  order by $listdata[3]",false,$localconn);
			while ($callr=tmq_fetch_array($call)) { 
            $result=tmq("select * from $listdatasub[1] where  ".$listdatarelate[1]."='".$callr[$listdatarelate[0]]."' ",false);
      		if (tnr($result)==0) {
      		 continue;
      		}
	   		echo "<optgroup label='".getlang($callr[name])."'>";
      		while ($row=tfa($result))
      			{
      			$ID = $row[id];
      			$descr=$row[name];
      			$sl="";
      			if ($fixroom==$row[id]) {$sl="selected";}

      			$descr=getlang($descr);
      			echo "<option value='$ID' $sl>$descr</option>";
      		}
			   echo "</optgroup>";
			}
		?>
		</SELECT><?php 
	}	
	$tmpchk=substr($val[fieldtype],0,9);
	if ($tmpchk=="foreign2:") {
		$listdat=substr($val[fieldtype],9);
		$listdata=explode(',',$listdat,3);
		//print_r($listdata);
		?>
		<SELECT NAME="<?php echo $kid?>" ID='<?php echo $kid_ID?>'>
			<?php 
			$cdefault=tmq("$listdata[2] and  $listdata[0]='$val[defval]' ",false);
			if (tmq_num_rows($cdefault)==1) {
				$cdefault=tmq_fetch_array($cdefault);
			   echo "<OPTION VALUE='".$val[defval]."' selected>" . getlang($cdefault[$listdata[1]])." [".getlang($cdefault[$listdata[0]])."]"; 
			}
			$call=tmq("$listdata[2]",false);
			while ($callr=tmq_fetch_array($call)) { 
			   echo "<OPTION VALUE='".$callr[$listdata[0]]."'>".getlang($callr[$listdata[1]])." [".getlang($callr[$listdata[0]])."]"; 
			}
		?>
		</SELECT><?php 
	}

	$tmpchk=substr($val[fieldtype],0,7);
	//echo $tmpchk;
	if ($tmpchk=="mappos,") {
		$libsiteid=substr($val[fieldtype],7);
		$tmpshf=tmq("select * from media_place where code='$libsiteid' ");
		$tmpshf=tmq_fetch_array($tmpshf);
		$tmpshf=$tmpshf[main];
		?><INPUT TYPE="text" NAME="<?php echo $kid?>" ID='<?php echo $kid_ID?>' value="<?php  echo $val[defval]; ?>"> <A HREF="<?php  echo $dcrURL?>/_mappospicker.php?libsiteid=<?php  echo $tmpshf;?>&jsid=<?php  echo $kid_ID?>"  rel="gb_page_fs[]"  class='a_btn smaller'><?php echo getlang("เลือก::l::Pick");?></A><?php 
	}
	if ($val[fieldtype]=="callnpicker") {
		?><INPUT TYPE="text" NAME="<?php echo $kid?>" ID='<?php echo $kid_ID?>' value="<?php  echo $val[defval]; ?>"> <A HREF="<?php  echo $dcrURL?>/_callnpicker.php?jsid=<?php  echo $kid_ID?>"  rel="gb_page_fs[]"  class='a_btn smaller'><?php echo getlang("เลือก::l::Pick");?></A><?php 
	}
	$tmpchk=substr($val[fieldtype],0,8);
	//echo $tmpchk;
	if ($tmpchk=="mappos2,") {
		$libsiteid=substr($val[fieldtype],8);
		$tmpshf=tmq("select * from media_place where code='$libsiteid' ");
		$tmpshf=tmq_fetch_array($tmpshf);
		$tmpshf=$tmpshf[main];
		?><INPUT TYPE="text" NAME="<?php echo $kid?>" ID='<?php echo $kid_ID?>' value="<?php  echo $val[defval]; ?>"> <A HREF="<?php  echo $dcrURL?>library.shelfbrowser/_pospicker.php?libsiteid=<?php  echo $tmpshf;?>&pjs=<?php  echo $kid_ID?>"  norel="gb_page_fs[]" target=_blank class='a_btn smaller'><?php echo getlang("เลือก::l::Pick");?></A><?php 
	}

	echo " ".getlang($val[descr])?></TD>
	</TR>

	<?php 
}
?>