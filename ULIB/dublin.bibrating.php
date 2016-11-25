<?php  
	include ("./inc/config.inc.php");
	html_start();
	$now=time();
	$s=tmq("select * from media where ID='$ID' ");
	if (tmq_num_rows($s)==0) {
		die("bib $ID not found");
	}
	include("./dublin.bibrating.inc.php");
	$setrate=floor($setrate);
	if ($giverate=="" && $_memid!="" && ($setrate>0 && $setrate<=5)) {
		$chk=tmq("select * from webpage_bibrating_log where bibid='$ID' and memid='$_memid' ",false);
		if (tmq_num_rows($chk)==0) {
			tmq("insert into webpage_bibrating_log set bibid='$ID' ,
			memid='$_memid' ,
			dt='$now' ,
			score='$setrate' 
			");
			bibrating_recal($ID);
		} 
	}

	bibrating_recal($ID);
	if ($giverate=="yes" && $_memid!="") {
		?><TABLE cellpadding=0 cellspacing=0 border=0 width=100% height=100%>
<TR>
	<TD align=center valign=middle
	style="background-image: url(./neoimg/bibrating/no.png); background-repeat: no-repeat; background-position: 50% 50%"
	><FONT class=smaller><?php echo getlang("ให้เรื่องนี้กี่คะแนนดี::l::How much score to give");
	$star="<img src='./neoimg/bibrating/small.png' width=16 height=16 border=0>";
	?>?</FONT><BR>
<TABLE cellpadding=0 cellspacing=0 border=0 >
<TR>
	<TD><A HREF="dublin.bibrating.php?ID=<?php echo $ID;?>&setrate=5"><B>5</B> <?php echo $star;echo $star;echo $star;echo $star;echo $star;?></A></TD>
</TR>
<TR>
	<TD><A HREF="dublin.bibrating.php?ID=<?php echo $ID;?>&setrate=4"><B>4</B> <?php echo $star;echo $star;echo $star;echo $star;?></A></TD>
</TR>
<TR>
	<TD><A HREF="dublin.bibrating.php?ID=<?php echo $ID;?>&setrate=3"><B>3</B> <?php echo $star;echo $star;echo $star;?></A></TD>
</TR>
<TR>
	<TD><A HREF="dublin.bibrating.php?ID=<?php echo $ID;?>&setrate=2"><B>2</B> <?php echo $star;echo $star;?></A></TD>
</TR>
<TR>
	<TD><A HREF="dublin.bibrating.php?ID=<?php echo $ID;?>&setrate=1"><B>1</B> <?php echo $star;?></A></TD>
</TR>
</TABLE>
<CENTER><A HREF="dublin.bibrating.php?ID=<?php echo $ID;?>" class=smaller2 style="color: darkred"><?php echo getlang("ยกเลิก::l::Cancel");?></A></CENTER>
	</TD>
</TR>
</TABLE><?php  
	
		die;
	}


	$s=tmq("select * from webpage_bibrating_sum where bibid='$ID' ");
	if (tmq_num_rows($s)==0) {
		$maintxt=getlang("ยังไม่เคยถูกให้คะแนน::l::Not rated yet");
		$foottxt=getlang("เชิญให้คะแนนเป็นคนแรก::l::Be the first");
	} else {
		$r=tmq_fetch_array($s);
		$score=number_format($r[votescore],1);
		$maintxt="<FONT style='font-size:40px;'>$score</FONT>";
		$votecount=number_format($r[votecount]);
		$foottxt=getlang("จากการให้คะแนน $votecount ครั้ง::l::From $votecount opinions");
	}
	if ($_memid=="") {
		$foottxt="";
		$votestr="<A HREF='$dcrURL/member/index.php?backto=".urlencode("$dcrURL/dublin.php?ID=$ID")."' target=_top><FONT class=smaller2>".getlang("กรุณาล็อกอินก่อนให้คะแนน::l::Please login before vote")."</FONT></A>";
	} else {
		$chk=tmq("select * from webpage_bibrating_log where bibid='$ID' and memid='$_memid' ");
		if (tmq_num_rows($chk)==0) {
			$votestr="<A HREF='dublin.bibrating.php?ID=$ID&giverate=yes'><FONT class=smaller2>".getlang("คลิกที่นี่เพื่อให้คะแนน::l::Click here to vote")."</FONT></A>";
		} else {
			$votestr="<FONT class=smaller2 color=darkgray>".getlang("คุณเคยให้คะแนนไปแล้ว::l::You rated this record.")."</FONT>";
		}
	}

	//for img
	$scoretxt=floor(($score*20)/5);
	$scoretxt=floor($scoretxt*5);
	//echo "[$scoretxt]";
	
?>
<TABLE cellpadding=0 cellspacing=0 border=0 width=100% height=100% bgcolor=#FFFFDD	style="background-image: url(./neoimg/bibrating/ratingbg.png); background-repeat: no-repeat; background-position: 0% 0%"
>
<TR>
	<TD align=center valign=middle
	style="background-image: url(./neoimg/bibrating/s<?php echo $scoretxt?>.png); background-repeat: no-repeat; background-position: 50% 50%; padding-top: 25px;"
	><BR>
	<?php echo $maintxt;?><BR><img src="./neoimg/spacer.gif" width=60 height=8 border=0><BR>
	<?php echo $foottxt;?><BR>
	<?php  
echo $votestr;
if (loginchk_lib("check")==true) {
	echo "<A HREF='./dublin.bibrating.hist.php?ID=$ID' target=_blank class=smaller2>[detail]";
	echo "</A>";
}

?><BR>

	</TD>
</TR>
</TABLE>