<?php 
include("../inc/config.inc.php");
	head();
	mn_root("tb_editor");

	?>	<CENTER>
<?php 
if (!isset($e) || $e=="") {
	echo getval("str","tbedit_notspectb");
	die;
}
$act=($act);
$act2=($act2);
//////////////////////

if ($act=="add") {
?><FORM METHOD=POST ACTION="menu.php">
<INPUT TYPE="hidden" name=e value="<?php  echo $e?>">
<INPUT TYPE="hidden" name=act value="<?php  echo ("addaction")?>">
<TABLE border=1>

<?php 
			echo "<TR><TD>filed</TD><td>val</td></TR>";
		$rx="select * from tb_editor_field where editorid='$e' order by ordr,field";
		$rx=tmq($rx);
		while ($rx2=tmq_fetch_array($rx)) {
				$forcetextval="";
				if ($e=="tb_editor_tp" && $forceset_table1!="" && $rx2[field]=="table1") {
					$forcetextval=$forceset_table1;
				}
				if ($e=="tb_editor_tp" && $forceset_field1!="" && $rx2[field]=="field1") {
					$forcetextval=$forceset_field1;
				}

				echo "<TR><TD>" . $rx2['text'] . "</TD><td>";
				if ($rx2['type']=='listed') {
					$tmp=explode(",",$rx2['sourcedatatype']);
					echo "<SELECT NAME='$rx2[field]_val'>";
					foreach ($tmp as $i) {
						echo "<option value='$i'>$i";
					}
					echo "</SELECT>";
				}
				if ($rx2['type']=='text') {
					echo "<INPUT TYPE=text NAME='$rx2[field]_val' value='$forcetextval'>";
				}
				if ($rx2['type']=='number') {
					echo "<INPUT TYPE=text NAME='$rx2[field]_val' style='text-align:right' size=12>";
				}
				if ($rx2['type']=='longtext') {
					echo "<TEXTAREA NAME='$rx2[field]_val' ROWS='3' COLS='50'></TEXTAREA>";
				}
				if ($rx2['type']=='listfield' ) {
					echo "<SELECT NAME='$rx2[field]_val'>";
					$tmp="select * from $rx2[sourcedata1] order by $rx2[source1field]";
					$tmp=tmq($tmp);
					echo "<option value=''>";
					while ($tmp2 =tmq_fetch_array($tmp)) {
						echo "<option value='" . $tmp2[$rx2['source1field']] . "'>".$tmp2[$rx2['source1field']];
					}
					echo "</SELECT>";
				}
				
				echo "</td></TR>";
		}
		echo "<INPUT TYPE='hidden' name='linkoutfield' value='$linkoutfield'>";
		echo "<INPUT TYPE='hidden' name='linkoutval' value='$linkoutval'>";
		echo "<TR><td colspan=2><INPUT TYPE=submit></td></tr>";
?>
</TABLE></FORM><?php 
}
//////////////////////
if ($act=="addaction") {
	$s="select * from tb_editor where editorid='$e' ";
	$s=tmq($s,false);
	$s=tmq_fetch_array($s);
	$sql="insert into $s[tbname] set ";
	$rx="select * from tb_editor_field where editorid='$e'  ";
	$rx=tmq($rx);
	while ($rx2=tmq_fetch_array($rx)) {
		if ($rx2[field]=="storyline") {
			$POST[$rx2[field]."_val"]=$storyline;
		}

		$sql="$sql `$rx2[field]`='" . $POST[$rx2[field]."_val"] . "'  ," ;
	}
	$sql=trim($sql,",");
	tmq("$sql");
}
//////////////////////
if ($act=="edit") {
	$s="select * from tb_editor where editorid='$e' ";
	$s=tmq($s,false);
	$s=tmq_fetch_array($s);

		$rdata="select * from $s[tbname] where id='$act2' ";
		$rdata=tmq($rdata);
		$rdata=tmq_fetch_array($rdata);

?><FORM METHOD=POST ACTION="menu.php">
<INPUT TYPE="hidden" name=e value="<?php  echo $e?>">
<INPUT TYPE="hidden" name=act2 value="<?php  echo ($act2);?>">
<INPUT TYPE="hidden" name=act value="<?php  echo ("editaction")?>">
<TABLE border=1>

<?php 
			echo "<TR><TD>filed</TD><td>val</td></TR>";
		$rx="select * from tb_editor_field where editorid='$e' order by ordr,field";
		$rx=tmq($rx);

		while ($rx2=tmq_fetch_array($rx)) {
				echo "<TR><TD>" . $rx2['text'] . "</TD><td>";
				if ($rx2['type']=='listed') {
					$tmp=explode(",",$rx2['sourcedatatype']);
					echo "<SELECT NAME='$rx2[field]_val'>";
						echo "<option value='" .$rdata[$rx2['field']] . "' selected>" .$rdata[$rx2['field']] . " ";
					foreach ($tmp as $i) {
						echo "<option value='$i'>$i";
					}
					echo "</SELECT>";
				}
				if ($rx2['type']=='text') {
					echo "<INPUT TYPE=text NAME='$rx2[field]_val' value='" .$rdata[$rx2['field']] . "'>";
				}
				if ( $rx2['type']=='number') {
					echo "<INPUT TYPE=text NAME='$rx2[field]_val' value='" .$rdata[$rx2['field']] . "' size=12 style='text-align: right; font-weight: bold;'><I style='color: gray'>[num]</I>";
				}
				if ($rx2['type']=='longtext') {
					echo "<TEXTAREA NAME='$rx2[field]_val' ROWS='3' COLS='50'>" .$rdata[$rx2['field']] . "</TEXTAREA>";
				}

				if ($rx2['type']=='listfield' ) {
					echo "<SELECT NAME='$rx2[field]_val'>";
						echo "<option value='" . $rdata[$rx2['field']] . "'>".$rdata[$rx2['field']];
					$tmp="select * from $rx2[sourcedata1]";
					$tmp=tmq($tmp);
					echo "<option value=''>";
					while ($tmp2 =tmq_fetch_array($tmp)) {
						echo "<option value='" . $tmp2[$rx2['source1field']] . "'>".$tmp2[$rx2['source1field']] . " - [$tmp2[name]]";
					}
					echo "</SELECT>";
				}

				echo "</td></TR>";
		}
		echo "<INPUT TYPE='hidden' name='linkoutfield' value='$linkoutfield'>";
		echo "<INPUT TYPE='hidden' name='linkoutval' value='$linkoutval'>";
		echo "<INPUT TYPE='hidden' name='searchtb' value='$searchtb'>";
		echo "<INPUT TYPE='hidden' name='searchfield' value='$searchfield'>";
		echo "<TR><td colspan=2><INPUT TYPE=submit></td></tr>";
?>
</TABLE></FORM>


<?php 
}
//////////////////////
if ($act=="del") {
	$s="select * from tb_editor where editorid='$e' ";
	$s=tmq($s,false);
	$s=tmq_fetch_array($s);
	$sql="delete from $s[tbname] where id='".($act2)."'  ";
	tmq($sql);
}
/////////////////////
if ($act=="editaction") {
	$s="select * from tb_editor where editorid='$e' ";
	$s=tmq($s,false);
	$s=tmq_fetch_array($s);
	$sql="update $s[tbname] set ";
	$rx="select * from tb_editor_field where editorid='$e'  ";
	$rx=tmq($rx);

	while ($rx2=tmq_fetch_array($rx)) {
		if ($rx2[field]=="storyline") {
			$POST[$rx2[field]."_val"]=$storyline;
		}
		$sql="$sql `$rx2[field]`='" . $POST[$rx2[field]."_val"] . "'  ," ;
	}
	$sql=trim($sql,",");
	$sql="$sql where id='$act2' ";
	tmq("$sql");
}

