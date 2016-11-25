<?php 
;
include("../../inc/config.inc.php");
 //include("./indssex.inc.php");
$_TBWIDTH="100%";
html_start();
		//mn_web("exportmarked");
if ($clear=="yeahyeah") {
	sessionval_set("localsearchhist","");
}
$localsearchhist=sessionval_get("localsearchhist");
$localsearchhist=unserialize($localsearchhist);
$localsearchhist=arr_filter_remnull($localsearchhist);

if (!is_array($localsearchhist) || count($localsearchhist)==0) {
  html_dialog("---",getlang("ไม่มีประวัติการสืบค้น::l::No recent search") . "<br />
 <!-- <br />
<a href='index.php'>".getlang("กลับ::l::Back")."</a> -->");
	die;
}
?><BR>
<TABLE width=<?php  echo $_TBWIDTH?> align=center bgcolor=white cellspacing=0 ><td align=right><nobr><a href="recentsearch.php?clear=yeahyeah"><IMG SRC="<?php  echo $dcrURL;?>neoimg/clear.jpg" WIDTH="29" HEIGHT="26" BORDER="0" ALT="" align=absmiddle><B> <?php  echo getlang("ล้างทั้งหมด::l::Clear all"); ?></B></a>&nbsp;</td>
        </TR>
    </TABLE>
    <TABLE width=<?php  echo $dcrURL;?> align=center bgcolor=black cellspacing=1 class=table_border>
<TR bgcolor=#c9c9c9>
	<TD width=5% class="table_head2"><B><nobr><?php  echo getlang("ลำดับที่::l::No."); ?></B></TD>
	<TD width=80% class="table_head2"><B><?php  echo getlang("การสืบค้น / คำค้น::l::Index / Keyword"); ?></B></TD>
</TR><?php 

$i=0;
$tabforsearch=tmq("select * from webbox_tab where module='Searching' ");
$tabforsearch=tfa($tabforsearch);
$tabforsearch=$tabforsearch[id];
$idxdb=tmq_dump2("index_ctrl","code","name"); //printr($idxdb);
foreach ($localsearchhist as $value) {
	$i++;
	if ($i % 2 ==0) {
		$c="f2f2f2";
	} else {
		$c="white";
	}
	$arr=explode(":",$value,2);
	echo "<TR bgcolor=$c><TD>$i</TD>
	<TD>";
	echo "<a href='$dcrURL"."index.php?deftab=$tabforsearch&fromseachboxwebbox=yes&KW=".$arr[1]."&indexcode=".$arr[0]."' target=_top>".getlang($idxdb[$arr[0]]). " : ".stripslashes($arr[1])."</a><BR>";
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
