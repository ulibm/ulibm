<?php include("../inc/config.inc.php");

if( barcodeval_get("webmobile-options-enable")!="yes") {
	redir("$dcrURL");
	die;
}
$THEME=barcodeval_get("webmobile-options-titlebartheme");
if ($THEME=="") {
	$THEME="a";
}

//printr($_SESSION);
$libsites=tmq("select * from member where UserAdminID='$_memid' ");
$libsiter=tfa($libsites);
$LIBSITE=trim($libsiter[libsite]);
//echo "[$LIBSITE]"; //printr($libsiter);
if ($LIBSITE=="") {
   $LIBSITE="main";
}
include("func.php");
//echo "xx".barcodeval_get("webmobile-options-showsearchform");
include("html.start.php");
$_TBWIDTH="100%";
?>
<?php 
pages("home",str_webpagereplacer(stripslashes(stripslashes( barcodeval_get("brlane-greeting") ))));

?>
<?php 
$_coengine="brlane";
?>
<form method="post" action="<?php  echo $PHP_SELF?>">
<input type="hidden" name="mempagemode" value="brlaneaction">
	<table align=center cellpadding=0 cellspacing=0 border=0 width=<?php  echo $_TBWIDTH;?>>
<tr>
	<td><?php 
	echo str_webpagereplacer(getlang(stripslashes(barcodeval_get("brlane-instruct"))));

	?>
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
<?php pagee();?>

<?php 
include("html.end.php");
?>