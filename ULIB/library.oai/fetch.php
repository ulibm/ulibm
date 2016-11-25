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
		echo "All in site: ".number_format(tnr(tmq("select id from oai_repo_i where code='$s[code]'")))."<br>";
		echo "Fetched: ".number_format(tnr(tmq("select id from oai_repo_i where code='$s[code]' and data<>'' ")))."<br>";

$u=$s[url];
$all=tmq("select * from oai_repo_i where code='$s[code]' and data='' limit 10 ");
if (tnr($all)==0) {
	html_dialog("Done","Finish fetching");
	foot();
	die;
}
$indexdb=tmq_dump2("index_ctrl","code","name");
$indexdbfid=tmq_dump2("index_ctrl","code","fid");
$mapdb=Array();
@reset($indexdb);
while (list($k,$v)=each($indexdb)) {
	$tmp=explodenewline(barcodeval_get("oaiman_map-$k"));
	$mapdb[$k]=arr_filter_remnull($tmp);
}
//$mapdb=arr_filter_remnull($mapdb);

//printr($mapdb); die;
while ($r=tfa($all)) {
	echo "Fetching record: [$r[identifier]] :";
	$ui="$u?verb=GetRecord&metadataPrefix=oai_dc&identifier=".stripslashes($r[identifier]);
	//echo "[$ui]<br>\n";
	$xml_string=file_get_contents($ui);
	$xml = @simplexml_load_string($xml_string);
	//echo "xml_string=[$xml_string]";
	$json = json_encode($xml);
	//echo "[$xml_string]";
	$aa = json_decode($json,TRUE);
	tmq("update oai_repo_i set data='".addslashes($xml_string)."' where code='$s[code]' and id='$r[id]' ");
	$str="";
	$str=($xml_string);
	$str=str_replace("<![CDATA[","",$str);
	$str=str_replace("]]>","",$str);
	//echo $str; die;
	$str=explode("<metadata>",$str);
	$str=$str[1];
	$str=explode("</metadata>",$str);
	$str=$str[0];
	//echo $str;
	$a=explode("<dc:",$str);
	@reset($a);
	$result=Array();
	//skip first
	list($k,$v)=each($a);
	while (list($k,$v)=each($a)) {
		$val=explode("</dc:",$v);
		$val=$val[0];
		$val=explode(">",$v);
		//printr($val);
		$dckey=trim($val[0]);
		$dckey=ltrim($dckey);
		$dckey=explode(" ",$dckey);
		$dckey=$dckey[0];

		$dcval=trim($val[1]);
		$dcval=explode("</dc:",$dcval);
		$dcval=$dcval[0];
		@reset($mapdb);
		while (list($mapk,$mapv)=each($mapdb)) {
			while (list($mapvk,$mapvv)=each($mapv)) {
				//echo "looking for [$mapk -&gt; $mapvv] _in_ <b>$dckey</b> [$dcval]<br>\n";
				if ($dckey==$mapvv) { //found data addto resultarray
					$result[$mapk]=$result[$mapk]." ".$dcval;
				}
			}			
		}

	}
	//printr($result); die;
	//echo $str;
	//printr($aa);
	$sql="insert into index_db set
	remoteindex='oai-$s[code]',
	ispublish='yes',
	remoteindex_ref='$r[identifier]', ";
	@reset($indexdbfid);
	$chknull="";
	while (list($k,$v)=each($indexdbfid)) {
		if (trim($result[$k])!="" && ($result[$k])=="") {
			
		} else {
			$result[$k]=($result[$k]);
		}
		$chknull.=$result[$k];
		$sql.=" ".$indexdbfid[$k]."='".(addslashes(strip_tags($result[$k])))."',";
	}
	$sql.="";
	$sql=rtrim($sql,",");
	//echo "<pre>$sql</pre>"; die;
	if (trim($chknull)!="") {
		echo " ..done<br>";
		tmq($sql,false);
	} else {
		echo " ..skip empty<br>";
	}
	//echo "<pre>$sql</pre>";die;
	//die;
}

?></td>
</tr>
</table><?php 
redir("fetch.php?repid=$repid");
foot(); 
?>