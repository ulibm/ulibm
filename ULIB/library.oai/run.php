<?php 
set_time_limit(0);
include("../inc/config.inc.php");
head();// พ
include("_REQPERM.php");
$tmp=$_SERVER[HTTP_REFERER];
$tmp=pathinfo($tmp);
//printr($tmp); die;
if ($basename=="") {
   //skip urlwalker
} else {
   $tmp=mn_lib();
}
pagesection($tmp);
$s=tmq("select * from oai_repo where id='$repid' ");
if (tnr($s)!=1) {
	html_dialog("Error","Repository id='$repid' not found ");
	foot();
	die;
}
$s=tfa($s);
html_dialog("Information","<b>$s[name]</b><br>$s[url]");
//printr($s);
?><table width=<?php  echo $_TBWIDTH?> align=center>
<tr>
	<td><?php 
$u=$s[url];
$ui="$u?verb=Identify";
//echo $ui;
if ($processed!="yes") {
	/////////////////////////////////////////
	echo "Getting Identify: ";
	$xml_string=file_get_contents($ui);
	$xml = simplexml_load_string($xml_string);
	$json = json_encode($xml);
	$aa = json_decode($json,TRUE);
	echo $aa[Identify][repositoryName]."<br>";
	tmq("update oai_repo set uidentify='".serialize($aa)."' where id='$repid' ");
	/////////////////////////////////////////
	$uf="$u?verb=ListMetadataFormats";
	echo "Getting Available Formats:<br> ";
	$xml_string=file_get_contents($uf);
	$xml = simplexml_load_string($xml_string);
	$json = json_encode($xml);
	$aa = json_decode($json,TRUE);
	if (is_array($aa[ListMetadataFormats][metadataFormat][0])) {
		//echo "is_array";
		$tmpa=$aa[ListMetadataFormats][metadataFormat];
		//
	} else {
		//
		echo "not array";
		$tmpa=Array();
		$tmpa[0]=$aa[ListMetadataFormats][metadataFormat];

	}
		//$tmpa=$aa[ListMetadataFormats][metadataFormat];
	//printr($tmpa); die;
	echo " &nbsp;&nbsp;&nbsp;";
	@reset($tmpa);
	$pass=false;
	while (list($k,$v)=each($tmpa)) {
		if ($v[metadataPrefix]=="oai_dc") {
			$pass=true;
			echo "<font color=darkgreen>";
		} else {
			echo "<font color=777777>";
		}
		echo " [".$v[metadataPrefix]."] </font> ";
	}
	echo "<br>";
	//printr($tmpa); die;
	if ($pass==true) {
		echo " MetadataFormat OK (Found oai_dc) <br>";
	} else {
		html_dialog("Error","Repository id='$repid' not provide oai_dc ");
		foot();
		die;
	}
	tmq("update oai_repo set uformat='".serialize($aa)."' where id='$repid' ");

	//delete old
	tmq("delete from oai_repo_i where code='$s[code]' ");
	tmq("delete from index_db where remoteindex='oai-$s[code]' ");
}

$s=tmq("select * from oai_repo where id='$repid' ");

//printr($aa);
$s=tfa($s);
$u=$s[url];
echo "Getting Records:<br> ";

$ur="$u?verb=ListIdentifiers";
if ($resumptionToken!="") {
	echo " Resume code: [$resumptionToken]<br>";
	$ur=$ur."&resumptionToken=".urlencode($resumptionToken);
} else {
	$ur=$ur."&metadataPrefix=oai_dc";
}
//echo "[$ur]";

	$xml_string=file_get_contents($ur);
	$xml = simplexml_load_string($xml_string);
	//echo "[$xml]";
	$json = json_encode($xml);
	$aa = json_decode($json,TRUE);
	//printr($aa);
	$tmpa= $aa[ListIdentifiers][header];
	echo " &nbsp;&nbsp;&nbsp;";
	@reset($tmpa);
	$imported=0;
	while (list($k,$v)=each($tmpa)) {
		tmq("insert into oai_repo_i set code='$s[code]' ,
		identifier='".addslashes($v[identifier])."',
		data=''
		");
		$imported=$imported+1;
	}
	echo "Imported: ".number_format($imported)."<br>";
	echo " &nbsp;&nbsp;&nbsp;All in site: ".number_format(tnr(tmq("select id from oai_repo_i where code='$s[code]'")))."<br>";
	$redirpath="fetch.php?repid=$repid&processed=yes";
	//$redirpath="index.php";
	if (trim($aa[ListIdentifiers][resumptionToken])!="") {
		$redirpath=$PHP_SELF."?repid=$repid&processed=yes&resumptionToken=".urlencode($aa[ListIdentifiers][resumptionToken]);
	}
	//echo $redirpath;
	redir($redirpath,0);
	echo "<br><br>Redirecting...";
?></td>
</tr>
</table><?php 
foot(); 
?>