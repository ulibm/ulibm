<?php 
include("../inc/config.inc.php");
html_start();
//printr($_SESSION);
$now=time();
if ($cardid=="") {	die("cardid=''");}
if (!is_array($paylist)|| count($paylist)==0) {
	html_dialog("error","กรุณาเลือกรายการที่ต้องการชำระด้วย");die;
}

	if ($cardid!="" && $setstat!="") {
//printr($_POST);die;
		$transid=randid();
		/*tmq("insert into oss_pay set
		pay_transid='$transid',
		sumpay='$sumpay',
		realpay='$realpay',
		loginid='$useradminid',
		dt='$now'
		");*/
		$dat=date("d");
		$mon=date("m");
		$yea=date("Y");//XXX
		tmq("insert into finedone set
		idid='$transid',
		note='One Stop Service',
		member='$cardid',
			dat='$dat', 
			mon='$mon',
			yea='$yea',
			cach='$realpay',
			lib='$useradminid',
			credit='$credit', 
		dt='$now'
		");
		if ($credit!=0) {
			tmq("update member set credit=credit-$credit where UserAdminID='$cardid' ");
		}
		$s="select * from oss_req where cardid='$cardid' and stat='waitpayment' and (0 ";
		@reset($paylist);
		while (list($k,$v)=each($paylist)) {
			$s.=" or id='$v' ";
		}
			$s.=" )";
		$s=tmq($s);
		while ($r=tfa($s)) {
			tmq("update oss_req set pay_transid='$transid',stat='$setstat' where id='$r[id]'  ");
				$now=time();
				tmq("insert into fine set isdone='yes',
				memberId='$cardid',
				topic='OSS:".addslashes($r[mat_info])."',
				fine='$r[fee]',
				lib='$useradminid',
				dt='$now',
				idid='$transid',
				note='One Stop Service'
				");
				tmq("insert into oss_req_log set pid='$r[id]',
				lib='$useradminid',
				dt='$now',
				stat='$setstat'
				");

		}
		
		if (floor($sumpay)!=(floor($realpay)+floor($credit))) {
			tmq("insert into oss_req  set dt='$now',
			cardid='$cardid',
			fee='".($sumpay-$realpay)."', 
			stat='waitpayment',
			reftrans='$transid',
			mat_info='รายการค่าใช้จ่ายค้างชำระ' "); //die;
		}

		redir("desk.waitpayment.php",0); 
		die;
	}


	$now=time();

?>
<table cellpadding=20 width=100%>
<tr>
	<td>		<?php  member_showinfo($cardid); ?>
<hr>
<?php 
$res="
		<table width=100%>
	";
	$s="select * from oss_req where cardid='$cardid' and stat='waitpayment' and (0 ";
	@reset($paylist);
	while (list($k,$v)=each($paylist)) {
		$s.=" or id='$v' ";
	}
		$s.=" )";
	$s=tmq($s);
	$sum=0;
	while ($r=tfa($s)) {
		$tmp=explode("Author:",$r[mat_info]);
		//printr($tmp);
		$tmp=$tmp[0];
		$res.="<tr>
		<td><a href='checkmatresult.php?id=$r[id]' taxrget=_blank>".substr(dspmarc($tmp),0,60)."</a></td>
		<td width=70 align=right>".number_format($r[fee],2)."</td>
	</tr>";
		$sum=$sum+$r[fee];
	}
	$res.="
	</table>
	 &bull;  รวม <b>".number_format($sum,2)."</b> บาท  ";
	 echo $res;
	?>
	</td>
</tr>
</table>
<script type="text/javascript">
<!--
	function chk() {
		t1=getobj("realpay");
		t1c=getobj("credit");
		t2=getobj("sumpay");
		credithave=getobj("credithave");
		if (parseFloat(t1c.value)>parseFloat(credithave.value)) {
			alert("<?php  echo getlang("ใส่จำนวนเครดิตมากกว่าที่มี::l::Enter too much Credit");?>" +" ("+credithave.value+")" );
			return false
		}
		tmp=parseFloat(t1.value)+parseFloat(t1c.value);
		if (tmp!=parseFloat(t2.value)) {
			return confirm("กรุณายืนยันการชำระเงินแบบไม่เต็มจำนวน");
		} else {
			return true;
		}
	}
	function chkdsp() {
		t1=getobj("realpay");
		t1c=getobj("credit");
		t2=getobj("sumpay");
		t3=getobj("sumdsp");
		tmp=parseFloat(t1.value)+parseFloat(t1c.value);
		t3.innerHTML=tmp;
		if (tmp==parseFloat(t2.value)) {
			t3.style.color="darkgreen";
		} else {
			t3.style.color="red";
		}
	}
	setInterval("chkdsp()",200);
//-->
</script><FORM METHOD=POST ACTION="processpay.php" onsubmit="return chk();">
<TABLE width=95% style="border: 1px solid darkgreen; padding: 3 3 3 3; margin: 5 5 5 5;background-color: #EFFCED">
<TR>
	<TD align=center style="background-color: #eeeeee">กรุณายืนยัน</TD>
</TR>
<input type="hidden" name="sumpay" value="<?php  echo $sum?>" ID=sumpay>
<INPUT TYPE="hidden" NAME="cardid" value="<?php  echo $cardid?>">
<INPUT TYPE="hidden" NAME="credithave" ID="credithave" value="<?php  
$credithave=tmq("select * from member where UserAdminID='$cardid'");
$credithaver=tfa($credithave);
echo $credithaver[credit];
?>">
<?php 
	@reset($paylist);
	while (list($k,$v)=each($paylist)) {
		echo "<INPUT TYPE=hidden NAME='paylist[]' value='$v'>
";
	}
?>
<TR valign=top>
	<TD align=left><TABLE width=100%>
	<tr>
		<td>กำหนดสถานะทุกรายการเป็น<br>
		<label><input type="radio" name="setstat" value='waitpickup'  checked> รอผู้มารับเอกสาร</label>
		<label><input type="radio" name="setstat" value='matsent'  > ส่งเอกสารแล้ว</label>
		<label><input type="radio" name="setstat" value='done'  > รายการเสร็จสมบูรณ์แล้ว</label>
		</td>
	</tr>
	</TABLE>
	ชำระจำนวน <input type="text" ID=realpay name="realpay" value="<?php  echo $sum?>" size=7 style="font-size:15; color: darkred;; text-align:center;"> ฿
	และ
	<input type="text" ID=credit name="credit" value="<?php  echo 0?>" size=7 style="font-size:15; color: darkred;; text-align:center;"> Credit 
	รวมเป็น 
	<Div style="display:inline;font-size:15; color: darkred; font-family: Tahoma;font-weight: bold;" ID="sumdsp"></div> 
	<INPUT TYPE="submit" style="font-size:15; color: darkred; font-family: Tahoma;font-weight: bold;"  value="  บันทึก  " class=a_btngreen></TD>
</TR>

</TABLE></FORM>
<?php 
	include("desk.inc.ifupdater.php");
?>