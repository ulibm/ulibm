<?php 
	include("../inc/config.inc.php");
       if ($_memid == "")
        {
        form_member_login();
        echo "<center><font face ='ms sans serif' size =2 color = red>";
        echo "Login หรือ Password ไม่ถูกต้อง โปรดตรวจสอบอีกครั้ง";
        echo "</font></center>";
        }
    else
       {
	head();
	mn_web("member");
	$mediabarcode=$mid;
	pagesection("ยืมต่อ::l::Renew");
	?><center><a href="./mainadmin.php" class=a_btn><?php  echo getlang("กลับ::l::Back");?></a><?php 
	 $s=tmq("select * from member where UserAdminID='$_memid' ");
  	 if (tmq_num_rows($s)!=1) {
  		die("member where UserAdminID='$_memid'");
  		//error will display in display iframe
  	 }
		 
	 $s=tmq_fetch_array($s);

	if ($mediabarcode=="FETCHALL") {
		$mediabarcode="";
		$sql="select * from checkout where hold='$_memid' and allow='yes' and returned='no' order by id asc";
		$result=tmq($sql);
		while ($row2=tmq_fetch_array($result)) {
			$RESOURCE_TYPE=$row2[RESOURCE_TYPE];
			$renewcount=tmq("select * from checkout_rule where media_type='$RESOURCE_TYPE' and member_type='$s[type]' ");
			$renewcount=tmq_fetch_array($renewcount);
			//printr($renewcount);
			$renewcount=floor($renewcount[renew]);
			$decis=member_isoverduing($_memid);
			$sdat=$row2[sdat];
			$smon=$row2[smon];
			$syea=$row2[syea];
			$edat=$row2[edat];
			$emon=$row2[emon];
			$eyea=$row2[eyea];
			$daydiff=ddx(date("j"),date("n"),date("Y"),$edat,$emon,$eyea-543);
			//echo "$decis/$daydiff ($row2[renewcount]<=$renewcount)<br>";
			if ($decis=="PASS"&&$daydiff<=floor(getval("config","daydiff-torenew")) && loginchk_lib("check")==false && $row2[request]=='' && ($row2[renewcount]<=$renewcount)) {
				$mediabarcode=$mediabarcode.",".$row2[mediaId];
			}

		}

	}
	$mediabarcode=trim($mediabarcode,",");


	$Fdat=date("j");
	$Fmon=date("n");
	$Fyea=(intval(date("Y")));//XXX
	//echo "[$mediabarcode]";
	$mediabarcodea=explode(",",$mediabarcode);
	$mediabarcodea=arr_filter_remnull($mediabarcodea);
	@reset($mediabarcodea);
	while (list($k,$v)=each($mediabarcodea)) {
		$cir_checkout_memrenew="yes";
		$_coengine="webrenew";
		$res=cir_checkout($_memid,$v,$Fdat,$Fmon,$Fyea+543);
		?><table width=<?php  echo $_TBWIDTH?> align=center border=0 cellspacing=1 bgcolor=gray>
		<tr valign=top>
		<?php 
   if (getval("_SETTING","circulation_displaycover")=="yes") {
	   ?><td width=200 bgcolor=white><TABLE>
	   <TR>
		<TD width=200 align=center><?php  echo res_brief_dsp($res[media_pid]);?></TD>
	   </TR>
	   </TABLE></td><?php 
   }				
	
		?><td bgcolor=white><?php 
		if ($res[status]=="error") {
			echo "<b style='color:darkred'>".getlang("ไม่สามารถให้ยืมได้::l::Cannot Checkout")."</b><br>";
		}
		member_log($_memid,"renewitem",$res[media_pid]);

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
			foot();
	   }
?>