<?php 
;
     include("../inc/config.inc.php"); 
	 html_start();
	 include("inc.php");
	 include("working.inchead.php");
if (strtolower(trim(getval("_SETTING","memberbarcodehasspecialsign")))!="yes") {
	 $memberbarcode=str_replace("จ","0",$memberbarcode);
	 $memberbarcode=str_replace("ๅ","1",$memberbarcode);
	 $memberbarcode=str_replace("/","2",$memberbarcode);
	 $memberbarcode=str_replace("-","3",$memberbarcode);
	 $memberbarcode=str_replace("ภ","4",$memberbarcode);
	 $memberbarcode=str_replace("ถ","5",$memberbarcode);
	 $memberbarcode=str_replace("ุ","6",$memberbarcode);
	 $memberbarcode=str_replace("ึ","7",$memberbarcode);
	 $memberbarcode=str_replace("ค","8",$memberbarcode);
	 $memberbarcode=str_replace("ต","9",$memberbarcode);
}
	 
   if (substr($memberbarcode,0,5)=="ecard") {
      $ecardid=substr($memberbarcode,5);
      $ecard=tmq("select * from ulibecard where id='$ecardid' ",false);
      if (tnr($ecard)!=0) {
         $ecard=tfa($ecard);
         $memberbarcode=$ecard[memid];
      }
      //die;///
   }
if ($memberbarcode=="") {
	localloadmember("fine");
	die;
} else {
	 $s=tmq("select * from member where UserID01='$memberbarcode' ");
	 if (tmq_num_rows($s)==1) {
		 $s=tmq_fetch_array($s);
		 $memberbarcode=$s[UserAdminID];
	 }
}

	localloadmember($memberbarcode,"yes","no",$alertfine);
	pagesection("ค่าปรับที่ยังไม่ชำระ::l::Unpaid fine");
	html_xpbtn(getlang("ค่าปรับที่ชำระแล้ว::l::Paid fine").",working.finehist.php?memberbarcode=$memberbarcode,gray" ."::".
	getlang("พิมพ์ใบทวงค่าปรับ::l::Print Notif").",../library.finesnotif/print.php?memberbarcode=$memberbarcode,gray,_blank");

/////////////////////


if ($savepayment=="yes") {
	//printr($_POST);
$randid= randid();
 $sql ="update fine set isdone='yes',lib='$useradminid', idid='$randid' ,note='".addslashes($note)."' where memberId='$memberbarcode' and isdone='no'";
	$result = tmq($sql);
$now=time();
$dat=date("d");
$mon=date("m");
$yea=date("Y");//XXX
$credit=($credit);
       $sql ="insert into finedone set note='".addslashes($note)."',idid='$randid', member='$memberbarcode', cach='$cache',lib='$useradminid',
			credit='$credit', 
			dt='$now', 
			dat='$dat', 
			mon='$mon',
			yea='$yea'";
                      $result = tmq($sql);
if ($credit!=0) {
	tmq("update member set credit=credit-$credit where UserAdminID='$memberbarcode' ");
}
?><CENTER><BR><TABLE bgcolor=#FFEFCE>
<TR>
	<TD>
      <?php  echo getlang("ชำระเงินเรียบร้อยแล้ว::l::Payment completed "); ?>  <A HREF="working.fine.fdd.php?id=<?php  echo $randid?>&memberbarcode=<?php  echo $memberbarcode?>" target=_blank><B><?php  echo getlang("คลิกที่นี่เพื่อพิมพ์ใบเสร็จ::l::Click here to print slip"); ?></B></A></TD>
</TR>
</TABLE></CENTER><BR>
<?php 
}


//////////////////////

$_TBWIDTH="100%";
$tbname="fine";


$c[2][text]="สมาชิก::l::Member";
$c[2][field]="memberId";
$c[2][fieldtype]="readonlytext";
$c[2][descr]="";
$c[2][defval]=$memberbarcode;

$c[3][text]="Topic::l::Topic";
$c[3][field]="topic";
$c[3][fieldtype]="text";
$c[3][descr]="";
$c[3][defval]="OVER DUE:";

