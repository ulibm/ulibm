<?php 
;
set_time_limit (600);

include("../inc/config.inc.php");
head();
include("_REQPERM.php");
mn_lib();
pagesection(getlang("ส่งออก Marc ทุกระเบียน::l::Export all"));
$ise=barcodeval_get("lib_marcexport_items");
$perfile=floor($perfile);
if ($perfile==0) {
	$perfile=500;
}
if ($mode=="all") {
	$fname=$dcrs."_output/marcexport-all.mrc";
	$fnamedl=$dcrURL."_output/marcexport-all.mrc";
	@unlink($fname);
	$s=tmq("select * from media where 1");
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
	$s=tmq("select * from media where 1");
	$i=0;
	$cc=tmq_num_rows($s);
	$allrunning=floor($cc/$perfile);
	if ($cc % $perfile !=0) {
		$allrunning=$allrunning+1;
	}
	$filerunning=0;
	$linklist="";
	@unlink($dcrs."_output/marcexport-all-$filerunning-of-$allrunning.mrc");
	while ($r=tmq_fetch_array($s)) {
		if ($i % $perfile==0) {
			$filerunning=$filerunning+1;
			@unlink($dcrs."_output/marcexport-all-$filerunning-of-$allrunning.mrc");
			$linklist.="<nobr><a href='../_output/marcexport-all-$filerunning-of-$allrunning.mrc' target=_blank class=a_btn> $filerunning-of-$allrunning </a></nobr> ";
		}
		$fname=$dcrs."_output/marcexport-all-$filerunning-of-$allrunning.mrc";
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
?>

<center><form method="post" action="all.php">
	<label><input type="radio" name="mode" value="all" selected checked> <?php  echo getlang("ส่งออกทั้งหมด::l::Export all");?> </label>
	<label><input type="radio" name="mode" value="split"> <?php  echo getlang("แบ่งเป็นไฟล์ ไฟล์ละ::l::Split to files");?>
	</label> <input type="text" name="perfile" value="<?php  echo $perfile?>" size=10> <?php  echo getlang("รายการ::l::records per file");?><br>
	<input type="submit" value="<?php  echo getlang("ส่งออก::l::Export"); ?>">
</form></center>

<CENTER><B><A HREF="mn.php"><?php  echo getlang("กลับ::l::Back"); ?></A>
</B></CENTER><BR><BR>

<?php 
echo "";
foot();
?>