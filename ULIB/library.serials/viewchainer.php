<?php 
include("../inc/config.inc.php");
//include("trap.admin.php");
html_start();
  pagesection("ดรรชนี::l::index(es)","fulltext");
?><center><?php 
res_brief_dsp($MID);
if ($bcode!="") {
echo marc_getmidcalln($bcode);
}
?></center><table align=center cellpadding=0 cellspacing=0 border=0 width="<?php  echo $_TBWIDTH;?>"><TR><td>
<?php 
   $allid=explode(",",$allchaincode);
   $allid=arr_filter_remnull($allid);
      $chainchksql="select distinct chain from chainerlink where fromid='$MID' and ( 0  ";
      @reset($allid);
      $sqlforlist=" 0 ";
      while (list($k,$v)=each($allid)) {
         $chainchksql.="or frommid='$v' ";
         $sqlforlist=$sqlforlist." or frommid='$v' ";
      }
      $chainchksql.=")";
      $s=tmq($chainchksql,false);
      
	if (tnr($s)==0) {
		echo getlang("ไม่มีดรรชนี::l::No Index");
	} else {
	
		$chainnamedb=tmq_dump("chainer","code","fromtxt");
		while ($chainr=tmq_fetch_array($s)) { //printr($chainr);
			$chaini=tmq("select * from chainerlink where fromid='$MID' and ($sqlforlist) and chain='$chainr[chain]' ",false);
			echo "<B style=' color:666666;'>".getlang($chainnamedb[$chainr[chain]])."</B><BR>";
			while ($chainir=tmq_fetch_array($chaini)) {
				echo "&nbsp;&nbsp;&bull;&nbsp;<A HREF='$dcrURL/dublin.php?ID=$chainir[destid]' target=_blank><FONT style=' color:#13437D;'>".marc_gettitle($chainir[destid])."</FONT></A><BR>";
			}
		}
	}
?></TD></TR>
</table>