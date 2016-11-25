<TABLE width=100% align=center cellpadding=0 cellspacing=0 border=0 >
<FORM METHOD=POST ACTION="">
<SCRIPT LANGUAGE="JavaScript">
<!--
	function webjump(wh) {
		wha=wh.split('|');
		targ=wha[1];
		url=wha[0];
		//eval(targ+".location='"+url+"'");
		window.open(url,targ);
	}
//-->
</SCRIPT>
	<TR>
	<TD  align=center class=smaller><?php 
	echo getlang("ไปยังหัวข้อเว็บบอร์ด::l::Jump to webboard category");
?> &nbsp; <SELECT NAME="jumpmenu"  style="font-size: 12px;" onchange="webjump(this.value)">
		<OPTION VALUE="" SELECTED >-</OPTION>
<?php 
$ismanager=loginchk_lib("check");

$sql2 ="SELECT *  FROM webboard_boardcate where 1 "; 
if ($ismanager!=true) {
	$sql2 = "$sql2 and isshowtouser='yes' ";
}
$sql2 = "$sql2 order by ordr,name";

$s=tmq($sql2);

while ($mnr=tmq_fetch_array($s)) {
	$link="viewforum.php?ID=$mnr[id]";
	$target="_self";

	?><OPTION VALUE="<?php echo $link;?>|<?php echo $target;?>"  ><?php  echo getlang($mnr[name]);?></OPTION>
	<?php 
}
?>
	</SELECT></TD>
</TR>
</FORM>
</TABLE>