<?php 
    ;
	include ("./inc/config.inc.php");

$shf=tmq("select * from media_place_shelf where id='$id'  ");
if (tmq_num_rows($shf)==0 ) {
	?><SCRIPT LANGUAGE="JavaScript">
	<!--
		alert("<?php  echo getlang("ขออภัย ชั้นวางทรัพยากรที่ต้องการ::l::Sorry, shelf id not found");?>");
		top.location="<?php  echo $dcrURL?>";
	//-->
	</SCRIPT><?php 
	die;
}
$shf=tmq_fetch_array($shf);
	head();
	mn_web("webpage");


?><img src="<?php  echo $dcrURL?>neoimg/spacer.gif" width=700 height=10><BR><TABLE width="<?php  echo $_TBWIDTH?>" align=center border=0 cellpadding=0 cellspacing=0>
<TR valign=top>
	<TD width=165 align=center class=smaller><?php 
	$slist=tmq("select * from media_place_shelf where pid='$shf[pid]' order by name ");
	if (tmq_num_rows($slist)!=0) {
		echo getlang("คลิกเพื่อเลือกตู้ที่อยู่ใกล้กัน::l::Clice to view near by shelves");
		echo "<BR>";
		while ($slistr=tmq_fetch_array($slist)) {
			echo " <A HREF='shelfbrowser.php?id=$slistr[id]' class=a_btn>".getlang($slistr[name])."</A><BR>";
		}
		echo "" . getlang("หรือ::l::or") . "<BR>";
	}
		echo "<A HREF='itemplaces.php' class=a_btn>" . getlang("คลิกนี่นี่เพื่อดูสถานที่จัดเก็บทั้งหมด::l::click here to see all shelves") . "</A><BR>";
	?></TD>
	<TD style="padding-left:10"><?php 
	$sql="select * from media_mid where sortcalln>'$shf[startc]' and sortcalln<'$shf[endc]' and 1 ";
	if ($shf[mdtype]!="") {
		$sql.=" and RESOURCE_TYPE='$shf[mdtype]' ";
	}
		$s=tmqp($sql."  order by sortcalln ","shelfbrowser.php?id=$id");

?><TABLE border=0 cellpadding=0 cellspacing=0 width="100%">
<TR><TD height=20 background="<?php  echo "$dcrURL"."neoimg/bookcase/header.jpg";?>" colspan=5
align=right><FONT class=smaller COLOR="#695B3D"><?php  echo getlang($moddb[$mode]);?>&nbsp; &nbsp;</FONT></TD></TR>
<?php  
$i=0;
$perrow=5;
if (tmq_num_rows($s)==0) {
echo "<TR style='background-image:url($dcrURL"."neoimg/bookcase/background.jpg);' valign=top>
	<TD width=10 background='$dcrURL"."neoimg/bookcase/lists.jpg'></TD>
	<TD width=2><img src='$dcrURL"."neoimg/bookcase/mask_left.png'></TD>
	<TD style='height: 240px; padding-bottom: 20' valign=middle align=center> no items
	";

}
while ($r=tmq_fetch_array($s)) {
	$tagclosed=false;
	if ($i % $perrow==0) {
		echo "<TR style='background-image:url($dcrURL"."neoimg/bookcase/background.jpg);' valign=top>
		<TD width=10 background='$dcrURL"."neoimg/bookcase/lists.jpg'></TD>
		<TD width=2><img src='$dcrURL"."neoimg/bookcase/mask_left.png'></TD>
		<TD style='height: 240px; padding-bottom:7' valign=bottom>";
	}
	//printr($r);
	$text="<FONT class=smaller2 color=#49290A><BR>".marc_getmidcalln($r[bcode])."</FONT>";
	
	echo res_icon($r[pid]," style='display:inline; margin: 0 0 0 0; ' ",$text);
	//echo $i." ".marc_gettitle($r[bibid])."<BR>";
?>

<?php 
	$i++;
	if ($i % $perrow==0) {
		echo "</TD>
		<TD width=2><img src='$dcrURL"."neoimg/bookcase/mask_right.png'></TD>
		<TD width=10 background='$dcrURL"."neoimg/bookcase/lists.jpg'></TD>
		</TR>";
		$tagclosed=true;
	}
}	
if ($tagclosed==false) {
	echo "</TD>
		<TD width=2><img src='$dcrURL"."neoimg/bookcase/mask_right.png'></TD>
		<TD width=10 background='$dcrURL"."neoimg/bookcase/lists.jpg'></TD>
		</TR>";
}
echo $_pagesplit_btn_var;
?>
</TABLE>

<?php 

	?></TD>
</TR>
</TABLE><?php 





	foot();
?>