$c[4][text]="Fine::l::Fine";
$c[4][field]="fine";
$c[4][fieldtype]="number";
$c[4][descr]="";
$c[4][defval]="0";

$c[5][text]="เจ้าหน้าที่::l::Librarian";
$c[5][field]="lib";
$c[5][fieldtype]="autoofficer";
$c[5][descr]="";
$c[5][defval]="$useradminid";

$c[7][text]="Dt::l::Dt";
$c[7][field]="dt";
$c[7][fieldtype]="date";
$c[7][descr]="";
$c[7][defval]=time();

//dsp


$dsp[3][text]="Topic::l::Topic";
$dsp[3][field]="topic";
$dsp[3][width]="30%";

$dsp[4][text]="Fine::l::Fine";
$dsp[4][field]="fine";
$dsp[4][width]="10%";

$dsp[5][text]="บรรณารักษ์::l::Librarian";
$dsp[5][align]="center";
$dsp[5][field]="lib";
$dsp[5][filter]="module:locallib";
$dsp[5][width]="20%";

$dsp[7][text]="วันที่::l::Date";
$dsp[7][field]="dt";
$dsp[7][filter]="date";
$dsp[7][width]="30%";


function locallib($wh) {
	return get_library_name($wh[lib]);
}

?><!-- table for set position of calculator -->
<TABLE class=table_border width=100% border=0 cellpadding=0 cellspacing=0>
<TR valign=top>
	<TD>
<?php 
$delperm="no";
if (library_gotpermission("deletefineatcir")) {
	$delperm="yes";
}

fixform_tablelister($tbname," memberId='$memberbarcode' and isdone='no' ",$dsp,"$delperm","$delperm","$delperm","memberbarcode=$memberbarcode",$c);

$all=tmq("select *,sum(fine) as fine1,count(id) as cc1 from fine where memberId='$memberbarcode' and isdone='no' group by memberId ");
$all=tmq_fetch_array($all);
if ($all[cc1]==0) {
	die;
}

 $smember=tmq("select * from member where UserAdminID='$memberbarcode' ");
 if (tmq_num_rows($smember)!=1) {
	localdisplayerror("membernotfound");
	die;	
 }
 $smember=tmq_fetch_array($smember);

?>

<TABLE class=table_border width=100%>

<TR ><td colspan=5 align=right class=table_head><?php  echo getlang("ชำระเงินจำนวน::l::Paid"); ?> :
</td>
<td class=table_td>
<form action="working.fine.php" method=post onsubmit="return entercheck();" ID='paymentform'>

 <B><?php  echo getlang("ค่าปรับ::l::Fine"); ?> <?php  echo number_format($all[fine1]);?> <?php  echo getlang("บาท::l::฿"); ?></B> <span ID="resdsp"></span><BR>
   <?php  echo getlang("เงิน::l::Money"); ?> <input type="text" name="cache" ID=cacheID value="<?php  echo $all[fine1];?>" style="font-weight: bold; text-align: right;" size=4 onkeydown=" return numbersonly(event)" onkeyup="chkval(); ">
  <?php  echo getlang("บาท::l::฿"); ?>
  <?php 
  if ($smember[credit]>0) {
  ?>
  <IMG SRC="../neoimg/Right16.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" style="cursor: hand; cursor: pointer;" onclick="swapthis();">
    Credit:   <input type="text" name="credit" ID=creditID value="0" style="font-weight: bold; text-align: right;" size=4 onkeydown=" return numbersonly(event)" onkeyup="chkval(); ">
  <IMG SRC="../neoimg/coins.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" style="cursor: hand; cursor: pointer;" onclick="smartswap();">

<?php } else {
  ?><input type="hidden" name="credit" ID=creditID value="0" ><?php 
  } ?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	allfine=<?php  echo $all[fine1];?>;
  	allcredit=<?php  echo $smember[credit];?>;

	function swapthis() {
		credite=getobj("creditID").value
		cachee=getobj("cacheID").value
			
		getobj("creditID").value=cachee
		getobj("cacheID").value=credite
		chkval();
	}
	function smartswap() {
		if (allfine>allcredit) {
			paycredit=allcredit
			paycache=allfine-allcredit
		} else {
			paycredit=allfine
			paycache=0
		}

		getobj("creditID").value=paycredit
		getobj("cacheID").value=paycache
		chkval();
	}
	function chkval() {
		credite=Math.floor(getobj("creditID").value)
		cachee=Math.floor(getobj("cacheID").value)
		if (credite>allcredit) {
			getobj("resdsp").innerHTML=" <B style='color: darkred'><?php  echo getlang("ใส่จำนวนเครดิตมากกว่าที่มี::l::Enter too much Credit");?></B>";
			getobj("SUBMITBTN").disabled=true
			localcal();
			return
		}
		if ((credite+cachee)>allfine) {
			getobj("resdsp").innerHTML=" <B style='color: darkred'><?php  echo getlang("ใส่จำนวนเงินและเครดิตมากกว่าค่าปรับ::l::Enter too much Credit");?></B>";
			getobj("SUBMITBTN").disabled=true
			localcal();
			return
		}
		getobj("resdsp").innerHTML="";
		getobj("SUBMITBTN").disabled=false
		//alert(allfine)
		localcal();
	}

