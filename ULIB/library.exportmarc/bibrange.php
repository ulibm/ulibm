<?php 
;
set_time_limit (600);

include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();
$bibstart=floor($bibstart);
$bibend=floor($bibend);

pagesection(getlang("ส่งออกตามช่วงของหมายเลข Bib.::l::Export by Bib.ID range"));
$ise=barcodeval_get("lib_marcexport_items");
$perfile=floor($perfile);
if ($perfile==0) {
	$perfile=500;
}
if ($mode=="all") {
	$fname=$dcrs."_output/marcexport-range.mrc";
	$fnamedl=$dcrURL."_output/marcexport-range.mrc";
	@unlink($fname);
	$s=tmq("select * from media where ID >$bibstart and ID<$bibend ");
	$i=0;
	while ($r=tmq_fetch_array($s)) {
		if ($ise=="yes") {
			marc_meltin_item($r[ID]);
		}
			fso_file_write($fname,'a+',marc_export($r[ID]).chr(29));
			$i++;
	}

	?><CENTER><HR><?php  echo getlang("ดำเนินการเสร็จเรียบร้อย $i รายการ::l::$i records done.."); ?> <A HREF="<?php  echo $fnamedl?>" target=_blank><?php  echo getlang("กรุณาคลิกที่นี่เพื่อดาวน์โหลดข้อมูล::l::Click here to download your file"); ?></A> <?php 
	echo "(".round(filesize($fname)/1024)."kb)";
	?></CENTER>
	<?php 
}
if ($mode=="split") {
	$s=tmq("select * from media where ID >$bibstart and ID<$bibend ",false);
	$i=0;
	$cc=tmq_num_rows($s);
	$allrunning=floor($cc/$perfile);
	if ($cc % $perfile !=0) {
		$allrunning=$allrunning+1;
	}
	$filerunning=0;
	$linklist="";
	@unlink($dcrs."_output/marcexport-range-$filerunning-of-$allrunning.mrc");
	while ($r=tmq_fetch_array($s)) {
		if ($i % $perfile==0) {
			$filerunning=$filerunning+1;
			@unlink($dcrs."_output/marcexport-range-$filerunning-of-$allrunning.mrc");
			$linklist.="<nobr><a href='../_output/marcexport-range-$filerunning-of-$allrunning.mrc' target=_blank class=a_btn> $filerunning-of-$allrunning </a></nobr> ";
		}
		$fname=$dcrs."_output/marcexport-range-$filerunning-of-$allrunning.mrc";
		//@unlink($fname);
		if ($ise=="yes") {
			marc_meltin_item($r[ID]);
		}
		fso_file_write($fname,'a+',marc_export($r[ID]).chr(29));
		$i++;
	}

	?><CENTER><HR><?php  echo getlang("ดำเนินการเสร็จเรียบร้อย $i รายการ::l::$i records done.."); ?> <?php  echo getlang("กรุณาคลิกเพื่อดาวน์โหลดข้อมูล::l::Click to download your file"); ?><br><?php 
	//echo "(".round(filesize($fname)/1024)."kb)";
	?><table align=center width=500>
	<tr>
		<td><?php  echo $linklist?></td>
	</tr>
	</table></CENTER>
	<?php 
}
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

<center><form method="post" action="bibrange.php">
<label><?php  echo getlang("เริ่มจากหมายเลข Bib::l::From Bib.ID");?> <input type="text" name="bibstart" value="<?php  echo $bibstart?>" size=10> </label>
<label><?php  echo getlang("จนถึง::l::to");?> <input type="text" name="bibend" value="<?php  echo $bibend?>" size=10> </label>
<br>
	<label><input type="radio" name="mode" value="all" selected checked> <?php  echo getlang("ส่งออกทั้งหมด::l::Export all");?> </label>
	<label><input type="radio" name="mode" value="split"> <?php  echo getlang("แบ่งเป็นไฟล์ ไฟล์ละ::l::Split to files");?>
	</label> <input type="text" name="perfile" value="<?php  echo $perfile?>" size=10> <?php  echo getlang("รายการ::l::records per file");?><br>
	<input type="submit" value="<?php  echo getlang("ส่งออก::l::Export"); ?>">
</form></center>

<CENTER><B><A HREF="mn.php"><?php  echo getlang("กลับ::l::Back"); ?></A>
<?php 
if ($focusbibstart!="") {
   ?><A HREF="bibrange.php"><?php  echo getlang("แสดงทั้งหมด::l::Show all"); ?></A><?php 
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
   echo " <a href='$PHP_SELF?focusbibstart=".$splitaclone[$k][start]."&focusbibend=".$splitaclone[$k][end]."'>";
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
echo "";
foot();
?>