/////////////////////
//จบ action procedure
////////////////////

$s="select * from tb_editor where editorid='$e' ";
$s=tmq($s,false);
if (tmq_num_rows($s)==0) {
	echo "ไม่มีการกำหนดข้อมูลมาให้ สำหรับการแก้ไขชุดตาราง $e <BR>จะจบการทำงาน";
	die;
}
$s=tmq_fetch_array($s);
echo "<B>การแก้ไขตาราง $s[tbname] </B> <small>[$s[editorid]] </small>$s[note] - <I>$s[longnote]</I>";
echo "<HR width=780>";
	echo "<A HREF='list.php'><B>Edition List</B></A> , ";
if ($s['is_allowadd']=='yes') {
	echo "<A HREF='menu.php?act=".("add")."&e=$e&linkoutfield=$linkoutfield&linkoutval=$linkoutval'>add</A>";
}
	echo " , <A HREF='import.php?editorid=$e' onclick=\"confirm('sure?')\">reimport</A>";

$r="select * from tb_editor_field where editorid='$e' order by ordr,text,id";
$r=tmq($r);
?></CENTER><TABLE border=0 cellpadding=2 cellspacing=1 bgcolor=333333 align=center>
<TR bgcolor=#DBD7D5><?php 
$fieldlist=Array();
while($r2=tfa($r)) { //printr($r2);
	$fieldlist[]=$r2[field];
?>
	<TD align=center>
<A HREF="menu.php?e=<?php  echo $e;?>&linkoutfield=<?php  echo $linkoutfield;?>&linkoutval=<?php  echo $linkoutval;?>&searchtb=<?php  echo $searchtb;?>&searchfield=<?php  echo $searchfield;?>&setorderby=<?php 
$orderinden="";
if ($setorderby=="$r2[field]"	) {
	$orderinden="v";
	echo $r2[field] ." desc";
} elseif ($setorderby=="$r2[field] desc") {
	$orderinden="^";
	echo $r2[field];
} else {
	echo $r2[field];
}
;?>&"><B><?php  echo $r2['text'];?></B></A> <B style="color: orange"><?php  echo $orderinden;?></B></TD>
<?php 
}
?><td><B>command</B></td>
</TR>
<TR bgcolor=#FFFFCC>
	<TD colspan="<?php echo count($fieldlist)+2?>">
