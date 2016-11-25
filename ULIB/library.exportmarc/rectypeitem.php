<?php 
    ;
	set_time_limit (0);

	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	mn_lib();
			pagesection(getlang("ตามประเภทวัสดุ ที่ระบุใน Item::l::Export by material type in it's items"));
$ise=barcodeval_get("lib_marcexport_items");
$perfile=floor($perfile);
if ($perfile==0) {
	$perfile=500;
}
?>
<CENTER><BR></CENTER>
<TABLE width=500 align=center>
<FORM METHOD=POST ACTION="rectypeitem.php">
<TR>
	<TD><SELECT NAME="md"><?php 
$a=tmq_dump("media_type","code","name");
reset($a);
	foreach ($a as $key => $value) {
		echo "<option value='$key'>".getlang($value);	
	}
	?></SELECT>
   <br>
   	<label><input type="radio" name="mode" value="all" selected checked> <?php  echo getlang("ส่งออกทั้งหมด::l::Export all");?> </label>
	<label><input type="radio" name="mode" value="split"> <?php  echo getlang("แบ่งเป็นไฟล์ ไฟล์ละ::l::Split to files");?>
	</label> <input type="text" name="perfile" value="<?php  echo $perfile?>" size=10> <?php  echo getlang("รายการ::l::records per file");?><br>


 <INPUT TYPE="submit" value=Export class=frmbtn></TD>
</TR>
</FORM>
</TABLE><BR><BR><BR>
<?php 
if ($mode=="all") {
if ($md!="") {
		 $fname=$dcrs."_output/marcexport-item-$md.mrc";
		 $fnamedl=$dcrURL."_output/marcexport-item-$md.mrc";
		@unlink($fname);
		pagesection(getlang("ส่งออก Marc::l::Export Marc"));
		$s="select * from media_mid where RESOURCE_TYPE = '$md' ";
		//echo $s;
		$s=tmq($s);
		echo "<CENTER>";
		echo getlang("มีวัสดุ " .tmq_num_rows($s) . " รายการ ที่ระบุว่าเป็น ".$a[$md]."::l::" .tmq_num_rows($s) . " records specified  ");
		tmq("delete from marcexport_tmp");
		while ($r=tmq_fetch_array($s)) {
				tmq("insert into marcexport_tmp set mediaid='$r[pid]' ");
		}
		$s="select distinct mediaid as xid from marcexport_tmp";
		$s=tmq($s);
		echo getlang(" จำนวน " .tmq_num_rows($s) . " ชื่อเรื่อง ::l:: " .tmq_num_rows($s) . " Title");
		$ise=barcodeval_get("lib_marcexport_items");
		while ($r=tmq_fetch_array($s)) {
		if ($ise=="yes") {
			marc_meltin_item($r[ID]);
		}
				fso_file_write($fname,'a+',marc_export($r[xid]).chr(29));
		}
      
if (file_exists($fname)) {
	?><CENTER><HR> <A HREF="<?php  echo $fnamedl?>" target=_blank><?php  echo getlang("กรุณาคลิกที่นี่เพื่อดาวน์โหลดข้อมูล::l::Click here to download your file"); ?></A> <?php 
	echo "(".round(filesize($fname)/1024)."kb)";
	?></CENTER><?php 
	echo "";
}
}
}

///
if ($mode=="split") {
   $s=tmq("select * from media_mid where RESOURCE_TYPE = '$md' ",false);
   //$s=tmq("select * from media where 1");
	$i=0;
	$cc=tmq_num_rows($s);
	$allrunning=floor($cc/$perfile);
	if ($cc % $perfile !=0) {
		$allrunning=$allrunning+1;
	}
	$filerunning=0;
	$linklist="";
	@unlink($dcrs."_output/marcexport-item-$md-$filerunning-of-$allrunning.mrc");
	while ($r=tmq_fetch_array($s)) {
      $sm=tmq("select * from media where id='$r[pid]' ",false);
      if (tnr($sm)==0) {
         echo " warning: item id $r[id] (barcode=$r[bcode]) not relate with media; ";
      }
      $smr=tfa($sm);
		if ($i % $perfile==0) {
			$filerunning=$filerunning+1;
			@unlink($dcrs."_output/marcexport-item-$md-$filerunning-of-$allrunning.mrc");
			$linklist.="<nobr><a href='../_output/marcexport-item-$md-$filerunning-of-$allrunning.mrc' target=_blank class=a_btn> $filerunning-of-$allrunning </a></nobr> ";
		}
		$fname=$dcrs."_output/marcexport-item-$md-$filerunning-of-$allrunning.mrc";
		//@unlink($fname);
		if ($ise=="yes") {
			marc_meltin_item($r[ID]);
		}
		fso_file_write($fname,'a+',marc_export($smr[ID]).chr(29));
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
<CENTER><B><A HREF="mn.php"><?php  echo getlang("กลับ::l::Back"); ?></A>
</B></CENTER><BR><BR>
<?php 
foot();
?>