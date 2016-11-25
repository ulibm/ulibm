<?php 
set_time_limit(0);
include("../../inc/config.inc.php");
include("./_conf.php");
	include ("../globalfunc.php");

html_start();

$now=time();



function local_get($url) {
	$url=str_replace(' ','%20',$url);
	$handle = @fopen($url, "r");
	//echo "[$url]<BR>";
	if ($handle) {
		$buffer="";
		while (!feof($handle)) {
			$buffer .= fgets($handle, 4096);
		}
		//echo "[$buffer]";
		if (strlen($buffer)<3) {
			echo "<FONT SIZE=-2 COLOR=gray>".getlang("มีปัญหาในการเชื่อมต่อ::l::Connection Problems")." (read content)</FONT>";
			die;
		} 

	return "$buffer";

		@fclose($handle);
	} else {
	//	echo $searchuri;
		echo "<FONT SIZE=-2 COLOR=gray>".("มีปัญหาในการเชื่อมต่อ/Connection Problems")." (open url)</FONT>";
		die;
	}
}

?><div style='display:none'><?php 
mn_root("havester");
?></div><?php 

?><CENTER><SCRIPT LANGUAGE="JavaScript" SRC="timebar.php?timebarwidth=290">
<!--
//-->
</SCRIPT></CENTER><?php 

		$s=tmq("select * from ulibhavestlist where code='$code' ");
		if (tmq_num_rows($s)!=1) {
			die ("code '$code' notfound ");
		}
		$s=tmq_fetch_array($s);
		echo "
		<TABLE width=100% align=center>
		<TR>
			<TD>Running RelationCheck for: <B>$s[brief]</B><BR><FONT class=smaller2>";
		//printr($s);
			$checklist=tmq("select * from media_havest_id where havestpid='$code'  ");
			if (tmq_num_rows($checklist)==0) {
				echo "this site has no current data.";
			} else {
				$checklist=tmq("select * from media_havest_id where havestpid='$code' and lastcheckrelation=0 limit ".barcodeval_get("havester-limitnumrel"));
				if (tmq_num_rows($checklist)==0) {
					tmq("update media_havest_id set lastcheckrelation=0 where havestpid='$code'");
					$checklist=tmq("select * from media_havest_id where havestpid='$code' and lastcheckrelation=0 limit ".barcodeval_get("havester-limitnumrel"));
				} 
				$checkliststr="";
				while ($checklistr=tmq_fetch_array($checklist)) {
					$checkliststr.=":".$checklistr[bibid];
				}

			$tmp=local_get($s[url]."/_havester/cli/relcheck.php?data=".barcodeval_get("havester-tagstocheckdup")."&biblist=$checkliststr");
			//echo $tmp;
			//die;
			$index=explodenewline($tmp);
			//printr($index);
			$chk=unserialize($index[count($index)-1]);
			//printr($chk);
			@reset($index);
			$worked=0;
			$chkok=false;
			$sqlarray=Array();
			while (list($k,$v)=each($index)) {
				//echo "$k. ";
				//echo $v."<BR>";
				$dat=unserialize($v);
					$dat[hashes]=havester_formatkeyid(base64_decode($dat[hashes]));
					//printr($dat);
					if ($dat[ID]=="") {
						echo "<FONT COLOR=red>?</FONT>";
						return;
					}

					if ($dat[hashes]=="not_exists") {
						echo "<FONT COLOR=darkred>#</FONT>";
						echo "<!-- client deleted bibid $dat[ID]; -->";
						$chk=tmq("select * from media_havest_id where havestpid='$code' and bibid='$dat[ID]' ");
						$chk=tmq_fetch_array($chk);
						$chkmedia=tmq("select * from media_havest_id where  hashed='".addslashes($chk[hashed])."' ");
						if (tmq_num_rows($chkmedia)==0) { // has no other holder
							$chkmedia=tmq("select * from media where  keyid='".addslashes($chk[hashed])."'  ");
							$chkmedia=tmq_fetch_array($chkmedia);
							index_remove($chkmedia[ID]);
							tmq("delete from media where keyid='".addslashes($chk[hashed])."' ");
						}
						$chkmedia=tmq("select * from media where  keyid='".addslashes($chk[hashed])."'  ");
						$chkmedia=tmq_fetch_array($chkmedia);
						index_remove($chkmedia[ID]);
						tmq("delete from media_havest_id where havestpid='$code' and bibid='$dat[ID]' ");
						continue;
					}
					//check exists
					$chk=tmq("select * from media_havest_id where havestpid='$code' and bibid='$dat[ID]' ");
					$chk=tmq_fetch_array($chk);
					if ($chk[hashed]==$dat[hashes]) { // ok
					} else { // delete from local and tell client to re-checkable this bib
						$tmp=local_get($s[url]."/_havester/cli/relcheck.php?mode=resetbibdt&bibid=$dat[ID]");
						echo "<FONT COLOR=darkblue>!</FONT>";
						echo "<!-- Bib data changes: -->";
						//echo "[$tmp]";
						if ($tmp=="done") { // tell client ok
							echo "<FONT COLOR=darkblue>!</FONT>";
							echo "<!-- delete from local; -->";
							tmq("delete from media_havest_id where havestpid='$code' and bibid='$dat[ID]' ");
							$chkmedia=tmq("select * from media_havest_id where  hashed='".addslashes($chk[hashed])."' and havestpid<>'$code' ");
							if (tmq_num_rows($chkmedia)==0) { // has no other holder
								$chkmedia=tmq("select * from media where  keyid='".addslashes($chk[hashed])."'  ");
								$chkmedia=tmq_fetch_array($chkmedia);
								index_remove($chkmedia[ID]);
								tmq("delete from media where keyid='".addslashes($chk[hashed])."' ");
							}
						} else {
							echo "cannot tell clients, delete next time;";
						}
					}
					tmq("update media_havest_id set lastcheckrelation='0' where havestpid='$code' and bibid='$dat[ID]' ");

				$worked++;
			}
			echo "<BR>";




			} // end if has $code's havestpid
		?></FONT></TD>
		</TR>
		</TABLE>