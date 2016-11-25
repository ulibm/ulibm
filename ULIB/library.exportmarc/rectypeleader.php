<?php 
    ;
	set_time_limit (0);

	include ("../inc/config.inc.php");
	head();
	include("_REQPERM.php");
	mn_lib();
			pagesection(getlang("ตามประเภทวัสดุ ที่ระบุใน Leader/06::l::Export by Leader/06"));

?>
<CENTER><BR></CENTER>
<TABLE width=500 align=center>
<FORM METHOD=POST ACTION="rectypeleader.php">
<TR>
	<TD><SELECT NAME="md"><?php 
	$a["a"]="Language Mateial";
	$a["c"]="Printed Music";
	$a["d"]="Manuscript music";
	$a["e"]="Cartographic material";
	$a["f"]="Manuscript cartographic material";
	$a["g"]="Projected medium";
	$a["i"]="Nonmusical sound recording";
	$a["j"]="Musical sound recording";
	$a["k"]="Two-dimensional nonprojectable graphic";
	$a["m"]="Computer File";
	$a["o"]="Kit";
	$a["p"]="Mixed materials";
	$a["r"]="Three-dimensional artiface or naturally occouring object";
	$a["r"]="Manuscript language material";

	foreach ($a as $key => $value) {
		echo "<option value='$key'>$value";		
	}
	?></SELECT> <INPUT TYPE="submit" value=Export class=frmbtn></TD>
</TR>
</FORM>
</TABLE><BR><BR><BR>
<?php 
if ($md!="") {
		 $fname=$dcrs."_output/marcexport-leader06.mrc";
		 $fnamedl=$dcrURL."_output/marcexport-leader06.mrc";
		@unlink($fname);
		pagesection(getlang("ส่งออก Marc::l::Export Marc"));
		$s="select * from media where leader like '______$md%'";
		//echo $s;
		$s=tmq($s);
		echo "<CENTER>".getlang("มี " .tmq_num_rows($s) . " รายการ ที่ระบุว่าเป็น ".$a[$md]."::l:: " .tmq_num_rows($s) . " records specified as ".$a[$md]."")."</CENTER>";
		$ise=barcodeval_get("lib_marcexport_items");
		while ($r=tmq_fetch_array($s)) {
		if ($ise=="yes") {
			marc_meltin_item($r[ID]);
		}
				fso_file_write($fname,'a+',marc_export($r[ID]));
		}
}
if (file_exists($fname)) {
	?><CENTER><HR> <A HREF="<?php  echo $fnamedl?>" target=_blank><?php  echo getlang("กรุณาคลิกที่นี่เพื่อดาวน์โหลดข้อมูล::l::Click here to download your file"); ?></A> <?php 
	echo "(".round(filesize($fname)/1024)."kb)";
	?></CENTER><?php 
	echo "";
}
?>
<CENTER><B><A HREF="mn.php"><?php  echo getlang("กลับ::l::Back"); ?></A>
</B></CENTER><BR><BR>

<?php 
foot();
?>