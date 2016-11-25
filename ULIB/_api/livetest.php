<?php  
	; 
		
        include ("../inc/config.inc.php");


		head();
		$_REQPERM="apilivetest";
        mn_lib();
				//include("sys_var.inc.php");

if ($isrun=="yes") {
////////////////
?><center><table align=center width=<?php echo $_TBWIDTH?> class=table_border>
<tr>
	<td><textarea name="" rows="" cols="" style="width: <?php echo $_TBWIDTH?>; height: 100px;"><?php  
	$keyworduse=urlencode($keyword);
	//$amountval=floor($amountval);
	
$url=$apiurl."?command=$command&output=$output&PatronID=$PatronID&Barcode=$Barcode&amount=$amountval&note=$note&mergecredit=$mergecredit&index=$index&keyword=$keyworduse&perpage=$perpage&page=$page&bibid=$bibid&bibresulttype=$bibresulttype&setlibsite=$setlibsite&forceencode=$forceencode";
	$s=file_get_contents($url);
$url=str_replace("&note","&amp;note",$url);	
	echo $url;
	//settings
?></textarea></td>
</tr>
</table></center><table align=center width=<?php echo $_TBWIDTH?> class=table_border>
<tr>
	<td><?php echo $s;?></td>
</tr>
</table><?php  
}
?>
                <div align = "center">
<?php  
pagesection(getlang("ค่าตัวแปรระบบ-API::l::System variables-API"));

?><table border = 0 cellpadding = 0 width ="<?php echo $_TBWIDTH;?>" align = center cellspacing=0>
<form method=post action="<?php echo $PHP_SELF?>">
<input type=hidden name="isrun" value="yes">
  <tr valign = "top">
	<td class=table_head> command</td>
  <td  align=left class=table_td><?php form_quickedit("command",$command,"list:checkpatron,checkout,checkin,checkstatus,fine_pay,finestatus,creditadd,creditwithdrawn,finepay,search,getbib"); ?></td>
 </tr>
   <tr valign = "top">
	<td class=table_head> API URL</td>
  <td  align=left class=table_td><?php  
  if ($apiurl=="") {
	$apiurl=$dcrURL."_api/api/index.php";
  }
  form_quickedit("apiurl",$apiurl,"text"); ?></td>
 </tr>
   <tr valign = "top">
	<td class=table_head> Campus</td>
  <td  align=left class=table_td><?php  
  if ($setlibsite=="") {
		$setlibsite="main";
  }
  frm_libsite("setlibsite",$setlibsite); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> output</td>
  <td  align=left class=table_td><?php form_quickedit("output",$output,"list:serialize,json,printr,print_r"); ?> </td>
 </tr>

  <tr valign = "top">
	<td class=table_head colspan=2> Parameters</td>
 </tr>

  <tr valign = "top">
	<td class=table_head> PatronID</td>
  <td  align=left class=table_td><?php form_quickedit("PatronID",$PatronID,"text"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> barcode</td>
  <td  align=left class=table_td><?php form_quickedit("Barcode",$Barcode,"text"); ?> (Material's barcode)</td>
 </tr>
  <tr valign = "top">
	<td class=table_head> amount</td>
  <td  align=left class=table_td><?php form_quickedit("amountval",$amountval,"text"); ?> (Member's Credit)</td>
 </tr>
  <tr valign = "top">
	<td class=table_head> note</td>
  <td  align=left class=table_td><?php form_quickedit("note",$note,"text"); ?> (Credit's note)</td>
 </tr>
  <tr valign = "top">
	<td class=table_head> mergecredit?</td>
  <td  align=left class=table_td><?php form_quickedit("mergecredit",$mergecredit,"list:true,false"); ?> (Paying fines)</td>
 </tr>
  <tr valign = "top">
	<td class=table_head colspan=2> Search Parameters</td>
 </tr>
  <tr valign = "top">
	<td class=table_head> index</td>
  <td  align=left class=table_td><?php  
  if ($index=="") {
	$index="kw";
  }
  form_quickedit("index",$index,"foreign:-localdb-,index_ctrl,code,name"); ?></td>
 </tr>
  <tr valign = "top">
	<td class=table_head> keyword</td>
  <td  align=left class=table_td><?php form_quickedit("keyword",$keyword,"text"); ?> </td>
 </tr>
  <tr valign = "top">
	<td class=table_head> perpage</td>
  <td  align=left class=table_td><?php  
  $perpage=floor($perpage);
  if ($perpage==0) {
	$perpage=5;
  }
  form_quickedit("perpage",$perpage,"number"); ?> </td>
 </tr>
  <tr valign = "top">
	<td class=table_head> page</td>
  <td  align=left class=table_td><?php  
  $page=floor($page);
  if ($page==0) {
	$page=1;
  }
  form_quickedit("page",$page,"number"); ?> </td>
 </tr>
  <tr valign = "top">
	<td class=table_head> bibid</td>
  <td  align=left class=table_td><?php  
  form_quickedit("bibid",$bibid,"number"); ?> </td>
 </tr>
  <tr valign = "top">
	<td class=table_head> Force Encode</td>
  <td  align=left class=table_td><?php  
  form_quickedit("forceencode",$forceencode,"list:,th,utf"); ?> </td>
 </tr> 
  <tr valign = "top">
	<td class=table_head> bibresulttype</td>
  <td  align=left class=table_td><?php form_quickedit("bibresulttype",$bibresulttype,"list:html,marc,marciso"); ?></td>
 </tr>





	<tr valign = "top">
	  <td colspan=2 align=center><input type=submit value=' Submit '> <a href="index.php" class="smaller a_btn">Back</a></td>
</tr></form>
</table>
<?php  
				foot();
?>