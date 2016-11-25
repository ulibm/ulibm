<?php 
;
include("../../inc/config.inc.php");
// include("./index.inc.php");
$_TBWIDTH="100%";
html_start();
		//mn_web("exportmarked");
if ($clear=="yeahyeah") {
	sessionval_set("historyviewbiblist","");
}
$historyviewbiblist=sessionval_get("historyviewbiblist");
$historyviewbiblist=unserialize($historyviewbiblist);
$historyviewbiblist=arr_filter_remnull($historyviewbiblist);

if (!is_array($historyviewbiblist) || count($historyviewbiblist)==0) {
  html_dialog("---",getlang("ไม่มีรายการที่ดูเมื่อเร็ว ๆ นี้::l::No recent records") . "<br />
 <!-- <br />
<a href='index.php'>".getlang("กลับ::l::Back")."</a> -->");
	die;
}
?><BR>
<TABLE width=<?php  echo $_TBWIDTH?> align=center bgcolor=white cellspacing=0 ><td align=right><nobr><a href="recentviews.php?clear=yeahyeah"><IMG SRC="<?php  echo $dcrURL;?>neoimg/clear.jpg" WIDTH="29" HEIGHT="26" BORDER="0" ALT="" align=absmiddle><B> <?php  echo getlang("ล้างทั้งหมด::l::Clear all"); ?></B></a>&nbsp;</td>
        </TR>
    </TABLE>
    <TABLE width=<?php  echo $dcrURL;?> align=center bgcolor=black cellspacing=1 class=table_border>
<TR bgcolor=#c9c9c9>
	<TD width=5% class="table_head2"><B><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></B></TD>
	<TD width=80% class="table_head2"><B><?php  echo getlang("ชื่อเรื่อง /ชื่อผู้แต่ง::l::Title /Author"); ?></B></TD>
</TR><?php 

$i=0;
foreach ($historyviewbiblist as $value) {
	$i++;
	if ($i % 2 ==0) {
		$c="f2f2f2";
	} else {
		$c="white";
	}
	echo "<TR bgcolor=$c><TD>$i</TD>
	<TD>";
	echo "<a href='$dcrURL"."dublin.php?ID=$value' target=_blank>".(marc_gettitle($value) . "</a>/".marc_getauth($value)."<BR>");
	echo "</TD>
</TR>";
}

?>


</TABLE></FORM>

<script type="text/javascript">
<!--
	top.scrollTo(0,0);
//-->
</script>
