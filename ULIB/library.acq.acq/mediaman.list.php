<?php 
	;
	include ("../inc/config.inc.php");
	include ("./local.inc.php");
if ($edit=="") {
	echo "var not found";
	die;
}
if ($del!="") {
	tmq("delete from acq_mediasent where id='$del' ");
}
if ($set!="") {
	tmq("update  acq_mediasent  set status='$setto' where id='$set' ");
}
if ($sendtocatalog!="") {
	$s=tmq("select * from acq_media where id='$sendtocatalog'  ");
	$s=tmq_fetch_array($s);
	tmq("
	insert into acq_tocatalog set

	setbudget='$setbudget]',
d_titl='$s[d_titl]',
d_auth='$s[d_auth]',
refcode='$refcode',
d_yea='$s[d_yea]',
d_publ='$s[d_publ]',
d_isbn='$s[d_isbn]',
d_edition='$s[d_edition]',
d_imprint='$s[d_imprint]',
d_mdtype='$s[d_mdtype]',
amount='$s[amount]',
price='$s[price]'
	");

}

	//redir("mediaman.list.php?edit=$edit");
	html_start();
?>
<TABLE>
<FORM METHOD=POST ACTION="mediaman.list.php?edit=<?php  echo $edit?>">
<TR>
	<TD><?php  echo getlang("หาจากรหัสอ้างอิง::l::Search by ref.code");?> <INPUT TYPE="text" NAME="code"> <INPUT TYPE="submit" value="<?php  echo getlang("ค้นหา::l::Search");?>">
	<?php 
	if ($code!="") {
		echo "<A HREF='mediaman.list.php?edit=$edit' class=a_btn>".getlang("แสดงทั้งหมด::l::Show all")."</A>";
	}
	?>
	</TD>
</TR>
</FORM>
</TABLE>
<TABLE width=100% bgcolor=black cellspacing=1>
<TR bgcolor=f0f0f0>
	<TD width=20 align=center><nobr>-</TD>
	<TD width=20><nobr><B><?php  echo getlang("เลขอ้างอิง::l::ref.code");?></B></TD>
	<TD><nobr><B><?php  echo getlang("ชื่อเรื่อง::l::Title");?>/ISBN</B></TD>
	<TD width=30 align=center><B><?php  echo getlang("สถานะ::l::Status");?></B></TD>
	<TD width=30 align=center><nobr><B><?php  echo getlang("ส่งให้ Catalogue::l::Send to Catalogue");?></B></TD>
	<TD width=30 align=center>-</TD>
</TR>
<?php 
$s=("select * from  acq_mediasent where acq='$edit'  ");
if ($code!="") {
	$s.=" and id='$code' ";
}
$s.=" order by media";
$s=tmqp($s,"mediaman.list.php?edit=$edit");
$c=0;
while ($r=tmq_fetch_array($s)) {
	$c++;
	$md=tmq("select * from acq_media where id='$r[media]' ");
	$md=tmq_fetch_array($md);

	$info="ชื่อเรื่อง $md[d_titl]
ชื่อผู้แต่ง=$md[d_auth]
เลขมาตรฐาน=$md[d_isbn]
ปีพิมพ์=$md[d_yea]
สำนักพิมพ์=$md[d_publ]
พิมพ์ครั้งที่=$md[d_edition]
พิมพ์ลักษณ์=$md[d_imprint]
ประเภทวัสดุ=$md[d_mdtype]
ราคา=$md[price]
จำนวน=$md[amount]
Note=$md[note]
	";
$info=addslashes($info);
$info=str_replace("
","\\n",$info);
?><TR bgcolor=ffffff>
	<TD width=20><nobr><?php  echo $startrow+$c?></TD>
	<TD width=20><nobr><?php  echo $r[id]?></TD>
	<TD><A class=a_btn HREF="#" onclick="alert('<?php  echo $info?>'); return false"><?php 
$tmp=tmq("select * from acq_media where id='$r[media]' ");	
$tmp=tmq_fetch_array($tmp);
echo $tmp[d_titl]."/".$tmp[d_isbn]
?></A></TD>
	<TD width=30 align=center><nobr><?php 
if ($r[status]!="available") {
	echo "<A class=a_btn HREF=\"mediaman.list.php?edit=$edit&set=$r[id]&setto=available&startrow=$startrow\">".getlang("ไม่ได้::l::Not available")."</A>";
} else {
	echo "<A class=a_btn HREF=\"mediaman.list.php?edit=$edit&set=$r[id]&setto=notavailable&startrow=$startrow\">".getlang("ได้แล้ว::l::Available")."</A>";
}
?></TD>
	<TD  align=center><nobr><?php 
$tmp=tmq("select * from acq_tocatalog where refcode='$r[id]' ");	
if (tmq_num_rows($tmp)==0) {
?><A class=a_btn HREF="mediaman.list.php?startrow=<?php  echo $startrow?>&sendtocatalog=<?php  echo $r[media]?>&refcode=<?php  echo $r[id]?>&edit=<?php  echo $edit?>"><?php  echo getlang("ส่งให้ Catalogue::l::Send to Catalogue");?></A>
<?php 
} else {
?><?php  echo getlang("ส่งไปแล้ว::l::Sent");?><?php 

}	
?>
</TD>
	<TD align=center><A class=a_btn HREF="mediaman.list.php?edit=<?php  echo $edit;?>&del=<?php  echo $r[id]?>&startrow=<?php  echo $startrow?>" onclick="return confirm('ลบรายการ?');"><?php  echo getlang("ลบ::l::Delete");?></A></TD>
</TR><?php 
}

echo $_pagesplit_btn_var;

?>

</TABLE>