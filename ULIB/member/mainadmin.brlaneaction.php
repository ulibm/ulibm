<?php 
$_coengine="brlane";
?>
<form method="post" action="<?php  echo $PHP_SELF?>">
<input type="hidden" name="mempagemode" value="brlaneaction">
	<table align=center cellpadding=0 cellspacing=0 border=0 width=<?php  echo $_TBWIDTH;?>>
<tr>
	<td><?php 
	pagesection(str_webpagereplacer(getlang(stripslashes(barcodeval_get("brlane-greeting")))));
	?><br>
	<center><?php echo getlang("กรุณากรอกบาร์โค้ดทรัพยากรที่ต้องการยืมครั้งละ 1 รายการ::l::Please enter material's barcode 1 item at a time");?><br>
	<input type="text" name="enteredbc" placeholder="<?php  echo getlang("ใส่บาร์โค้ดที่นี่::l::Key barcode here"); ?>"> <input type="submit" value="<?php  echo getlang("ตกลง::l::Submit"); ?>">
</center>

	</td>
</tr>
</table>
</form>

	<table align=center cellpadding=0 cellspacing=0 border=0 width=<?php  echo $_TBWIDTH;?>>
<tr>
	<td><br>
<?php 
$enteredbc=trim($enteredbc);
$chken=tmq("select * from media_mid where bcode='$enteredbc' ");
if (tnr($chken)==0) {
   html_dialog("",getlang("ไม่พบทรัพยากรบาร์โค้ด $enteredbc::l::Material barcode='$enteredbc' notfound"));
   $enteredbc="";
} else {
   $r=tfa($chken);
   if (strtolower(barcodeval_get("brlane-isenable-for-$r[libsite]"))!="yes") {
      html_dialog("",getlang("ขออภัย ".get_libsite_name($r[libsite])." ไม่เปิดให้บริการยืมด้วยตนเอง::l::Campus ".get_libsite_name($r[libsite])." not allow self-checkout."));
      $enteredbc="";
   }
}
if ($enteredbc!="") {
	$res=cir_checkout($_memid,$enteredbc,date("j"),date("n"),date("Y")+543);
	?>
	<table width=100%>
		<tr valign=top>
		<td width=200><TABLE>
	   <TR>
		<TD width=200 align=center><?php  echo res_brief_dsp($res[media_pid]);?></TD>
	   </TR>
	   </TABLE></td>
	   <td><?php 
		if ($res[status]=="error") {
			echo "<b style='color:darkred'>".getlang("ไม่สามารถให้ยืมได้::l::Cannot Checkout")."</b><br>";
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
		</table>
		<?php 
	member_showhold($_memid);
}
?>	</td>
</tr>
</table>