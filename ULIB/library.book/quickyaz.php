<?php 
;
     include("../inc/config.inc.php");
	 html_start();
	 include("_REQPERM.php");
	 loginchk_lib();
    $keyword=stripslashes($keyword);
    $keyword=stripslashes($keyword);
    $authorname=stripslashes($authorname);
    $authorname=stripslashes($authorname);
    $isn=stripslashes($isn);
    $isn=stripslashes($isn);
    
	 if ($saveandgo=="yes") {
		if (trim($marcinfo)!="") {
			tmq("insert into yaz_saved set marcinfo='".($marcinfo)."',fromsv='$fromsv', dt='".time()."' ,mddata='$mddata' ");
			$newid=tmq_insert_id();
			?><SCRIPT LANGUAGE="JavaScript">
			<!--
			 top.location="<?php  echo $dcrURL?>/library.book/addDBbook.php?yazid=<?php  echo $newid?>"
				
			//-->
			</SCRIPT><?php 
			die;

		}
	 }
  ?><TABLE width=100% align=center>
<FORM METHOD=POST ACTION="quickyaz.php" name="yazform">
<TR>
	<TD align=center><B>z39.50 search : <?php  echo getlang("กรุณาเลือกเซิร์ฟเวอร์::l::Please choose server"); ?></B></TD>
</TR>

<TR>
	<TD align=center>
	<SELECT NAME="z39host" ID="z39host">
<?php 
$s=tmq("select * from yaz_sv  where isshow='YES' order by ordr,name");
$i=0;
while ($r=tmq_fetch_array($s)) {
	$selected="";
	if ($r[id]==$z39host) {
		$selected="selected";
	}
	$i++;
	echo "		<OPTION VALUE='$r[id]' $selected>$r[name]"; 
}
?>
	</SELECT></TD>
</TR>

<TR>
	<TD align=center><?php  echo getlang("กรุณาป้อนคำค้น::l::Enter keyword"); ?>		<select name="field">
		<?php 
			$fieldmap["Title"] = "@attr 1=4";
			$fieldmap["Any"] = "@attr 1=1016";
			$fieldmap["Author"] = "@attr 1=1003";
			$fieldmap["ISBN"] = "@attr 1=7";
			$fieldmap["ISSN"] = "@attr 1=8";
			$fieldmap["Abstract"] = "@attr 1=62";

			while (list($key,$value) = each($fieldmap)) {
				echo '<option value="';
				echo $value;
				echo '">';
				echo $key;
				echo '</option>';
			}
		?>
		</select>

&nbsp;
<input type="text" size="30" name="query"  value="<?php  echo $keyword.$isbn.$authorname.$query?>"/>  <input type="submit" name="action" value="Search" /></TD>
</TR>

</FORM>
</TABLE>
<?php 
if ($z39host=="") {
	die;
}
$sv=$z39host;
//////////////////
$s=tmq("select * from yaz_sv where id='$sv' ");
if (tmq_num_rows($s)==0) {
	echo "ผิดพลาด ไม่สามารถเซิร์ฟเวอร์หมายเลขที่ระบุได้";
	die;
}
$query=stripslashes($query);
$URL="quickyaz.php?field=$field&z39host=$z39host&query=".htmlspecialchars(urlencode($query));
$s=tmq_fetch_array($s);
if ($page=="") {
	$page=1;
}
if ($startrow=="") {
	$startrow=0;
}

//$perpage=getval("pagesplit","pagelength");
$perpage=10;

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
$querysearch="$field \"$query\"";
//echo $querysearch;
yaz_search($yazcon, "rpn", iconvth($querysearch));
//echo yaz_addinfo($yazcon);
//echo "[$query]";
//echo yaz_get_option($yazcon,"charset");
yaz_wait();
?><CENTER><?php 
        echo "".getlang("ค้นหาที่::l::Searching")." <FONT  COLOR=#003300><B>" . $s[name] . "</B></FONT> ".getlang("ด้วยคำว่า::l::with")."  &quot;$query&quot; &nbsp; ";
        $error = yaz_error($yazcon);
		$hits=0;

		//else {
        $hits = yaz_hits($yazcon);
  			if ($hits!=0) {
  				echo "<IMG SRC='../neoimg/Green.gif' WIDTH='16' HEIGHT='16' BORDER='0' align=absmiddle> ".getlang("สืบค้นได้ผลลัพธ์จำนวน::l::Got result").": " . number_format($hits)." ".getlang("รายการ::l::records")."";
  			} else {
  				echo "<IMG SRC='../neoimg/Seal.gif' WIDTH='16' HEIGHT='16' BORDER='0' align=absmiddle><FONT  COLOR='#FF3300'> <B>พบจำนวน 0 รายการ</B></FONT> ";
  			}
   // }
//echo "[$page/$hits]".yaz_hits($yazcon);
?><TABLE width=100% align=center bgcolor=888888 cellpadding=1 cellspacing=1 border=0>
<TR  bgcolor=f2f2f2>
	<TD width=5% align=center><B><?php  echo getlang("ลำดับ::l::No."); ?></B></TD>
	<TD align=center><B><?php  echo getlang("รายละเอียด::l::Detail"); ?></B></TD>
	<TD width=15% align=center><B><?php  echo getlang("บันทึก::l::Save"); ?></B></TD>
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
<FORM METHOD=POST ACTION="quickyaz.php">
	<TR  bgcolor=ffffff>
		<TD align=center><B><?php  echo number_format($p+$r_start);?></B></TD>
		<TD><?php  echo $name;?>&nbsp;<IMG SRC="../neoimg/View.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle style="border: 0px; width: 16; height: 16;" onclick="alert(getobj('<?php  echo $urid;?>').value);"></TD>
		<INPUT TYPE="hidden" name="marcinfo" value="<?php  echo ($rec);?>" ID='<?php  echo $urid;?>'>
		<INPUT TYPE="hidden" name="fromsv" value="<?php  echo ($s[name]);?>">
		<INPUT TYPE="hidden" name="saveandgo" value="yes">
		<TD align=center><?php 
$marcinfo=addslashes($rec);
$marcinfo=trim($marcinfo);
$mddata=md5($marcinfo);
				?><label for="submit<?php  echo $randidjs;?>"><B><input type=image SRC="../neoimg/Checkmark.gif" WIDTH="16" HEIGHT="16" BORDER="0" ALT="" align=absmiddle style="border: 0px; width: 16; height: 16;" ID="submit<?php  echo $randidjs;?>"> <?php  echo getlang("Get MARC"); ?></B></span>
		<INPUT TYPE="hidden" name="mddata" value="<?php  echo ($mddata);?>">

		</TD>
	</TR>
</FORM>
<?php 

        }
echo pageengine($page,$hits,$URL);


?>
</TABLE><?php 
		if (!empty($error)) {
			 echo "<BR><IMG SRC='../neoimg/Seal.gif' WIDTH='16' HEIGHT='16' BORDER='0' align=absmiddle> <B>Note:</B> $error";
		} 
usleep(100);
?><SCRIPT LANGUAGE="JavaScript">
<!--
	parent.resizeIframe2('yazdisplayIFRAME');
//-->
</SCRIPT>