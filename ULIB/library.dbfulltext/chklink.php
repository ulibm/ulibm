<?php  //พ
include("../inc/config.inc.php");
head();
$_REQPERM="dbfulltextchkurl";
if (!library_gotpermission($_REQPERM)) {
	die('_REQPERM $_REQPERM');
}
if ($first=="yes") {
	tmq("update media_ftitems set errorflag='no' ");
}

$sql ="select * from media_ftitems where errorflag='no' and uploadtype='url'  limit 20" ;
$s=tmq($sql);

if (tmq_num_rows($s)==0) {
	?>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
		alert("Done");
	//-->
	</SCRIPT>
	<?php 
	redir("menu.php",1);
	die;
}

mn_lib();


$done=tmq("select * from media_ftitems where errorflag='yes' and uploadtype='url' ");
$done=tmq_num_rows($done);
$all=tmq("select * from media_ftitems where uploadtype='url' ");
$all=tmq_num_rows($all);

	?><BR><BR>
	<CENTER><TABLE width=500 align=center>
	<TR>
		<TD><?php 
	echo html_graph("V",$done,$all,20,500,"#3DB66D");
?></TD>
	</TR>
	</TABLE><BR><?php  echo number_format($done)."/".number_format($all);?></CENTER>
	<?php 

function local_chkuri($link,$id){
	//echo "<br>".($link)."<br>";
	$ch = curl_init($link); // get cURL handle
	$link = str_replace(" ", '%20', $link);
	//echo "<br>".($link)."<br>";
		$timeout=30;
        // set cURL options
        $opts = array(CURLOPT_RETURNTRANSFER => true, // do not output to browser
                                  CURLOPT_URL => $link,            // set URL
                                  CURLOPT_NOBODY => true,                 // do a HEAD request only
                                  CURLOPT_TIMEOUT => 30);   // set timeout
        curl_setopt_array($ch, $opts); 

      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: text/html')); 
      curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_exec($ch); // do it!

        $retval = curl_getinfo($ch, CURLINFO_HTTP_CODE) ; // check if HTTP OK
		//echo("[$retval]");

        curl_close($ch); // close handle
	if ("$retval"!="200") {
		tmq("update media_ftitems set errorflag='yes', errorcount=errorcount+1 where id=$id",false);
		$meldung="<b>$link <font color=\"red\"> down</font></b><BR>";
	}else{
		tmq("update media_ftitems set errorflag='yes',errorcount=0  where id=$id",false);
		$meldung="<a href=\"$link\" target=_blank>$link<b><font color=\"darkgreen\"></a> OK</font></b><BR>";
	}
		//echo "local_chkuri($link,$id)=$meldung"; die;

	return $meldung;
}

$now=time();
?><CENTER><?php 
while ($r=tmq_fetch_array($s)) {
	//printr($r);
	echo local_chkuri($r[filename],$r[id]);
}
?></CENTER><?php 
redir("chklink.php?randid=".randid(),1);
foot();
?>