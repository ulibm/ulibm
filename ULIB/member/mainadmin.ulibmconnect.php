<table align=center width="<?php  echo $_TBWIDTH;?>">
<tr>
	<td><iframe src="<?php  echo getval("_SETTING","useulibmconnect_url");?>/manage.php?REFCODE=<?php  echo barcodeval_get("activateulib-refcode")?>&REFURL=<?php  echo urlencode($dcrURL);?>&membc=<?php  echo $_memid;?>" width=<?php  echo $_TBWIDTH;?> height=500></iframe></td>
</tr>
</table><?php 
// พ

?>