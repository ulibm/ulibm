<?php 
function foot() {
	global $dcr;
	global $_TBWIDTH;
	global $foot_evelcall;
	global $dcrURL;
	global $_ISULIBMASTER;	
	global $html_start_title;	
	if ($foot_evelcall=="yes") {
		return;
	}
	$foot_evelcall="yes";
?><!-- ตัดเยื่อใยกับตารางก่อนหน้าทั้งหมด -->
</span>

<!-- end printarea -->
<?php 
$htmlc=barcodeval_get("webpage-o-mannualhtmlfooter");
$htmlc=trim($htmlc);
$htmlc=stripslashes($htmlc);
$htmlc=str_webpagereplacer($htmlc);
if ($htmlc!="") {
	 echo "<center><br />$htmlc</center>";
}
$cl=barcodeval_get("activateulib-status");
	if (strtolower(getval("_SETTING", "web_hidefooter"))=="yes") { 
	  echo "<!-- suppress footer bar by setting -->";
	} else {
?>

<BR>
</div></div> <!-- ulibpage-wrap end -->


<DIV ID=FOOTERDIV class=FOOTERDIV style="" align=center>
<div style="color: #bbbbbb; float: right; position: absolute; padding-top: 5px; display: block;">&nbsp;Union Library Management : ULibM</div>
<div style="vertical-align: bottom; display: block; padding-top: 5px;"><IMG SRC="<?php  echo $dcrURL;?>images/copyright<?php 
			if ($_ISULIBMASTER=="yes") {
				 echo "-master";
			} elseif ($cl=="registered") {
				 echo "-registered";
			}
			?>.png" WIDTH=16 HEIGHT=16 
			<?php 
		if ($_ISULIBMASTER=="yes") {
			 echo " TITLE='ULIBM Master site : [".barcodeval_get("activateulib-refcode")."]' ";
		} elseif ($cl=="registered") {
			 echo " TITLE='Registered ULIB' style='cursor: hand; cursor: pointer;' onclick=\"window.open('".getval("SYSCONFIG","ulibmasterurl")."activateulib/sv/cert.php?certid=". barcodeval_get("activateulib-refcode")."','ulibcertwin','width=450,height=300');\" ";
		}
		
		?>
			>
			<?php 
$tmp= getlang(getval("global","FOOT"));
$yea=date("Y");
if (date("m")<=2) {
	$yea=$yea-1;
}
$tmp=str_replace("[YEAR]",$yea,$tmp);
echo $tmp;
?></div>

</DIV>

<?php
} ?>

</BODY>
</HTML>
<!-- html end with foot.php -->
<?php 
}
?>