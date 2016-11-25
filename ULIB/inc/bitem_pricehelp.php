<?php 
function bitem_pricehelp($MID) {
	  	$s=tmq("select distinct price as ppp from media_mid where pid='$MID' order by ppp");
		if (tmq_num_rows($s)!=0) {
			echo getlang("ราคาที่เคยกรอก: ::l::Previous price:");
		}
		while ($r=tmq_fetch_array($s)) { 
			?> <A HREF="javascript:void(null)" onclick="setprice(<?php echo $r[ppp]?>)"><?php echo number_format($r[ppp]);?></A><?php 
		}
	  ?><SCRIPT LANGUAGE="JavaScript">
    <!--
   function setprice(wh) {
		document.forms[0].price.value=wh;
	}
    //-->
    </SCRIPT>
    <?php 
}
?>