lastfocuscaler="no";
function localcal(wh) {
	tmp=getobj("cacheID");
	tmp2=getobj("caltotal");
	tmpcalrec=getobj("calrec");
	tmp3=getobj("calcha");
	tmp2.value=tmp.value;
	cal=tmp2.value-tmpcalrec.value;
	if (cal>=0) {
		tmp3.value="- - -"
	}
	if (cal<0) {
		tmp3.value=0-cal
	}
}

function entercheck() {
	if (lastfocuscaler=='yes') {
		return confirm('Please Confirm');
	} 
	return true;
}

function chkquickenter() {
	if (event.keyCode==13) {
		tmpremoteform=getobj("paymentform");
		tmpconfirm=confirm('Please Confirm');
		if (tmpconfirm==true) {
			tmpremoteform.submit();
		}
		//return true;
	}
}
//-->
</SCRIPT>

  <input type="submit" name="Submit" ID='SUBMITBTN' value="<?php  echo getlang("ชำระ::l::Submit"); ?>"><BR>
Note* <input type="text" name="note" size=40 placeholder="Note">
<input type="hidden" name="memberbarcode" value="<?php  echo "$memberbarcode";
?>">
<input type="hidden" name="savepayment" value="yes">

</form>
</td></tr>

</table>

</TD>
	<TD width=200 align=center><form method="post" action="" onsubmit="return false;">
		<?php  echo getlang("ต้องชำระ::l::Total");?><BR>
	<INPUT TYPE="text" NAME="caltotal" ID="caltotal" style="width: 190; font-size: 50; color: darkblue; height: 60; text-align: right;" onclick="localcal();" onfocus="this.blur();" onchange="return false;" onkeydown="return false;">
<?php  echo getlang("รับมา::l::Reciept");?><BR>
	<INPUT TYPE="text" NAME="calrec" ID="calrec" style="width: 190; font-size: 50; color: darkgreen; height: 60; text-align: right;" onkeydown="chkquickenter(event); return numbersonly(event)" onkeyup="localcal(); " onchange="localcal();" onfocus="lastfocuscaler='yes';" onblur="lastfocuscaler='no';">
<?php  echo getlang("ทอน::l::Change");?><BR>
	<INPUT TYPE="text" NAME="calcha" ID="calcha" style="width: 190; font-size: 50; color: darkred; height: 60; text-align: right; font-weight: bold;" onclick="localcal();" onfocus="this.blur();" onkeydown="return false;">
	</form>
<SCRIPT LANGUAGE="JavaScript">
<!--
	tmp2=getobj("calrec");
	tmp2.focus();
	localcal();

//-->
</SCRIPT>
</TD>
</TR>
</TABLE>