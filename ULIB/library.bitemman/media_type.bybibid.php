<?php

	$bibend=tmq("select floor(ID) as cc from media order by ID desc limit 1");
	$bibend=tfa($bibend);
	$bibend=floor($bibend[cc]);
	$bibstart=tmq("select floor(ID) as cc from media order by ID asc limit 1");
	$bibstart=tfa($bibstart);
	$bibstart=floor($bibstart[cc]);
   if ($focusbibstart!="" && $focusbibend!="") {
      $bibstart=floor($focusbibstart);
      $bibend=floor($focusbibend);
   }
   //echo "[bibstart=$bibstart]";   echo "[bibend=$bibend]";
?>
<center>
<?php 
if ($focusbibstart!="") {
   ?><A HREF="media_type.php?bybidid=yes"><?php  echo getlang("แสดงทั้งหมด::l::Show all"); ?></A><?php 
}
?>
</B><BR>
<BR>
<?php echo getlang("กราฟความถี่::l::Frequency Graph");?><BR>

<?php 
$splited=20;
$allbib=$bibend-$bibstart;
if ($allbib<100) {
   $splited=10;
}
$splita=Array();
$eachblock=floor($allbib/$splited);
$eachblockwidth=floor($_TBWIDTH/$splited);
for ($i=0;$i<$splited;$i++) {
   $splita[$i]=Array();
   $splita[$i][start]=$bibstart+(($eachblock*$i)+1);
   $splita[$i][end]=$bibstart+($eachblock*($i+1));
}
if (floor($splita[count($splita)-1][end])<$bibend) {
   $splita[count($splita)-1][end]=$bibend;
}
//printr($splita);
?><table width=<?php echo $_TBWIDTH;?> border=0 cellpaspacing=1 bgcolor=#f7f7f7>
<?php
@reset($splita);
$max=0;
$resa=Array();
while (list($k,$v)=each($splita)) {
   $s=tmq("select id from media where floor(ID)>".$v[start]." and floor(ID)<".$v[end]." ",false);
   //$s=tmq("select count(id) as cc from media where id>='".$v[start]."' and id<='".$v[end]."' ",false);
   //$s=tfa($s);
   $thismax=tnr($s);
   if (floor($thismax)>$max) {
      $max=$thismax;
   }
   $resa[$k]=$thismax;
   //echo $thismax."<BR>";
}
echo "";
//printr($resa);
?> <tr>
<?php 
@reset($splita);
$splitaclone=$splita;
$splita=array_reverse($splita);

while (list($k,$v)=each($splita)) {
   echo "<td style='font-size: 11px' valign=bottom height=70 bgcolor=white align=center>";
   ?><div 
	style="xxx; width: 100%; background-color: #999999!important; border:1px solid #dddddd; height: <?php echo floor(percent_cal($max,floor($resa[$k]))/2);?>px">&nbsp;</div>
	<?php
   if ($eachblock>100) {
   echo " <a href='media_type.php?bybidid=yes&focusbibstart=".$splitaclone[$k][start]."&focusbibend=".$splitaclone[$k][end]."'>";
   }
   echo number_format($resa[$k])."</a></td>";
}
?>
</tr>
 <tr><?php
@reset($splita);
$i=0;
while (list($k,$v)=each($splita)) {
$i++;
   $rowspan=(count($splita)-$i)+1;
   echo "<td style='font-size: 11px'  bgcolor=white width=$eachblockwidth rowspan=".$rowspan.">&nbsp</td>";
}
echo "</tr>";
@reset($splita);
$i=0;
while (list($k,$v)=each($splita)) {
$i++;
   $colspan=($i)+1;

   echo "<tr><td  bgcolor=white style='font-size: 11px' colspan=$colspan><nobr>".number_format($v[start])."-".number_format($v[end])."</nobr></td></tr>";
}
?></table>
</CENTER><BR>
<BR>

<?php 
?>