<!-- 	start search form -->
<TABLE>
<FORM METHOD=GET ACTION="menu.php">
<INPUT TYPE="hidden" name=e value="<?php  echo $e?>">
<INPUT TYPE="hidden" name=linkoutfield value="<?php  echo $linkoutfield?>">
<INPUT TYPE="hidden" name=linkoutval value="<?php  echo $linkoutval?>">
	<TR>
	<TD> Find <INPUT TYPE="text" NAME="searchtb" value="<?php echo $searchtb;?>"> in
	<SELECT NAME="searchfield">
	<?php 
	reset ($fieldlist); 
	while (list ($key, $val) = each ($fieldlist)) { 
		$thissl="";
		if ($searchfield==$val) {
			$thissl=" selected ";
		}
	   echo "<OPTION VALUE='$val' $thissl>$val"; 
	} 
	?>
	</SELECT>
	<INPUT TYPE="submit" value=Search></TD>
</TR>
</FORM>
</TABLE>

<!-- end searchfrom -->
	</TD>
</TR>
	<?php 

$sql="select * from $s[tbname] where 1 ";

if ($searchtb!="") {
	$sql.=" and $searchfield like '%$searchtb%' ";
}

if ($linkoutfield!="") {
	$sql="$sql and $linkoutfield = '$linkoutval' ";
}
if ($setorderby=="" && $s[is_allowordr]=='yes') {
	$sql="$sql order by ordr";
}
if ($setorderby!="") {
	$sql="$sql order by $setorderby ";
}
//echo $sql;
$result=tmqp($sql,"menu.php?e=$e&linkoutfield=$linkoutfield&linkoutval=$linkoutval&searchtb=$searchtb&searchfield=$searchfield&setorderby=$setorderby");
$tmpi=0;
$tmpv[0]="f2f2f2";
$tmpv[1]="ffffff";
while ($row=tmq_fetch_array($result)) {
	$tmpi++;
	$tmpi2=($tmpi % 2);
?>
<TR bgcolor="<?php echo $tmpv[$tmpi2] ?>"
onmouseover="this.style.backgroundColor='#DBE0FB' " 
onmouseout="this.style.backgroundColor='<?php echo $tmpv[$tmpi2] ?>' " 
>
	<?php 
	$rx="select * from tb_editor_field where editorid='$e' order by ordr,text,id";
$rx=tmq($rx);
while ($rx2=tmq_fetch_array($rx)) {
	echo "<TD>" ;

	if ($rx2['linkout_editorid']!="") {
		echo " <A HREF='menu.php?e=" . $rx2['linkout_editorid'] . "&linkoutfield=$rx2[linkout_field]&linkoutval=" . $row[$rx2['field']] . "'>";
	}
	echo  strip_tags($row[$rx2['field']]) . "</A>&nbsp;</TD>";
}
?><td>
<?php 
if ($s['is_allowdel']=='yes') {
	echo "<A HREF='menu.php?act=".("del")."&act2=".("$row[id]")."&e=$e&linkoutfield=$linkoutfield&linkoutval=$linkoutval&searchtb=$searchtb&searchfield=$searchfield'
	onclick=\"return confirm('sure?\\n $row[id]  ');\"><FONT  COLOR=orange>del</FONT></A>";
	echo "-";
}
	echo "<A HREF='menu.php?act=".("edit")."&act2=".("$row[id]")."&e=$e&linkoutfield=$linkoutfield&linkoutval=$linkoutval&searchtb=$searchtb&searchfield=$searchfield'>edit</A> ";
if ($s['is_allowordr']=='yes') {
	echo "-";
	echo "	<nobr><A HREF='ordr.php?rand=" . randid() . "&". ordr_geturl(ncode("menu.php?e=$e&linkoutfield=$linkoutfield&startrow=$startrow&linkoutval=$linkoutval&searchtb=$searchtb&searchfield=$searchfield&rand=".randid()),$s[tbname],$linkoutfield,$linkoutval,'ordr','id',$row['id'],'up') . "'>up</A>";

	echo "*<A HREF='ordr.php?rand=" . randid() . "&". ordr_geturl(ncode("menu.php?e=$e&linkoutfield=$linkoutfield&startrow=$startrow&linkoutval=$linkoutval&searchtb=$searchtb&searchfield=$searchfield&rand=".randid()),$s[tbname],$linkoutfield,$linkoutval,'ordr','id',$row['id'],'down') . "'>down</A></nobr>";
}
?></td>
</TR>
<?php 
}
?>

