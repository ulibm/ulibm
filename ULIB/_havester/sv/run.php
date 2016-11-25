<?php 
set_time_limit(0);
include("../../inc/config.inc.php");
include("./_conf.php");
include ("../globalfunc.php");

html_start();

$now=time();
$tagdb=tmq_dump("bkedit","fid","fid");
$tagdb["leader"]="leader";

function local_get($url) {
	$url=str_replace(' ','%20',$url);
	$handle = @fopen($url, "r");
	echo "[$url]<BR>";
	if ($handle) {
		$buffer="";
		while (!feof($handle)) {
			$buffer .= fgets($handle, 4096);
		}
		if (strlen($buffer)<5) {
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

?><CENTER><SCRIPT LANGUAGE="JavaScript" SRC="timebar.php?timebarwidth=690">
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
			<TD>Running for: <B>$s[name]</B><BR><FONT class=smaller2>";
		//printr($s);

			$tmp=local_get($s[url]."/_havester/cli/index.php?cmd=generalfetch&svdt=".($now)."&lastdt=".$s[dt]."&data=".barcodeval_get("havester-tagstocheckdup")."&limitnum=".barcodeval_get("havester-limitnum"));
			//echo $tmp;
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
				echo "<FONT COLOR=darkgreen>#<WBR /></FONT>";
				//echo $v;
				$dat=unserialize($v);
				//printr($dat);

				if ($dat[counted]=="" && $dat[ID]=="") {
					echo "<FONT COLOR=darkred>!<WBR /></FONT>";
					echo "<!-- empty round, -->";
					continue;
				} 
				if (trim($dat[MARCDATA])!="") {
					//echo $dat[hashes];
					$dat[hashes]=havester_formatkeyid(base64_decode($dat[hashes]));
					echo $dat[hashes];
					// import to db
					//echo $dat[MARCDATA];
					//echo "[$dcrs--$pathtosave]";
					$tmpmarc=(base64_decode($dat[MARCDATA]));
					$tmpmarc=unserialize($tmpmarc);
					@reset($tmpmarc);
					$tmpmarcsql=" insert into media set ID='',";
					while (list($tmpmarck,$tmpmarcv)=each($tmpmarc)) {
						if (in_array($tmpmarck,$tagdb) && strlen($tmpmarck)==6) {
							$tmpmarcsql.="$tmpmarck='".addslashes($tmpmarcv)."',";
						}
					}
					$tmpmarcsql=trim($tmpmarcsql,',');
					$tmpmarcsql.=" , masterfrom='$code',keyid='".addslashes($dat[hashes])."' ,importid='havester:$code' ";
					$randid="a".randid();
					$sqlarray[$randid][sql]=$tmpmarcsql;
					$sqlarray[$randid][keyid]=$dat[hashes];
					$sqlarray[$randid][bidid]=$dat[ID];
					//echo $tmpmarcsql;
					//
				}
				$worked++;
				//echo "$dat[counted]-$worked,";
				if (floor($dat[counted])!=0) {
					if (floor($dat[counted])==($worked-1)) {
						//ok alldone and count ok
						$chkok=true;
					} else {
						//not ok count not equal
					}
				}
				//printr($dat);
				if ($dat[ID]=="") {
					echo "empty ID,";
					continue;
				}
				//$sql="delete from media_havest_id where havestpid='$code' and bibid='$dat[ID]' and hashed<>'$dat[hashes]'  ";				mq($sql);				$sql="insert into media_havest_id set havestpid='$code' , bibid='$dat[ID]' , hashed='$dat[hashes]' lastupdate='$now'";				tmq($sql);
			}
			echo "<BR>";
			if ($chkok==true) {
				echo "final check ok";
				//tmq("delete from media_havest_id where havestpid='$code' and marked='no' ");
				// check ok
				//tmq("update ulibhavestlist set stat='getmidlist' where code='$code' ");
				@reset($sqlarray);
				while (list($k,$v)=each($sqlarray)) {
					$chk=tmq("select ID from media where keyid='".addslashes($sqlarray[$k][keyid])."' ");
					if (tmq_num_rows($chk)==0) {
						tmq($sqlarray[$k][sql]);
						$newid=tmq_insert_id();
					}
					$chk2=tmq("select ID from  media_havest_id where hashed='".addslashes($sqlarray[$k][keyid])."' and havestpid='$code' limit 1 ");
					//echo "-[".tmq_num_rows($chk2)."]";
					if (tmq_num_rows($chk2)==0) {
						tmq("insert into media_havest_id set hashed='".addslashes($sqlarray[$k][keyid])."' , bibid='".$sqlarray[$k][bidid]."' , havestpid='$code' ,lastupdate='$now' ");
					}
					if (tmq_num_rows($chk)==0) {
						index_reindex($newid);
					} else {
						$oldbibid=tmq_fetch_array($chk);
						index_reindex($oldbibid[ID]);
					}
					}
				tmq("update ulibhavestlist set dt='$time' where code='$code' ");
			} else {
				//printr($chk);
				die("error final check not ok $worked");
			}





		?></FONT></TD>
		</TR>
		</TABLE>