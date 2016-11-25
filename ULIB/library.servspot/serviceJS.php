<?php 
include("../inc/config.inc.php");
head();
include("./_REQPERM.php");
mn_lib();
include("serviceJS.inc.php");
?><center>
<?php 
$addtimethis=floor($addtimethis);
if ($addtimethis!=0) {
   tmq("update servicespot_client set addtime=addtime+$timeadd where  id='$addtimethis'");
         echo "<b style='color:darkgreen'>Time Added</b>";
         ?><script>
         self.location="serviceJS.php?showonly=<?php echo $showonly;?>&showadded=yes";
         </script><?php
         die;
}
if ($showadded=="yes") {
         echo "<b style='color:darkgreen'>Time Added</b>";
}
$clearthis=floor($clearthis);
if ($clearthis!=0) {
   tmq("update servicespot_client set addtime=0 where id='$clearthis' ");
   tmq("delete from servicespot_client_i where spotid='$clearthis'");
         echo "<b style='color:red'>Spot Cleared</b>";
         ?><script>
         self.location="serviceJS.php?showonly=<?php echo $showonly;?>&showcleared=yes";
         </script><?php
         die;
}
if ($showcleared=="yes") {
         echo "<b style='color:red'>Spot Cleared</b>";
}

?>
<script src="countdown/countdown.js" type="text/javascript"></script>
<BR><?php 
pagesection("บริการให้ใช้จุดให้บริการ::l::Service Spot Management");
$s="select * from servicespot_room where 1 ";
if ($showonly!="") {
	$s.=" and id='$showonly' ";
	?><CENTER><A HREF="service-oneJS.php"><?php  echo getlang("เลือกแสดงห้องอื่น::l::Service for other spot");?></A><BR></CENTER><?php 
}
	$s.=" order by name";

$s=tmq($s);
while ($r=tmq_fetch_array($s)) {

	?><TABLE width=1000 align=center bgcolor=#E2E2E2>
	<TR valign=top>
		<TD width=64><?php  echo "<img src='$dcrURL/neoimg/collectionicon/$r[icon]' width=64 height=64>";?></TD>
		<TD style="padding-left: 10px;"><B style="font-size: 32px;"><?php  echo getlang($r[name])?></B><BR>
		&nbsp;&nbsp;<?php  echo getlang($r[descr])?></TD>
	</TR>
	</TABLE>

	<TABLE width=1000 align=center>
	<TR>
		<TD style="padding-left: 0px;">
	<?php 
	$s2=tmq("select * from servicespot_client where pid='$r[id]' order by name ");	
	while ($r2=tmq_fetch_array($s2)) {
      $now=time();
      $allowedtime=$r[minutesallow]*60;
      $allowuntil=($r2[cu_regis]+$allowedtime);
      $remainingtime=$allowuntil-$now;
      if (floor($r2[addtime])!=0) {
         $remainingtime=$remainingtime+(60*$r2[addtime]);
      }
      //echo "$r2[id]-$llowedtime=$allowedtime<br>";
      //echo "allowuntil=$allowuntil<br>";
      //echo "remainingtime=$remainingtime<br>";
      local_servicejs($r2,$remainingtime);

	}
	?>

	</TD>
	</TR>
	</TABLE>
	<?php 
}
foot();
?>