<!-- bottom column -->

<TR bgcolor=#DBD7D5><?php 
$r="select * from tb_editor_field where editorid='$e' order by ordr,text,id";
$r=tmq($r);
$duprulechk=tmq_dump("tb_editor_tp","field1","id"," where table1='$e' ");
while($r2=tmq_fetch_array($r)) {
?>
	<TD align=center><?php 
if ($duprulechk[$r2['text']]!="")	 {
	echo "<a href='menu.php?act=_101_100_105_116_0&e=tb_editor_tp&act2=".($duprulechk[$r2['text']])."' style='color: darkred;' title='edit'>";
} else {
	echo "<a href='menu.php?act=_97_100_100_0&e=tb_editor_tp&forceset_table1=$e&forceset_field1=$r2[text]' style='color: #0033CC;' title='add new'>";
}
echo $r2['text'];?></TD>
<?php 
}
?><td><B>&lt;-addrule</B></td>
</TR>


</TABLE><CENTER><HR width=780>
<?php 
echo $_pagesplit_btn_var;
if ($e=="tb_editor_tp") {
?>
<U><B>การใช้งาน</B></U><BR>
<B>table1</B> ตาราง (ที่จะเพิ่มกฏให้)<BR>
<B>field1</B> ฟิลด์ (ที่จะเพิ่มกฏให้)<BR>
<B>type</B> ประเภทของมัน (เลือกได้)<BR>
&nbsp;- กรณี linkout -<BR>
<B>linkout_editorid</B> ใส่ editorid ที่จะลิงค์ไป limit ด้วยฟิลด์นี้<BR>
<B>linkout_field</B>  ใส่ฟิลด์ที่จะลิงค์ไป limit ด้วยฟิลด์นี้<BR>
&nbsp;- กรณี listfield -<BR>
<B>sourcedata1</B> สำหรับ type=listfield ใส่ชื่อตารางที่จะดึงข้อมูล <BR>
<B>source1field</B> สำหรับ type=listfield ใส่ชื่อฟิลด์ที่จะดึงข้อมูล<BR>
&nbsp;- อื่น ๆ -<BR>
<B>sourcedatatype</B> สำหรับ type=listed ใส่ yes,no,ok<BR>
<BR><BR></CENTER>
<?php 
}

foot();
?>