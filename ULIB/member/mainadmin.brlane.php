<table align=center cellpadding=0 cellspacing=0 border=0 width=<?php  echo $_TBWIDTH;?>>
<tr>
	<td><?php 
	pagesection(str_webpagereplacer(getlang(stripslashes(barcodeval_get("brlane-greeting")))));
	echo str_webpagereplacer(getlang(stripslashes(barcodeval_get("brlane-instruct"))));
	?><br><br>
	<center><a href="mainadmin.php?mempagemode=brlaneaction" class="bigger a_btn"><?php  echo getlang("ยอมรับเงื่อนไขและดำเนินการ::l::Accept and process");?></a></center>
	</td>
</tr>
</table>