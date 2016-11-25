<?php 
		$_havestdb=tmq_dump2("ulibhavestlist","code","name,url,url_bibid");
include("$dcrs/_havester/dec.php");

	$itd=tmq("select * from  media_havest_id where hashed='".addslashes($tags[keyid])."' ",false);
	?><BR><div style=""><?php 
	while ($itdr=tmq_fetch_array($itd)) {
		$jsbid="box".randid();
		//printr($itdr);
		if ($_havestdb[$itdr[havestpid]][0]!="") {
			?><CENTER><div ID="<?php  echo $jsbid;?>" style="display:block; border: 1px #FF9900 solid; font-size: 11; width: <?php  echo $_TBWIDTH-6;?>;  padding: 2 2 2 2; margin: 5 0 0 0; float: center; 
-moz-border-radius-topleft:3;
-moz-border-radius-topright:3;
-moz-border-radius-bottomright:3;
-moz-border-radius-bottomleft:3;
-webkit-border-top-left-radius:3;
-webkit-border-top-right-radius:3;
-webkit-border-bottom-left-radius:3;
-webkit-border-bottom-right-radius:3;
background-image:URL(<?php  echo $dcrURL?>_havester/sv/extbg.png);
background-repeat:no-repeat;
background-position:right top; 
text-align:left;
"

			onmouseover="this.style.backgroundColor='#FFCC00';"
			onmouseout="this.style.backgroundColor='';">
			<A HREF="	<?php 
				$tmpbiburl=str_replace('[bibid]',$itdr[bibid],$_havestdb[$itdr[havestpid]][2]);
				echo  $tmpbiburl;
			?>" target=_blank><FONT style="font-size: 22; font-weight: bold;"> <img vspace=2 border=0 width=32 height=32 align=absmiddle src='<?php 
	if (file_exists("$dcrs/_tmp/havestclientlogo-$itdr[havestpid].png")==true) {
		echo "$dcrURL/_tmp/havestclientlogo-$itdr[havestpid].png";
	} else {
		echo  "$dcrURL/_tmp/mediatype.png";
	}
?>'> <?php  echo trim($_havestdb[$itdr[havestpid]][0]);?><img src="<?php  echo $dcrURL?>neoimg/icon_external.png" align=baseline hspace=3 border=0></FONT></A><FONT SIZE="" COLOR="darkred"> &bull; <A HREF="<?php  echo $_havestdb[$itdr[havestpid]][1];?>" target=_blank>หน้าโฮมเพจ</A> &bull; <A HREF="javascript:alert('กำลังอยู่ระหว่างการพัฒนา');">บริการยืมระหว่างห้องสมุด</A> </FONT>
			
			</div>
<?php 
			?>
<SCRIPT LANGUAGE="JavaScript">
<!--
if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
	xmlhttp<?php echo $jsbid?>=new XMLHttpRequest();
} else{// code for IE6, IE5
	xmlhttp<?php echo $jsbid?>=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp<?php echo $jsbid?>.onreadystatechange=function() {
	if (xmlhttp<?php echo $jsbid?>.readyState==4 && xmlhttp<?php echo $jsbid?>.status==200) {
		//document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
		tmp=getobj("<?php echo $jsbid?>");
		tmpstr=mydecode((xmlhttp<?php echo $jsbid?>.responseText));
		//alert(tmpstr);
		tmp.innerHTML=tmp.innerHTML+" "+tmpstr;
	}
}
xmlhttp<?php echo $jsbid?>.open("GET","<?php  echo $dcrURL?>globalpuller.php?charset=UTF-8&url=<?php  echo urlencode($_havestdb[$itdr[havestpid]][1]."/_havester/cli/bibfullstatus.php?bibid=$itdr[bibid]&rand=". randid());?>",true);
xmlhttp<?php echo $jsbid?>.send();
//-->
</SCRIPT>
			<?php 
		}
	}
	?></div></CENTER><?php 
?>