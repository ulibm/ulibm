<?php 
function member_showhold($useradminid2) {
	global $member_showhold_isoverdue;
	global $member_showhold_isreturntoday;
	global $member_showhold_isreturntomorrow;
	
	global $thaimonstrbrief;
	global $LIBSITE;
	global $isatcirculation;
	global $Level;
	global $dcrURL;
	global $dcrs;
	global $_TBWIDTH;
	global $loginadmin;

	$sql="select * from checkout where hold='$useradminid2' and allow='yes' and returned='no' order by id asc";
	$result=tmq($sql);
	$Num=tmq_num_rows($result);
	//ข้อมูลสมาชิก
	 $s=tmq("select * from member where UserAdminID='$useradminid2' ");
  	 if (tmq_num_rows($s)!=1) {
  		die("member where UserAdminID='$useradminid2'");
  		//error will display in display iframe
  	 }
		 
	 $s=tmq_fetch_array($s);
	 	$tmpmbtype="SELECT *  FROM member_type where type ='$s[type]' "; 
		$tmpmbtype=tmq($tmpmbtype);
		if (tmq_num_rows($tmpmbtype) == 0) {
			html_dialog("","ไม่พบ ประเภทสมาชิก $mbtype ::l:: member type not found $mbtype");
			die;
		}
		$tmpmbtype=tmq_fetch_array($tmpmbtype);
		$limithold=$tmpmbtype[limithold];
		
		?><BR><?php 
   pagesection("รายการยืม::l::Holding item","narrow");
	$count=1;
	$allfine=0;
	echo "
   <form action='$dcrURL"."circulation/working.viewmember.php' method=get>
   <input type=hidden name='memberbarcode' value='$useradminid2'>
   <table border=1 cellspacing=0 width='$_TBWIDTH' align='center'  class=table_border>";
	echo "<tr bgcolor=f2f2f2>
<td width=10 align=center  class=table_head><nobr>&nbsp;".getlang("ลำดับที่::l::No.")."&nbsp;</td>
<td align=center  class=table_head><nobr>&nbsp;".getlang("รายละเอียด::l::Detail")."&nbsp;</td>
<td align=center  class=table_head width=10%><nobr>&nbsp;".getlang("ประเภท::l::Type")."&nbsp;</td>
<td align=center  class=table_head>&nbsp;".getlang("วันยืม::l::Hold date")."&nbsp;</td>
<td align=center  class=table_head>".getlang("วันส่ง::l::Return date")."</td>
<td align=center  class=table_head>".getlang("ค่าปรับ::l::Fine")."</td>
</tr>";
$all_renewable=0;
	while ($row2=tmq_fetch_array($result)) {
		$idhandler = $row2[id];
		$mediaId=$row2[mediaId];
		$mediapid=$row2[pid];
		$RESOURCE_TYPE=$row2[RESOURCE_TYPE];
		$sdat=$row2[sdat];
		$smon=$row2[smon];
		$syea=$row2[syea];
		$edat=$row2[edat];
		$emon=$row2[emon];
		$eyea=$row2[eyea];
//echo "floor(".date("j").")==floor($edat) && floor(".date("n").")==floor($emon) && ".floor(date("Y"))."==floor($eyea)";
if (floor(date("j"))==floor($edat) && floor(date("n"))==floor($emon) && floor(date("Y")+543)==floor($eyea)) {
   $member_showhold_isreturntoday="yes";
}
if (floor(date("j")+1)==floor($edat) && floor(date("n"))==floor($emon) && floor(date("Y")+543)==floor($eyea)) {
   $member_showhold_isreturntomorrow="yes";
}
		//echo "[[[end=$eyea start=$syea]]]";   
		$xfine=$row2[fine];
		//printr($row2);
		echo "<tr class=table_dr>";
		echo "<td class=table_td align=center>$count</td>";
		echo "<td align=left  class=table_td width=300>
<a href='$dcrURL"."dublin.php?ID=$mediapid&item=$mediaId' target=_blank data-ajax='false'><!-- $mediaId -->".mb_substr(marc_gettitle($mediapid),0,100)."..</a>
<font class=smaller2><BR>Barcode: $mediaId</font></td>";
		echo "<td align=center  class=table_td><font color='$colsr' ><nobr class=smaller2>";
					
echo "<img border=0 width=18 height=18 src='";
	if (file_exists("$dcrs/_tmp/mediatype/$RESOURCE_TYPE.png")==true) {
		echo "$dcrURL/_tmp/mediatype/$RESOURCE_TYPE.png";
	} else {
		echo "$dcrURL/_tmp/mediatype.png";
	}
	echo "' alt='".getlang($rectype[name])."' align=absmiddle> ";
		echo get_media_type($RESOURCE_TYPE);
		echo "</nobr></td>";
		echo "<td align=center class=table_td><font color='$colsr' >$sdat " . $thaimonstrbrief[$smon] . " $syea";

		echo "</td>";

		echo "<td align=center class=table_td><font color='$colsr' >";
		$tmpdecis=getduedecis($mediaId, date("j"), date("n"), date("Y"));//xxxxx
//echo date("Y");
$daydiff=ddx(date("j"),date("n"),date("Y"),$edat,$emon,$eyea-543);
$daydiff=round($daydiff);

		if ($tmpdecis < 0) {
			$tmpdeci2=-($tmpdecis);
		} else {
			$tmpdeci2=$tmpdecis;
		 }
		 $renewcount=tmq("select * from checkout_rule where media_type='$RESOURCE_TYPE' and member_type='$s[type]' and libsite='$LIBSITE' ");
		 $renewcount=tmq_fetch_array($renewcount);
		 //printr($renewcount);
		 $renewcount=floor($renewcount[renew]);
		$decis=member_isoverduing($useradminid2);

      		echo "$edat " . $thaimonstrbrief[$emon] . " $eyea ";

		echo "<br><font class=smaller>(".ymd_ago(ymd_mkdt($edat+1,$emon,$eyea-543),"ภายใน %::l::with in %").")</font>";

      //echo "$decis/$daydiff"
		if ($decis=="PASS"&&$daydiff<=floor(getval("config","daydiff-torenew")) && loginchk_lib("check")==false && $row2[request]=='' && ($row2[renewcount]<=$renewcount)) {
			echo "<BR><A HREF=\"renew.php?mid=$mediaId\"  data-ajax='false'><B>".getlang("ยืมต่อ::l::Renew")."</B></A> <font class=smaller>($row2[renewcount]/$renewcount)</font>";
			$all_renewable=$all_renewable+1;
		}
		if ($decis!="PASS") {
		 $member_showhold_isoverdue="yes";
		}
		if (library_gotpermission("editduedate")) {
			echo " <a href=\"".$dcrURL."library/holdlist.php?fftmode=edit&ffteditid=$row2[id]&itembc=$mediaId\" target=_blank class='smaller2 a_btn' data-ajax='false'
         style='display:inline-block;width: 27px; height:15px; margin: 0px 0px 0px 0px; z-index:11111'>".getlang("แก้::l::edit")."</a>";
		}
      //echo $daydiff;
      //printr($row2);
      //if (floor($row2[sdat])."-".floor(date('m'))."-".floor($row2[syea])!=floor(date('d'))."-".floor(date('m'))."-".(floor(date('Y'))+543)) {echo "YES";} else {         echo "NO";      }
      if ($isatcirculation=='yes' && $decis=="PASS"&&$daydiff<=floor(getval("config","daydiff-torenew")) && loginchk_lib("check")==true && $row2[request]=='' && ($row2[renewcount]<=$renewcount) &&
      (floor($row2[sdat])."-".floor(date('m'))."-".floor($row2[syea])!=floor(date('d'))."-".floor(date('m'))."-".(floor(date('Y'))+543)) ) {
			echo "<label class=smaller2><input type='checkbox' name='librenew[]' value='$mediaId'>".getlang("ยืมต่อ::l::Renew")."</label>";
			$all_renewable=$all_renewable+1;
		}
		echo "</td>";
		if ($tmpdecis >= 0) {
			echo "<td align=center class=table_td>";
			$tmpfine=($tmpdecis * $xfine);
			$allfine+=$tmpfine;
			if (floor($tmpfine)>0) {
				echo "<font  color=red><B>";
			}
			echo number_format($tmpfine);
			echo "</b></font></td>";
		} else {
			echo "<td align=center class=table_td>";
			echo "-";
			echo "</td>";
		}
		echo "</tr>";
		if ($isatcirculation=="yes") {
			echo "<TR>
			<TD colspan=1></TD>
			<TD colspan=4 align=right class=smaller>";
         //printr($row2);
         if (floor($renewcount)==0) {
            echo "<font class=smaller2 color=77777>".getlang("ยืมต่อไม่ได้::l::Cannot renew")."</font> ";
         } else {
            $tmplocalrnleft=$renewcount-$row2[renewcount];
            if ($tmplocalrnleft>0) {
               
            
               echo "<font class=smaller2 color=77777>".getlang("ยืมต่อได้อีก $tmplocalrnleft จากทั้งหมด $renewcount ครั้ง::l::Can renew $tmplocalrnleft time (total $renewcount renew)")." ";
               //." ".$row2[renewcount]."/$renewcount ";
               if (floor($renewcount)>floor($row2[renewcount])) {
                  $tmplocalrnable=number_format(getval("config","daydiff-torenew"));
                  echo getlang("ยืมต่อได้ก่อนกำหนดส่ง $tmplocalrnable วัน::l::Can renew before due date $tmplocalrnable days")." ";
               }
            }
            echo "</font> ";
         }
			echo getlang("บาร์โค้ด::l::Barcode")." $row2[mediaId]";
			echo "	<B><A HREF=\"$dcrURL/circulation/main.checkin.php?mediabarcode=$row2[mediaId]\" target=main  class='smaller a_btn'  data-ajax='false'>". getlang("คลิกเพื่อคืน::l::Click to Checkin")."</A></B>";
			echo "	<B><A HREF=\"$dcrURL/circulation/working.lost2.php?damagebarcode=$row2[mediaId]\" target=working class='smaller a_btn'  data-ajax='false'>". getlang("หาย/ชำรุด::l::Lost/damage")."</A></B>";
            $chkset=tmq("select * from setreturndtfromto_sub where origid='$row2[id]' ");
            $chksetstr="";
            while ($chksetr=tfa($chkset)) {
               $getname=tmq("select * from setreturndtfromto where id='$chksetr[pid]' ",false);
               $getnames=tfa($getname); //printr($getnames);
               $chksetstr.="<BR>".getlang("ผลจากการกำหนดวันส่งทรัพยากรผ่านระบบ,จาก::l::result from set return date function, from ").":$getnames[note]:".$chksetr[dat]."-".$chksetr[mon]."-".$chksetr[yea];;
            }
            $chkset=tmq("select * from setreturndate_sub where origid='$row2[id]' ");
            $chksetstr2="";
            while ($chksetr=tfa($chkset)) {
               $getname=tmq("select * from setreturndate where id='$chksetr[pid]' ",false);
               $getnames=tfa($getname); //printr($getnames);
               $chksetstr2.="<BR>".getlang("ผลจากการกำหนดวันส่งทรัพยากรผ่านระบบ,จาก::l::result from set return date function, from ").":$getnames[note]:".$chksetr[dat]."-".$chksetr[mon]."-".$chksetr[yea];;
            }
            echo "<font class=smaller2>".$chksetstr.$chksetstr2."</font>";
   
			echo "</TD>
			</TR>";
		}
		$count++;
	}
	if ($count == 1) {
		echo "<tr><td align=center colspan=20>".getlang("ไม่มีรายการยืม::l::No holding item.")."</td></tr>";
	 } else {


		$decis=member_isoverduing($useradminid2);
		if ($decis!="PASS" && loginchk_lib("return")) {
			echo "<TR>
			<TD colspan=6 align=right>".
			getlang("มีหนังสือค้างส่ง หากต้องการพิมพ์ใบทวงถาม::l::Some item(s) overdue to print notification")."  
			<A HREF=\"$dcrURL/library.holdlong/print.php?memberbarcode=$useradminid2\" target=_blank  data-ajax='false'>".
			getlang("กรุณาคลิกที่นี่::l::click here")."</A>
			</TD>
			</TR>";
		}
	}
	
	

		
	//ดูว่ายืมไปกี่รายการแล้ว
	$sql3="SELECT *  FROM checkout where hold ='$useradminid2' and allow='yes' and returned='no' ";
	$result3=tmq($sql3);
	$row3=tmq_fetch_array($result3);
	$holded=tmq_num_rows($result3);
	if ($limithold > $holded) {
		$holdmsg= getlang("ยืมได้อีก " . ($limithold - $holded) . " รายการ::l::Can checkout  " . ($limithold - $holded) . " item more");
	} else {
		$holdmsg=getlang("ไม่สามารถยืมวัสดุสารสนเทศเพิ่มได้::l::Cannot checkout more items");
	}
	echo "
<tr><td colspan=6 align=right class=table_td><b>$holdmsg</b>";
if ($all_renewable>1 && !loginchk_lib("return")) {
	echo " <a href=\"renew.php?mid=FETCHALL\" class=a_btn  data-ajax='false'>".getlang("ยืมต่อทั้งหมด::l::renew all")."</a>";
}
if ($count>1 && loginchk_lib("return") && $isatcirculation=="yes") {
	echo " <a href=\"_checkoutslip.php?memberbarcode=$useradminid2\" class=a_btn target=_blank  data-ajax='false'>".getlang("พิมพ์รายการยืม::l::Print Checkout slip")."</a>";
}
if ($all_renewable>0 && $isatcirculation=="yes") {
   echo " <input type=hidden name=fromlibrenewcheckbox value='yes'>";
   echo " <input type=submit value='".getlang("ยืมต่อทุกรายการที่เลือก::l::Renew all checked")."'>";
}
echo "</td></tr>";
echo "</table>
</form>
";

}
?>