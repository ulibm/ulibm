<?php 
;
     include("../inc/config.inc.php"); 
	 html_start();
	 include("inc.php");
	 include("working.inchead.php");
	
	$cir_checkinhist=sessionval_get("cir_checkinhist");
	$cir_checkinhist=unserialize($cir_checkinhist);
	if (!is_array($cir_checkinhist)) {
		$cir_checkinhist=Array();
	}

$mediabarcode=trim($mediabarcode);
if ($cirmode!="checkin" || $mediabarcode=="") {
	die;
}
	$mediabarcodea=explode(",",$mediabarcode);
	$mediabarcodea=arr_filter_remnull($mediabarcodea);
	@reset($mediabarcodea);
	while (list($k,$v)=each($mediabarcodea)) {
		$res=cir_checkin($v,$Fdat,$Fmon,$Fyea);
		//printr($res);
		?><table width=100%>
		<tr valign=top>
		<?php 
   if (getval("_SETTING","circulation_displaycover")=="yes") {
	   ?><td width=200><TABLE>
	   <TR>
		<TD width=200 align=center><?php  echo res_brief_dsp($res[media_pid]);?></TD>
	   </TR>
	   </TABLE></td><?php 
   }				
	
		?><td><?php 
		$cir_checkinhist[$v]=Array();
		$cir_checkinhist[$v][status]=$res[status];
		$cir_checkinhist[$v][media_pid]=$res[media_pid];
		$cir_checkinhist[$v][memberbarcode]=$res[memberbarcode];
		//$cir_checkinhist[$v][status]=$res[status];
		if ($res[status]=="error") {
			echo "<b style='color:darkred'>".getlang("ไม่สามารถรับคืนได้::l::Cannot Checkin")."</b><br>";
		} else {
		}
		$tmpstatus=$res[error];
		@reset($tmpstatus);
		while (list($tmpstatusk,$tmpstatusv)=each($tmpstatus)) {
			echo "&bull; <font style='color:darkred'>".getlang($tmpstatusv)."</font><br>";
		}
		$tmpstatus=$res[msg];
		@reset($tmpstatus);
		while (list($tmpstatusk,$tmpstatusv)=each($tmpstatus)) {
			echo "&bull; <font style='color:darkblue'>".getlang($tmpstatusv)."</font><br>";
		}
		$tmpstatus=$res[success];
		@reset($tmpstatus);
		while (list($tmpstatusk,$tmpstatusv)=each($tmpstatus)) {
			echo "&bull; <font style='color:darkgreen'>".getlang($tmpstatusv)."</font><br>";
		}
			?></td>
		</tr>
		</table><?php 
	}
	$cir_checkinhiststr=serialize($cir_checkinhist);
	sessionval_set("cir_checkinhist",$cir_checkinhiststr);

	@reset($cir_checkinhist);
	?><table cellpadding=0 cellspacing=0 border=0  width=100%>
	<?php 
	while (list($k,$v)=each($cir_checkinhist)) {
		?><tr>
		<td style="border: 0px solid #bbbbbb; border-bottom-width: 1px; padding-left: 40px;"><font  style="font-size: 14px;"> &nbsp;&nbsp;<?php 
		echo "<a href='$dcrURL"."dublin.php?ID=$v[media_pid]' target=_blank style='font-size: 18px; ";
		if ($v[status]=="error") {
			echo " color: red!important;";
		} else {
			echo " color: darkgreen!important;";
		}
		echo "'> &bull; ";
		$tmptitlex=marc_gettitle($v[media_pid]);
		if (trim($tmptitlex)=="") {
			$tmptitlex=getlang("<i>Title not found</i>");
		}
		echo stripslashes($tmptitlex)."</a> [$k]";
		?></font></td>
		<td style="width: 200px;border: 0px solid #bbbbbb; border-bottom-width: 1px; "><?php 
		if (trim($v[memberbarcode])!="") {
			echo strip_tags(get_member_name($v[memberbarcode]));
		}
		?></td>
	</tr><?php 
	}
	?>
	</table><?php 

	//reset val for include other file
	$cirmode="";
	$mediabarcode="";
	$Fdat="";
	$Fmon="";
	$Fyea="";

	$memberbarcode=$res[memberbarcode];
	include("working.viewmember.php");
	/*
	member_showhold($memberbarcode);
	member_showrequest($memberbarcode);
	member_showfine($memberbarcode);
*/
?>