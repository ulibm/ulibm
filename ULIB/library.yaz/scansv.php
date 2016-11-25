<?php  
	; 
		
        include ("../inc/config.inc.php");
		head();
		include("_REQPERM.php");
        mn_lib();


$s=tmq("select * from yaz_sv where id='$sv' ");
if (tmq_num_rows($s)==0) {
	echo "ผิดพลาด ไม่สามารถเซิร์ฟเวอร์หมายเลขที่ระบุได้";
	die;
}
$query=stripslashes($query);
$URL="scansv.php?sv=$sv&query=".htmlspecialchars(urlencode($query));
$s=tmq_fetch_array($s);
if ($page=="") {
	$page=1;
}
if ($startrow=="") {
	$startrow=0;
}
$perpage=getval("pagesplit","pagelength");


$r_start=$startrow;
$r_end=$startrow+$perpage;

$connstr=$s[server].":".$s[port];
	if ($s[db]!="") {
		$connstr=$connstr. "/$s[db]";
	}
	//echo $connstr;

//$connatt=array("user" => "$s[login]", "password" =>"$s[pwd]","persistent" => false, 'piggyback' => false, 'charset' => 'ISO-8859-1');
$connatt=array("user" => "$s[login]", "password" =>"$s[pwd]","persistent" => false, 'piggyback' => false, 'charset' => 'tis-620');

$yazcon=yaz_connect($connstr,$connatt);
yaz_syntax($yazcon, "usmarc");
yaz_range($yazcon, $r_start, $r_end);
yaz_search($yazcon, "rpn", iconvth($query));
//echo yaz_addinfo($yazcon);
//echo "[$query]";
//echo yaz_get_option($yazcon,"charset");
yaz_wait();
?><CENTER><?php  
        echo "<BR>".getlang("ค้นหาที่::l::Searching")." <FONT  COLOR=#003300><B>" . $s[name] . "</B></FONT> ".getlang("ด้วยคำว่า::l::with")."  &quot;$query&quot;<BR>";
        $error = yaz_error($yazcon);
		$hits=0;
    if (!empty($error)) {
    //     echo "<IMG SRC='../neoimg/Seal.gif' WIDTH='16' HEIGHT='16' BORDER='0' align=absmiddle> <B>Error:</B> $error";
    } 
		//else {
        $hits = yaz_hits($yazcon);
  			if ($hits!=0) {
  				echo "<IMG SRC='../neoimg/Green.gif' WIDTH='16' HEIGHT='16' BORDER='0' align=absmiddle> ".getlang("สืบค้นได้ผลลัพธ์จำนวน::l::Got result").": " . number_format($hits)." ".getlang("รายการ::l::records")."";
  			} else {
  				echo "<IMG SRC='../neoimg/Seal.gif' WIDTH='16' HEIGHT='16' BORDER='0' align=absmiddle><FONT  COLOR='#FF3300'> <B>พบจำนวน 0 รายการ</B></FONT> ";
  			}
   // }
//echo "[$page/$hits]".yaz_hits($yazcon);
?> &nbsp; <A HREF="index.php" class=a_btn><?php echo getlang("สืบค้นใหม่::l::New search"); ?></A></CENTER><BR><BR><TABLE width=770 align=center bgcolor=888888 cellpadding=1 cellspacing=1 border=0>
<TR  bgcolor=f2f2f2>
	<TD width=5% align=center><B><?php echo getlang("ลำดับ::l::No."); ?></B></TD>
	<TD align=center><B><?php echo getlang("รายละเอียด::l::Detail"); ?></B></TD>
	<TD width=15% align=center><B><?php echo getlang("บันทึก::l::Save"); ?></B></TD>
	<TD width=17% align=center><B><?php echo getlang("Get MARC"); ?></B></TD>
</TR>
<?php  
  for ($p = 1; $p <= $perpage; $p++) {
      $rec = yaz_record($yazcon, ($p+$r_start), "string");
			//echo mb_detect_encoding($rec, "auto");
			//echo $rec;
			$name=marc_getinfofrom_uglymarc($rec);
      if (empty($rec)) continue;
			$urid="ID_".($p+$r_start);
			$randidjs=randid();
			?>	
<FORM METHOD=POST ACTION="import.php" target="importer" onsubmit="getobj('<?php echo $randidjs;?>').innerHTML='' ;getobj('<?php echo $randidjs;?>').outerHTML='' ; return true;">
	<TR  bgcolor=ffffff>
		<TD align=center><B><?php echo number_format($p+$r_start);?></B></TD>
		<TD><?php echo $name;?>&nbsp;<IMG SRC="../neoimg/View.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle style="border: 0px; width: 16; height: 16;" onclick="alert(getobj('<?php echo $urid;?>').value);"></TD>
		<INPUT TYPE="hidden" name="marcinfo" value="<?php echo ($rec);?>" ID='<?php echo $urid;?>'>
		<INPUT TYPE="hidden" name="fromsv" value="<?php echo ($s[name]);?>">
		<TD align=center><?php  
$marcinfo=addslashes($rec);
$marcinfo=trim($marcinfo);
$mddata=md5($marcinfo);
$c=tmq("select * from yaz_saved where mddata = '$mddata' ",false);
if (tmq_num_rows($c)==0) {
				?><span  ID='<?php echo $randidjs;?>'><B><input type=image SRC="../neoimg/Checkmark.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle style="border: 0px; width: 16; height: 16;"> <?php echo getlang("บันทึก::l::Save"); ?></B></span>
		<?php  
}	else {
	echo "-";				
}
			?>
		<INPUT TYPE="hidden" name="mddata" value="<?php echo ($mddata);?>">

		</TD>
</FORM>
<FORM METHOD=POST ACTION="../library.book/quickyaz.php" target="importer">
		<INPUT TYPE="hidden" name="marcinfo" value="<?php echo ($rec);?>" ID='<?php echo $urid;?>'>
		<INPUT TYPE="hidden" name="fromsv" value="<?php echo ($s[name]);?>">
		<INPUT TYPE="hidden" name="saveandgo" value="yes">
		<TD align=center><?php  
$marcinfo=addslashes($rec);
$marcinfo=trim($marcinfo);
$mddata=md5($marcinfo);
				?><label for="submit<?php echo $randidjs;?>"><B><input type=image SRC="../neoimg/Checkmark.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle style="border: 0px; width: 16; height: 16;" ID="submit<?php echo $randidjs;?>"> <?php echo getlang("Get MARC"); ?></B></span>
		<INPUT TYPE="hidden" name="mddata" value="<?php echo ($mddata);?>">

		</TD>
</FORM>
	</TR>
<?php  

        }
echo pageengine($page,$hits,$URL);
?>
</TABLE>
<CENTER><iframe name=importer width=760 height=50 align=center scrolling=NO src=import.php></iframe></CENTER><?php  
foot();

?>