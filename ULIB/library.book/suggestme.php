<?php 
;
     include("../inc/config.inc.php");
html_start();
//laststr=ทดสอบหน่อยนะ&mid=&tagid=tag110
$oldlaststr=$laststr;
$laststr=urldecode($laststr);
$laststrsearch=dspmarc($laststr);
$laststr=str_remspecialsign($laststr);
$laststrsearch=str_replace('  ',' ',$laststrsearch);
$laststrsearch=str_replace('  ',' ',$laststrsearch);
$laststrsearch=str_replace('  ',' ',$laststrsearch);
$laststrsearcha=explode(' ',$laststrsearch);
$limit="0";
$limitsort="0";
while (list($k,$v)=each($laststrsearcha)) {
			if (trim($v)!="") {
				 $limit.=" or $tagid like  '%$v%' ";
				 $limitsort.=" or ($tagid like  '__$v%' or $tagid like  '__^a$v%') ";				 
			}
}
if ($limit=="0")  {
	$limit="1";//allow blank search
}
$s="select distinct $tagid,($limitsort) as ordrby from media where $limit and length(trim($tagid))>3 order by ordrby desc";
//echo "[$limit]";
//echo $s;
$s=tmqp($s,"suggestme.php?objorigin=$objorigin&laststr=$oldlaststr&mid=$mid&tagid=$tagid");
?><script>
function addthis(wh) {
	//alert(parent);
	//alert(wh);
 <?php 
 $chk=tmq("select * from bkedit where fid='$tagid' ");
 $chk=tmq_fetch_array($chk);
$defindi1=substr($chk[defindi1],0,1);
$defindi2=substr($chk[defindi2],0,1);
if ($defindi1=='' || $defindi1=='b') {
	$defindi1='_';
}
if ($defindi2=='' || $defindi2=='b') {
	$defindi2='_';
}
 if ($chk[isrepeat]!="R") {
 		?>
		  parent.getobj('result_<?php  echo $tagid?>').innerHTML='';
		 	newid=parent.duplicatemarc("<?php  echo $tagid ?>","<?php echo $defindi1;?>","<?php echo $defindi2;?>",wh,"no");
			//alert(newid);
			//alert(wh);
			parent.setlastfocus("data"+newid);
			parent.showhidesuggestme_justhide();
			<?php 
 } else {
 ?> 
     parent.duplicatemarc("<?php  echo $tagid ?>","<?php echo $defindi1;?>","<?php echo $defindi2;?>",""+wh+"","yes");
	 <?php 
 }
 ?>

}
</script>
<table border="0" cellpadding="0" cellspacing="0" class=table_border width=100%>
<?php 
if (tmq_num_rows($s)==0) {
	 ?>
<tr><td class=table_td align=center><b style="color:gray"><?php  echo getlang("ไม่พบคำ $laststrsearch::l::$laststrsearch not found");?></b></td></tr>
<?php 
}
while ($r=tmq_fetch_array($s)) {
//printr($r);
			$str2=$r[$tagid];

			$str2a=explodenewline($str2);
			//printr($str2a);
			$cround=0;
      while (list($k,$v)=each($str2a)) {
		$cround++;
		$v=substr($v,2);
		$dsp=$v;						
		$dsp=dspmarc($dsp);
		$dsp=str_remspecialsign($dsp);      			
		if (trim($v)!="" && trim($v)!="^a") {
			reset($laststrsearcha);

			while (list($kx,$vx)=each($laststrsearcha)) {
				$vx=str_remspecialsign($vx);
				if ($vx!="") {
					$dsp=str_replace($vx,"<u class=smaller>$vx</u>",$dsp);
				}
			}
			if ($dsp=="") {
				 continue;
			}
			?><tr><td class=table_td><?php 
				if ($cround>1) { echo "&nbsp;&nbsp;";} else { echo "<B class=smaller>";}
			?><a href="javascript:void(0)" onclick="addthis('<?php echo addslashes($v);?>');" class=smaller><?php  echo $dsp; ?></a></td></tr><?php 
		}
	  }
}
echo $_pagesplit_btn_var;
?></table>