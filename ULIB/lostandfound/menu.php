<?php 
$tagdb=tmq_dump("webpage_lostandfound_tag","id","name");

?><style>
.anspointmn {
	text-align: center;
	padding-top: 5;
	padding-bottom: 5;
	cursor: hand; cursor: pointer;
	background-image: url(../neoimg/mocalenclip.gif); background-repeat: no-repeat;
}
.anspointmn a {
	color:white;
	text-align: center;
	font-size: 20;
	cursor: hand; cursor: pointer;
}
.anspointmnsmall a {
	color:white;
	font-size: 16;
	cursor: hand; cursor: pointer;
}

.anspointmnsmall {
	text-align: center;
	padding-top: 5;
	padding-bottom: 5;
	cursor: hand; cursor: pointer;
	background-image: url(../neoimg/mocalenclip.gif); background-repeat: no-repeat;
}
.anspointnum {
	color:#676767;
	text-align: center;
	font-size: 13;
}
</style><TABLE cellpadding=0 cellspacing=5 border=0 width=200 align=center>
<?php if (library_gotpermission("lostandfound")) {
?>
<TR>
	<TD class=anspointmnsmall style="background-color: #7A3638"><A HREF="add.php" style='color:white'><?php  echo getlang("โพสท์รายการใหม่::l::Add new record");?></A></TD>
</TR>
<?php }?>
<TR>
	<TD class=anspointmn style="background-color: #7A3638"><A HREF="index.php?cate=new" style='color:white'><?php  echo getlang("รายการของหาย::l::Lost and found items");?></A></TD>
	<TD class=anspointnum ><?php  
$c=tmq("select * from webpage_lostandfound where cate='new' ");
echo number_format(tmq_num_rows($c));
?></TD>
</TR>
<TR>
	<TD class=anspointmn style="background-color: #34743E"><A HREF="index.php?cate=solved" style='color:white'><?php  echo getlang("มีผู้มารับแล้ว::l::Picked up items");?></A></TD>
		<TD class=anspointnum ><?php  
$c=tmq("select * from webpage_lostandfound where cate='solved' ");
echo number_format(tmq_num_rows($c));
?></TD>
</TR>
<TR>
	<TD class=anspointmnsmall style="background-color: #433232"><A HREF="index.php?cate=destroy" style='color:white'><?php  echo getlang("รายการที่ทำลายทิ้งแล้ว::l::Abandoned items");?></A></TD>
		<TD class=anspointnum ><?php  
$c=tmq("select * from webpage_lostandfound where cate='destroy' ");
echo number_format(tmq_num_rows($c));
?></TD>
</TR>
<?php 
if (library_gotpermission("lostandfound")) {
	?><TR>
	<TD class=anspointmnsmall style="background-color: #433232"><A HREF="index.php?cate=hide" style='color:white'><?php  echo getlang("รายการที่ถูกซ่อน::l::Hidden items");?></A></TD>
		<TD class=anspointnum ><?php  
$c=tmq("select * from webpage_lostandfound where cate='hide' ");
echo number_format(tmq_num_rows($c));
?></TD>
</TR><?php 
}
?>

<TR>
	<TD align=center><CENTER><?php 
	
	function local_tagdsp($r) {
		global $tagid;
		echo "<TABLE style=\"display:inline;align=absmiddle\" cellpadding=0 cellspacing=0 border=0>
		<TR valign=middle>
			<TD width=10><img src='taghead.png' align=absmiddle border=0 ";
			echo " style=\"background-color: #C1E0F4; \" ";
		echo "></TD><TD style=\"border-width: 1px; border-style: solid; padding: 0 5 0 5 ;border-left-width: 0px; height: 18px; ";
			echo "border-color: #336633; background-color: #C1E0F4; ";
		echo " ;  \" ><nobr><span class=smaller2
		>";
			//echo "<img src='./neoimg/bibtag/add.png' align=absmiddle border=0 > ";
			if ($tagid!=$r[id]) {
			echo "<A class=smaller2 HREF='index.php?cate=tags&tagid=$r[id]'>";
			echo getlang($r[name]);
			echo "</A><BR>";
			} else {
			echo "<B class=smaller2>".getlang($r[name])."</B><BR>";
			}
		echo "</span>";
		echo "</nobr></TD>
		</TR>
		</TABLE>&nbsp;  ";
	}


	echo "<B class=smaller>".getlang("แท็ก::l::Tags")."</B><BR>";
$ts=tmq("select * from webpage_lostandfound_tag order by name");
while ($tsr=tmq_fetch_array($ts)) {
	local_tagdsp($tsr);
}
	?></CENTER></TD>
</TR>
</TABLE>