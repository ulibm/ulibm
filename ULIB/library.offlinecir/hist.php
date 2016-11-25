<?php 
	; 
		
        include ("../inc/config.inc.php");
		//head();
		html_start();
		include("_REQPERM.php");
		loginchk_lib();
       // mn_lib();
		pagesection(getlang("ประวัติ::l::History"));
if ($deleteall=="yes") {
	tmq("delete from offlinecir");
}
$s=tmq("select distinct importid,count(id) as cc from offlinecir group by importid ");	
?><table cellpadding=0 cellspacing=0 border=0 align=center width=95% class=table_border>
<?php 
while ($r=tfa($s)) {
?>
<tr>
	<td class=table_td><a href="hist_sub.php?importid=<?php  echo $r[importid]?>" style='font-weight:bold;'><?php 
echo stripslashes($r[importid]);
?></a></td>
	<td align=right width=200  class=table_td><?php 
echo number_format($r[cc]);
?> records</td>
</tr>
<?php 
}?>
</table>
<center><a href="<?php  echo $PHP_SELF?>?deleteall=yes" class=a_btn style='color: darkred' onclick="return confirm('Please confirm');"><?php  echo getlang("Clear all log");?></a></center>