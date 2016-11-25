<?php 
/* 
fixform_tablelister
Property of Suntiparp Plienchote [apeacez@gmail.com/suntiparp.p@msu.ac.th]
design for ULibM & ready.in.th
==============================
fixform_tablelister
fixform_editor
fixform_editor_i
fixform_editor_save
frm_genlist
iconvth
iconvutf
isUTF8
form_pickdate*
form_quickedit*
*/
function fixform_tablelister($tb,$limitsql,$dsp,$iscanadd="no",$iscanedit="no",$iscandel="no",$addquery="none=none",$edittp,$orderby="",$options="",$selectwhat='*',$havinglogic="",$groupbylogic="") {
   global $fixform_tablelister_runcount;
   if (floor($fixform_tablelister_runcount)==0) {
      $fixform_tablelister_runcount=1;
   } else {
      $fixform_tablelister_runcount=$fixform_tablelister_runcount+1;
   }
   global $_TBWIDTH;
	//echo "[selectwhat=$selectwhat]";
	
	if (!is_array($options)) {
		$options=Array();
	}
	if ($selectwhat=="") {
		$selectwhat='*';
	}
	if (!is_array($options[undelete])) {
		$options[undelete]="";
	}
	if (!is_array($options[unedit])) {
		$options[unedit]="";
	}
	if (!is_array($options[undeletearr])) {
		$options[undeletearr]="";
	}
	$options[tablewidth]=trim($options[tablewidth]);
	if ("$options[tablewidth]"=="") {
		//$options[tablewidth]="780";
		$options[tablewidth]=$_TBWIDTH;
	}
	$options[tablewidth]=trim($options[tablewidth]);
	if ($options[tablewidth]=="") {
		$options[tablewidth]=$_TBWIDTH;
	}
	//echo "[[$options[tablewidth]- $_TBWIDTH ]]";
	global $PHP_SELF;
	//echo "[$PHP_SELF]";
	global $_pagesplit_btn_var;
	global $_pagesplit_btn_var_checkboxes;
	global $cfrm;
	global $conn;
	global $dcrs;
	global $startrow;
	global $fftmode;
	global $fftdeleteid;
	global $fftdeleteids;
	global $ffteditid;
	global $ffe_issave;
	global $ffe_limitsql; //สำหรับใช้ในภายหลัง ได้จากตัวแปรนี้ได้เลย
	$ffe_limitsql=$limitsql;
	$addquerya=explode('&',$addquery);
	reset ($addquerya); 
	$addqueryas="";
	while (list ($key, $val) = each ($addquerya)) { 
		$addqueryi=explode('=',$val);
		$addqueryas.="<INPUT TYPE='hidden' NAME='$addqueryi[0]' value='".addslashes($addqueryi[1])."'>";
	} 
	if ($ffe_issave=="yes") {
		fixform_editor_save($edittp);
	}
	if ($fftmode=="deletebycheckbox") {
	  $fftdeleteids=trim($fftdeleteids," /,'\"!@#\$%^&*()");
	  $fftdeleteids=trim($fftdeleteids);
	  if ($fftdeleteids!="") {
		tmq("delete from $tb where $limitsql and id in ($fftdeleteids) ",false);
	  }
   }
	if ($fftmode=="delete") {
		tmq("delete from $tb where $limitsql and id='$fftdeleteid' limit 1 ");
		//global upload
		$globaldcrs="$dcrs/_globalupload/$tb-$fftdeleteid/";
		//echo $globaldcrs;
		$f=@fso_listfile("$globaldcrs");
		foreach ($f as $fi) {
			@unlink( $globaldcrs."/".$fi);
		}
		@rmdir($globaldcrs);
		//singlefile
		@reset ($edittp); 
		while (list ($key, $val) = @each ($edittp)) { 
			$singlefileremovek="$tb:$val[field]:$fftdeleteid";
			$singlefileremove=tmq("select * from fft_upload where keyid='$singlefileremovek' ");
			if (tnr($singlefileremove)!=0) {
				$singlefileremove=tmq_fetch_array($singlefileremove);
				//rename($_VAL_FILE_SAVEPATH.$remq[hidename],$_VAL_FILE_SAVEPATHunused.$remq[hidename]);
				$_singlefile_SAVEPATH="$dcrs/_tmp/fft_upload/$tb/";
				@unlink($_singlefile_SAVEPATH.$singlefileremove[hidename]);
				@unlink($_singlefile_SAVEPATH.$singlefileremove[hidename].".thumb.jpg");
				tmq("delete from  fft_upload where keyid='$singlefileremovek'  ");
			}
		}

	}
	if ($fftmode=="add") {
		echo "<TABLE width='$options[tablewidth]' align=center class=table_border>
		<TR>
			<TD align=center><B>".getlang("เพิ่มข้อมูล::l::Add new data")."</B></TD>
		</TR>
		</TABLE>";
		fixform_editor($edittp,"$tb"," id=''  ",$addqueryas,$options);
	}
	if ($fftmode=="edit") {
		echo "<TABLE width='$options[tablewidth]' align=center class=table_border>
		<TR>
			<TD align=center><B>".getlang("แก้ไขรายการ::l::Edit")."</B></TD>
		</TR>
		</TABLE>";
		$edits=tmq("select $selectwhat from $tb where id='$ffteditid' ");
		if (tnr($edits)!=1) {
			echo "<TABLE width='$options[tablewidth]' align=center class=table_border>
			<TR>
				<TD align=center><B>".getlang("ไม่พบรายการ $ffteditid สำหรับแก้ไข::l::record $ffteditid not found")."</B></TD>
			</TR>
			</TABLE>";
		} else {
			$edits=tmq_fetch_array($edits);
			while (list ($key, $val) = each ($edits)) { 
				if (!is_numeric($key)) {
				   reset ($edittp); 
					while (list ($key2, $val2) = each ($edittp)) { 
						if ($edittp[$key2][field]==$key) {
            	if (trim($val2[unediton])!="") {
            		 $unedita=explode(',',$val2[unediton]);
            		 if ($edits[$unedita[0]]==$unedita[1]) {
								 		$edittp[$key2][fieldtype]="readonlytext";
								 }
            		// if ($)
            	}
							//echo "[".$edittp[$key2][field]."=$val]<BR>";
							$edittp[$key2][defval]=$val;
						}
					}
				} 
			} 

			fixform_editor($edittp,"$tb"," id='$ffteditid'  ",$addqueryas,$options);
		}
	}
	$ffs="select $selectwhat from $tb where $limitsql ";
	$ffs.=" $groupbylogic ";
	$ffs.=" $havinglogic ";
	if ($orderby!="") {
		$ffs.=" order by $orderby";
	}
	//echo $ffs;
	//echo "$PHP_SELF?$addquery";
	if ($iscandel=="yes") {
	  $_pagesplit_btn_var_checkboxes="yes";
	}
	$ffs=tmqp($ffs,"$PHP_SELF?$addquery",'---');
	?><style>

.fixformdeltooltip 
{
top: 0px;
left: -125px;
position: absolute;
font-size: 11px;
color: darkred;
width: 110px;
height: 15px;
padding: 2px;
background: #FFFFFF;
-webkit-border-radius: 6px;
-moz-border-radius: 6px;
border-radius: 6px;
border: #7F7F7F solid 1px;
}

.fixformdeltooltip:after 
{
content: '';
position: absolute;
border-style: solid;
border-width: 3px 0 3px 6px;
border-color: transparent #FFFFFF;
display: block;
width: 0;
z-index: 1;
margin-top: -3px;
right: -6px;
top: 50%;
}

.fixformdeltooltip:before 
{
content: '';
position: absolute;
border-style: solid;
border-width: 3px 0 3px 6px;
border-color: transparent #7F7F7F;
display: block;
width: 0;
z-index: 0;
margin-top: -3px;
right: -7px;
top: 50%;
}
	</style><!-- fixform_tablelister-table-s --><BR><TABLE width='<?php  echo $options[tablewidth]?>' align=center class=table_border>
	<?php 

if ($iscanadd=="yes" || count($options[addlink])!=0 ) {
	echo "<TR>
	<TD align=left colspan='".(count($dsp)+2)."'  >&nbsp;";

	if ($iscanadd=="yes") {
		echo "<A HREF='$PHP_SELF?fftmode=add&$addquery'><B>".getlang("เพิ่มข้อมูล::l::Add new")."</B></A>";
	} else {
			echo "<FONT COLOR='#525252' style='cursor: no-drop;'>" .getlang("เพิ่มข้อมูล::l::Add new")."</FONT>";
	}
	if (is_array($options[addlink])) {
		while (list($alk,$alv)=each($options[addlink])) {
			$alv2=explode('::',$alv);
			if ($alv2[2]=='') {
				$alv2[2]="_self";
			}
			echo " : <A HREF='$alv2[0]' target='$alv2[2]'>$alv2[1]</A>";
		}
	}
	echo "</TD>
	</TR>";
}
?>
	<TR>
		<TD class=table_head width=3%><nobr><?php  echo getlang("ลำดับที่::l::No.");?></nobr></TD><?php 
reset ($dsp); 
while (list ($key, $val) = each ($dsp)) { 
   echo "<TD class=table_head width='".$dsp[$key][width]."'>".getlang($dsp[$key][text])."</TD>\n"; 
} 
	?>	
	<?php 
		if ($iscandel=="yes" || $iscanedit=="yes") {	
	?>
		<TD class=table_head width=7%><nobr><?php  echo getlang("ลบ/แก้ไข::l::Delete/Edit");?></nobr></TD>
	<?php 
		}	
	?>
	</TR>
	<?php 
		if (tnr($ffs)==0) {
			echo "<TR>
				<TD align=center colspan='".(count($dsp)+2)."'  class=table_td><B style='color: 777777'>".getlang("ยังไม่มีข้อมูล::l::No record found")."</B></TD>
			</TR>";
		}
		$c=0;
	while ($ffr=tmq_fetch_array($ffs))	 {
		$localcandelete="yes";
		$localcanedit="yes";
		//printr($ffr);
		//echo $ffr[$options[undelete][field]]."==".$options[undelete][value];
		@reset($options[undeletearr]);
		if (is_array($options[undeletearr]) ) {
			while (list($undeletearrk,$undeletearrv)=each($options[undeletearr])) {
				//echo $ffr[$undeletearrk]."==".$undeletearrv."<br>";
				if ($ffr[$undeletearrk]==$undeletearrv) {
					$localcandelete="no";
				}
			}
		}
		//printr($ffr);
		if (is_array($options[undelete]) && $ffr[$options[undelete][field]]==$options[undelete][value]) {
			$localcandelete="no";
		}
		if (is_array($options[unedit]) && $ffr[$options[unedit][field]]==$options[unedit][value]) {
			$localcanedit="no";
		}
		$c++;
	?>
	<TR class="<?php 
	if (tnr($ffs)>=1) {
	  echo "table_dr";
	}
	?>">
		<TD class=table_td align=center><label style="width:100%; height: 100%; display: block; white-space:nowrap;">
		<?php if (floor($ffr[id])!=0 && $iscandel=="yes" && $localcandelete=="yes") { ?>
		<input type=checkbox style=" opacity: 0.5;" rel="fixformcheckbox<?php echo $fixform_tablelister_runcount;?>" value="<?php echo $ffr[id];?>">
		<?php } ?>
		<?php  echo number_format($c+$startrow);?></label></TD>
		<?php 
reset ($dsp); 
while (list ($key, $val) = each ($dsp)) { 
	$displaydata="";
	if ($dsp[$key][filter]=="date") {
		$ffr[$dsp[$key][field]]=ymd_datestr($ffr[$dsp[$key][field]],"date");
	}
	if ($dsp[$key][filter]=="datetime") {
		$ffr[$dsp[$key][field]]=ymd_datestr($ffr[$dsp[$key][field]]);
	}
	if ($dsp[$key][filter]=="switchsingle") {
		$switchsinglestr[yes]="<CENTER><B style='color:darkgreen'>".getlang("ใช่::l::Yes")."</B></CENTER>";
		$switchsinglestr[no]="<CENTER><B style='color:darkred'>".getlang("ไม่ใช่::l::No")."</B></CENTER>";
		$switchsinglestr[YES]=$switchsinglestr[yes];
		$switchsinglestr[NO]=$switchsinglestr[no];
		$ffr[$dsp[$key][field]]=$switchsinglestr[$ffr[$dsp[$key][field]]];
	}
	if ($dsp[$key][filter]=="yesno") {
		$switchsinglestr[yes]="<CENTER><B style='color:darkgreen'>".getlang("ใช่::l::Yes")."</B></CENTER>";
		$switchsinglestr[no]="<CENTER><B style='color:darkred'>".getlang("ไม่ใช่::l::No")."</B></CENTER>";
		$ffr[$dsp[$key][field]]=$switchsinglestr[$ffr[$dsp[$key][field]]];
	}
	if ($dsp[$key][filter]=="memberbarcode") {
		$ffr[$dsp[$key][field]]=get_member_name($ffr[$dsp[$key][field]]);
	}
	if ($dsp[$key][filter]=="color") {
		$ffr[$dsp[$key][field]]="<div style=\"background-color:".$ffr[$dsp[$key][field]]."; width:20;height:20; margin: 1 1 1 1; display:inline-block; float: left;\"></div><b><font class=smaller2>".$ffr[$dsp[$key][field]]."</font></b>";
	}	
	if ($dsp[$key][filter]=="number") {
		$ffr[$dsp[$key][field]]=number_format($ffr[$dsp[$key][field]],2);
	}
	$tmpchk=substr($dsp[$key][filter],0,8);
	if ($tmpchk=="linkout:") {
		$listdat=substr($dsp[$key][filter],8);
		$listdata=explode(',',$listdat);
		$listdata[0]=str_replace('[value]',$ffr[$dsp[$key][field]],$listdata[0]);
		//print_r($ffr);
		$ffrcopy=$ffr;
		reset($ffrcopy);
		while (list($ffrcopyk,$ffrcopyv)=each($ffrcopy)) {
			$listdata[0]=str_replace('[value-'.$ffrcopyk.']',$ffrcopyv,$listdata[0]);
		}
		$displaydata="<A HREF=\"$listdata[0]\" target='$listdata[1]'>".$dsp[$key][text]."</A>";
		//$ffr[$dsp[$key][field]]=$data;
	}
	$tmpchk=substr($dsp[$key][filter],0,8);
	if ($tmpchk=="foreign:") {
		$listdat=substr($dsp[$key][filter],8);
		$listdata=explode(',',$listdat);
		$listdata6a=explode('=',$listdata[6]);
		//printr($listdata);
		if ($ffr[$dsp[$key][field]]=="") {
			if ($listdata[5]=="") {
				$listdata[5]=getlang("ไม่กำหนด::l::Not specific");
			}
			$displaydata =$listdata[5];
		} else {
			if ($listdata6a[0]==$ffr[$dsp[$key][field]]) {
				$ffr[$dsp[$key][field]]= $listdata6a[1];
			} else {
			   //echo "HEREX";
				$cdefault=tmq("select $listdata[2],$listdata[3] from $listdata[1] where $listdata[2]='".$ffr[$dsp[$key][field]]."' limit 1",false,$listdata[0]);
				//$cdefault=tmq("select * from $listdata[1] where $listdata[2]='".$ffr[$dsp[$key][field]]."' ",true,$listdata[0]);
				//echo "-".tnr($cdefault)."-";
				$cdefault=tmq_fetch_array($cdefault,false);
				// print_r($cdefault);
				// printr($listdata);
				//$ffr[$dsp[$key][field]]=$cdefault[$listdata[3]];
				//if (trim($ffr[$dsp[$key][field]])!="") {
				if (trim($cdefault[$listdata[3]])!="") {
					//$cdefault=tmq_fetch_array($cdefault);
					//$ffr[$dsp[$key][field]]=$cdefault[$listdata[3]];
					$displaydata=$cdefault[$listdata[3]];
					$ffr[$dsp[$key][field]]=$displaydata;
				} else {
					$ffr[$dsp[$key][field]]="<I>".getlang("การเชื่อมโยงผิดพลาด ไม่พบรายการที่::l::Relation false, cannot find ")."$listdata[2]=".$ffr[$dsp[$key][field]]." ".getlang(" ที่ ::l:: at ")." $listdata[0].$listdata[1]</I>";
				}
			}
		}
	}
	$tmpchk=substr($dsp[$key][filter],0,7);
	if ($tmpchk=="module:") {
		$mdname=substr($dsp[$key][filter],7);
		$displaydata =$mdname($ffr);
	}
   echo "<TD class=table_td";
   if ($dsp[$key][align]=="") {
	echo " align=left ";
   } else {
	echo " align='".$dsp[$key][align]."' ";
   }
   echo">";
   if ($displaydata!="") {
	echo getlang($displaydata);
   } else {
	echo ($ffr[$dsp[$key][field]]);
   }
   echo "</TD>\n"; 
} 	
	?>	
	<?php 
	if ($iscandel=="yes" || $iscanedit=="yes") {
		?>
			<TD class=table_td align=center><div style="display:inline" ID="fixform_manarea<?php echo $ffr[id];?>"><?php 
		if ($iscandel=="yes") {
			if ($localcandelete=="yes") {
				echo "<A href=\"javascript:void(null);\" onclick=\"tmp=getobj('fixform_manarea".$ffr[id]."'); tmp.style.display='none';tmp=getobj('fixform_manarea_realdel".$ffr[id]."'); tmp.style.display='block';\" style='color:darkred'>".getlang("ลบ::l::Delete")."</A>";
			} else {
				echo "<FONT COLOR='#525252' style='cursor: no-drop;'>" .getlang("ลบ::l::Delete")."</FONT>";
			}
		}
		echo " ";
		if ($iscanedit=="yes") {
				
			if ($localcanedit=="yes") {
				echo "<A HREF='$PHP_SELF?$addquery&fftmode=edit&ffteditid=$ffr[id]&startrow=$startrow'>".getlang("แก้ไข::l::Edit")."</A>";
			} else {
				echo "<FONT COLOR='#525252' style='cursor: no-drop;'>" .getlang("แก้ไข::l::Edit")."</FONT>";
			}
		}
		
		?></div><div style="display: none;position: relative;"  ID="fixform_manarea_realdel<?php echo $ffr[id];?>">
		<span class="fixformdeltooltip"><?php echo getlang("คลิกเพื่อยืนยันการลบ::l::Click to confirm delete");?></span>
		<?php 
            echo "<A HREF='$PHP_SELF?$addquery&fftmode=delete&fftdeleteid=$ffr[id]&startrow=$startrow' style='color: white; background-color: #B30802; text-decoration: none; -webkit-border-radius: 2px;
-moz-border-radius: 2px;
border-radius: 2px; padding-left:3px;padding-right:3px;'>".getlang("ลบ::l::Delete")."</A> ";
            echo "<A href=\"javascript:void(null);\" onclick=\"tmp=getobj('fixform_manarea".$ffr[id]."'); tmp.style.display='inline';tmp=getobj('fixform_manarea_realdel".$ffr[id]."'); tmp.style.display='none';\" style='color: darkgreen' class=smaller2>".getlang("ยกเลิก::l::Cancel")."</A>";

      ?></div></TD>
		<?php 
	}	
	?>
	</TR>
<?php 	}
	
	echo $_pagesplit_btn_var;	
?>
	</TABLE><!-- fixform_tablelister-table-e -->
<script>
function fixform_tablelister_deleteallchecked<?php echo $fixform_tablelister_runcount;?>() {
tmpconfirm= confirm('<?php echo  getlang($cfrm)?>');
   if (tmpconfirm==true) {
      tmpallids="";
      var cbs = document.getElementsByTagName('input');
      for(var i=0; i < cbs.length; i++) {
        if(cbs[i].checked==true && cbs[i].type == 'checkbox' && cbs[i].getAttribute("rel")=='fixformcheckbox<?php echo $fixform_tablelister_runcount;?>') {
          tmpallids=tmpallids+","+cbs[i].getAttribute("value");
        }
      }
      self.location="<?php echo "$PHP_SELF?$addquery&fftmode=deletebycheckbox&startrow=0&fftdeleteids="; ?>"+tmpallids;
   }
}
</script>
	<?php 
}
?>